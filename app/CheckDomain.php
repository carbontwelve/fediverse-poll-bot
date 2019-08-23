<?php

namespace App;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use stdClass;

class CheckDomain
{

    /** @var string */
    private $domain;

    /** @var stdClass|null */
    private $domainInfo;

    /** @var string */
    private $error = '';

    public function __construct(string $domain)
    {
        $this->domain = $domain;
    }

    /**
     * @return string
     */
    public function getDomain(): string
    {
        return $this->domain;
    }

    /**
     * @return stdClass|null
     */
    public function getDomainInfo(): ?stdClass
    {
        return $this->domainInfo;
    }

    /**
     * @return string
     */
    public function getError(): string
    {
        return $this->error;
    }

    public function validate(): bool
    {
        //
        // Already exists in our database
        //
        if ($found = Server::whereDomain($this->domain)->first()) {
            $this->error = 'That domain already exists in the database.';
            return false;
        }

        $client = new Client([
            'base_uri' => $this->domain
        ]);

        //
        // 200 for https://$domain
        //
        try {
            $response = $client->request('GET', '/');
            if ($response->getStatusCode() !== 200) {
                $this->error = 'The domain did not respond with a 200 status code.';
                return false;
            }
        } catch (GuzzleException $e) {
            $this->error = $e->getMessage();
            return false;
        }

        //
        // 200 for /api/v1/instance - set to $domainInfo
        //
        try {
            $response = $client->request('GET', '/api/v1/instance', ['headers' => ['Accept' => 'application/json', 'Content-type' => 'application/json']]);
            if ($response->getStatusCode() !== 200) {
                $this->error = 'Domain does not support the Mastodon API.';
                return false;
            }

            $this->domainInfo = json_decode($response->getBody()->getContents());

        } catch (GuzzleException $e) {
            $this->error = $e->getMessage();
            return false;
        }

        return true;
    }

    public function create(): bool
    {
        $model = new Server([
            'version' => $this->domainInfo->version ?? 'unknown',
            'domain' => $this->domain,
            'thumbnail' => $this->domainInfo->thumbnail ?? null,
            'title' => $this->domainInfo->title ?? '',
            'description' => $this->domainInfo->description ?? '',
            'poll_limits' => $this->domainInfo->poll_limits ?? null
        ]);

        if ($model->save() === true) {
            return true;
        }

        $this->error = 'There was an error saving that domain to the database.';
        return false;
    }
}
