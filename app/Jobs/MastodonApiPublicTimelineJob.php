<?php

namespace App\Jobs;

use App\Accounts;
use App\Servers;
use Carbon\Carbon;
use GuzzleHttp\Client;
use stdClass;

class MastodonApiPublicTimelineJob extends Job
{
    private $server;

    /**
     * Create a new job instance.
     *
     * @param Servers $server
     */
    public function __construct(Servers $server)
    {
        $this->server = $server;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle()
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

            foreach ($json as $status) {
                $this->parseStatus($status);
            }

            $retry = count($json) === 20;

            if ($retry) {
                dispatch(new MastodonApiPublicTimelineJob($this->server));
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
            'created_at' => Carbon::createFromTimeString( $status->account->created_at),
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

        /** @var null|Accounts $account */
        if ($account = $this->server->accounts()->where('id', '=', $status->account->id)->first()) {
            $account->update($accountFields);
        } else {
            $account =  $this->server->accounts()->save(new Accounts($accountFields));
        }

    }
}
