<?php

namespace App\Console\Commands;

use App\Jobs\MastodonApiPublicTimelineJob;
use App\Servers;
use Illuminate\Console\Command;

class Start extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start scraping for polls';

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
        /** @var Servers $server */
        foreach (Servers::all() as $server) {
            dispatch(new MastodonApiPublicTimelineJob($server));
        }
    }
}
