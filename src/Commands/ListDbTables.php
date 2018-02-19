<?php

namespace AngelOD\LaravelListDb\Commands;

use Illuminate\Console\Command;
use AngelOD\LaravelListDb\TableLister;

class ListDbTables extends Command
{

    use \Illuminate\Console\DetectsApplicationNamespace;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dbshow:tables '
                            .'{--s|short : Only list the names} '
                            .'{--l|long : More information} '
                            .'{--v|verbose : All of the information} '
                            .'{--e|exclude=id,created_at,updated_at : exclude specified columns}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Returns table columns listing with specified formatting';


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
        $short = $this->option('short');
        $long = $this->option('long');
        $verbose = $this->option('verbose');
        $tables = TableLister::getTables();

        if ($short === true) {
            foreach ($tables as $table) {
                $this->info($table->getName());
            }

            $this->line('');
        } else {
            if ($verbose === true) {
                $toShow = TableLister::$verboseToShow;
            } elseif ($long === true) {
                $toShow = TableLister::$longToShow;
            } else {
                $toShow = TableLister::$defaultToShow;
            }

            foreach ($tables as $table) {
                $columns = $table->getColumns();
                $output = TableList::format($columns, $toShow);

                $this->info('Table: ' . $tableName);
                $this->table($output['headers'], $output['rows']);
                $this->line('');
            }
        }
    }
}
