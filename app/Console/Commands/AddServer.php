<?php

namespace App\Console\Commands;

use App\Jobs\MastodonApiPublicTimelineJob;
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
        // @todo check domain has a valid mastodon api endpoint and error if not

        $model = new Server(['domain' => $this->argument('domain')]);

        if (! $model->save()) {
            $this->line('<error>[!]</error> There was an error saving that domain to the database');
            return 1;
        }

        $this->line("<info>[*]</info> successfully added <info>{$model->domain}</info>");
        return 0;
    }
}
