<?php

namespace App\Jobs;

use App\Account;
use App\CheckDomain;
use App\Poll;
use App\PollOption;
use App\Server;
use App\Status;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use stdClass;

class MastodonApiPublicTimelineJob extends Job
{
    private $server;

    /**
     * Create a new job instance.
     *
     * @param Server $server
     */
    public function __construct(Server $server)
    {
        $this->server = $server;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try{
            $this->doWork();
        } catch (GuzzleException $e) {
            $this->fail($e);
        }
    }

    /**
     * @throws GuzzleException
     */
    private function doWork()
    {
        $uri = '/api/v1/timelines/public';
        if (!is_null($this->server->since_id)) {
            $uri .= '?since_id=' . $this->server->since_id;
        }

        $response = (new Client([
            'base_uri' => $this->server->domain
        ]))->request('GET', $uri, ['headers' => ['Accept' => 'application/json', 'Content-type' => 'application/json']]);

        if ($response->getStatusCode() === 200) {
            $json = json_decode($response->getBody()->getContents());
            if (count($json) > 0) {
                $this->server->update(['last_scraped_at' => Carbon::now(), 'since_id' => $json[0]->id]);
            } else {
                $this->server->update(['last_scraped_at' => Carbon::now()]);
            }

            $statusCount = count($json);
            $pollsFound = 0;

            foreach ($json as $status) {
                if ($status->visibility != Status::PUBLIC) {
                    continue;
                }

                // $this->discoverServers($status);

                if (isset($status->poll) && !is_null($status->poll)) {
                    $pollsFound++;
                    $this->parseStatus($status);
                }
            }

            $this->server->update([
                'statuses_parsed' => $this->server->statuses_parsed + $statusCount,
                'polls_found' => $this->server->polls_found + $pollsFound,
                'scraped' => $this->server->scraped + 1,
            ]);

            $retry = $statusCount === 20;

            if ($retry) {
                dispatch(new MastodonApiPublicTimelineJob($this->server));
            }
        }
    }

    private function discoverServers(stdClass $status){
        $domains = [];
        $domains[] = sprintf('https://%s', parse_url($status->account->url, PHP_URL_HOST));

        foreach ($status->mentions as $mention) {
            $domains[] = sprintf('https://%s', parse_url($mention->url, PHP_URL_HOST));
        }

        foreach (array_unique($domains) as $domain) {
            if (Server::whereDomain($domain)->count() === 0) {
                dispatch(new AddServerJob(new CheckDomain($domain)));
            }
        }
    }

    private function parseStatus(stdClass $status)
    {
        $accountFields = [
            'id' => $status->account->id,
            'username' => $status->account->username,
            'acct' => $status->account->acct,
            'display_name' => $status->account->display_name,
            'locked' => $status->account->locked,
            'bot' => $status->account->bot,
            'created_at' => Carbon::createFromTimeString($status->account->created_at),
            'note' => $status->account->note,
            'url' => $status->account->url,
            'avatar' => $status->account->avatar,
            'avatar_static' => $status->account->avatar_static,
            'header' => $status->account->header,
            'header_static' => $status->account->header_static,
            'followers_count' => $status->account->followers_count,
            'following_count' => $status->account->following_count,
            'statuses_count' => $status->account->statuses_count
        ];

        /** @var null|Account $accountModel */
        if ($accountModel = $this->server->accounts()->where('id', '=', $status->account->id)->first()) {
            $accountModel->update($accountFields);
        } else {
            $accountModel = $this->server->accounts()->save(new Account($accountFields));
        }

        $statusFields = [
            'server_id' => $this->server->local_id,
            'id' => $status->id,
            'in_reply_to_id' => $status->in_reply_to_id,
            'in_reply_to_account_id' => $status->in_reply_to_account_id,
            'sensitive' => $status->sensitive,
            'spoiler_text' => $status->spoiler_text,
            'visibility' => $status->visibility,
            'language' => $status->language,
            'uri' => $status->uri,
            'url' => $status->url,
            'replies_count' => $status->replies_count,
            'reblogs_count' => $status->reblogs_count,
            'favourites_count' => $status->favourites_count,
            'content' => $status->content,
        ];

        /** @var Status $statusModel */
        if ($statusModel = $accountModel->status()->where('id', '=', $status->id)->first()) {
            $statusModel->update($statusFields);
        } else {
            $statusModel = $accountModel->status()->save(new Status($statusFields));
        }

        if (!is_null($status->poll)) {

            $pollFields = [
                'id' => $status->poll->id,
                'expires_at' => $status->poll->expires_at,
                'expired' => $status->poll->expired,
                'multiple' => $status->poll->multiple,
                'votes_count' => $status->poll->votes_count,
            ];

            if (!is_null($statusModel->poll)) {
                $statusModel->poll->update($pollFields);
            } else {
                $statusModel->poll()->save(new Poll($pollFields));
            }

            foreach ($status->poll->options as $opt) {
                if ($option = $statusModel->poll->options()->where('id', '=', $opt->id)) {
                    $option->update($pollFields);
                } else {
                    $statusModel->poll->options()->save(new PollOption($pollFields));
                }
            }
        }
    }
}
