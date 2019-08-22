<?php

namespace App\Console\Commands;

use App\Jobs\MastodonApiPublicTimelineJob;
use App\Servers;
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
        $model = new Servers(['domain' => $this->argument('domain')]);

        $model->save();

        dd($model);
    }
}
