<?php

namespace App\Console\Commands;

use App\CheckDomain;
use App\Server;
use Illuminate\Console\Command;

class AddServer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'server:add {domain}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a server to the list for scraping';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // @todo check if domain supports polls. Mastodon added in 2.8.0. Check when Pleroma did...
        // @todo check domain has a valid mastodon api endpoint and error if not

        $validator = new CheckDomain($this->argument('domain'));

        if (!$validator->validate()){
            $this->line('<error>[!]</error> '. $validator->getError());
            return 1;
        }

        if (!$validator->create()) {
            $this->line('<error>[!]</error> '. $validator->getError());
            return 1;
        }

        $this->line("<info>[*]</info> successfully added <info>{$validator->getDomain()}</info>");
        return 0;
    }
}
