<?php

namespace A2Design\LaravelListDb\Commands;

use Illuminate\Console\Command;
use A2Design\LaravelListDb\TableLister;

class ListDbTable extends Command
{

    use \Illuminate\Console\AppNamespaceDetectorTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'table:columns {tableName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';


    private $__format = "%c#%t";
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
        $tableName = $this->argument('tableName');

        $columns = TableLister::getColumns($tableName);

        $output = TableLister::format($columns);

        $this->info(implode(', ', $output));
    }
}
