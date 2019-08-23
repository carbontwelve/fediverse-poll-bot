<?php

namespace App\Jobs;

use App\CheckDomain;
use Exception;

class AddServerJob extends Job
{
    /** @var CheckDomain  */
    private $domain;

    /**
     * Create a new job instance.
     * @param CheckDomain $domain
     */
    public function __construct(CheckDomain $domain)
    {
        $this->domain = $domain;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (! $this->domain->validate()) {
            $this->fail(new Exception($this->domain->getError()));
            return;
        }
        if (! $this->domain->create()) {
            $this->fail(new Exception($this->domain->getError()));
        }
    }
}
