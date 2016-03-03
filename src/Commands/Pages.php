<?php

namespace Rudivdme\BearContent\Commands;

use Rudivdme\BearContent\Models\Page;
use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;

class Pages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bear:pages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update page auto sections.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach((new Page)->all() as $page)
        {
        	$page->updateAutoSections();
        	$this->info("Updated page /" . $page->slug);
        }
    }
}
