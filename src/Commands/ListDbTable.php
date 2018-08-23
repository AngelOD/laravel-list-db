<?php

namespace AngelOD\LaravelListDb\Commands;

use Illuminate\Console\Command;
use AngelOD\LaravelListDb\TableLister;

class ListDbTable extends Command
{

    use \Illuminate\Console\DetectsApplicationNamespace;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'show:table {tableNames*} '
                            .'{--l|long : More information} '
                            .'{--f|full : All of the information} '
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
        $tableNames = $this->argument('tableNames');
        $exclude = $this->option('exclude');
        $long = $this->option('long');
        $full = $this->option('full');

        if ($full === true) {
            $toShow = TableLister::$fullToShow;
        } elseif ($long === true) {
            $toShow = TableLister::$longToShow;
        } else {
            $toShow = TableLister::$defaultToShow;
        }

        foreach ($tableNames as $tableName) {
            $columns = TableLister::getColumns($tableName);
            $output = TableLister::format($columns, $toShow, $exclude);

            $this->info('Table: ' . $tableName);
            $this->table($output['headers'], $output['rows']);
            $this->line('');
        }
    }
}
