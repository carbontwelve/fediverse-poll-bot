<?php

namespace App\Console\Commands;

use App\Jobs\MastodonApiPublicTimelineJob;
use App\Server;
use Illuminate\Console\Command;

class Info extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'server:info';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Returns a table containing server info';

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
        // Add server mastodon/pleroma version...

        $headers = ['Domain', 'Added On',  'Last Scraped', '# Scraped', '# Parsed Status', '# Polls'];

        $users = Server::all(['domain', 'created_at', 'last_scraped_at', 'scraped', 'statuses_parsed', 'polls_found'])->toArray();

        $this->table($headers, $users);

        return 0;
    }
}
