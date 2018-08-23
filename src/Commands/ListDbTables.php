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
    protected $signature = 'show:tables '
                            .'{--s|short : Very brief display (ignores exclude option)} '
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
        $exclude = $this->option('exclude');
        $short = $this->option('short');
        $long = $this->option('long');
        $full = $this->option('full');
        $tables = TableLister::getTables();

        if ($short === true) {
            $this->line('');

            foreach ($tables as $table) {
                $columns = [];

                foreach ($table->getColumns() as $column) {
                    $columns[] = $column->getName();
                }

                $this->info($table->getName() . ':');
                $this->info('    ' . implode(', ', $columns));
            }

            $this->line('');
        } else {
            if ($full === true) {
                $toShow = TableLister::$fullToShow;
            } elseif ($long === true) {
                $toShow = TableLister::$longToShow;
            } else {
                $toShow = TableLister::$defaultToShow;
            }

            foreach ($tables as $table) {
                $columns = $table->getColumns();
                $output = TableLister::format($columns, $toShow, $exclude);

                $this->info('Table: ' . $table->getName());
                $this->table($output['headers'], $output['rows']);
                $this->line('');
            }
        }
    }
}
