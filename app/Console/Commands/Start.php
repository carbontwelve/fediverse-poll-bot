<?php

namespace App\Console\Commands;

use App\Jobs\MastodonApiPublicTimelineJob;
use App\Server;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;

// @todo Run this on a minute cron
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
        /** @var Collection|Server[] $servers */
        $servers = Server::all();

        if ($servers->count() === 0) {
            $this->line('<error>[!]</error> You have not yet configured any servers, please use the <info>server:add</info> command to do so');
            return 1;
        }

        foreach ($servers as $server) {
            dispatch(new MastodonApiPublicTimelineJob($server));
        }

        $this->line('Dispatched <info>'. count($servers).'</info> jobs.');

        return 0;
    }
}
