<?php

namespace AngelOD\LaravelListDb\Commands;

use Illuminate\Console\Command;
use AngelOD\LaravelListDb\TableLister;

class ListDbModel extends Command
{

    use \Illuminate\Console\DetectsApplicationNamespace;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dbshow:model {modelNames*} '
                            .'{--l|long : More information} '
                            .'{--f|full : All of the information} '
                            .'{--e|exclude=id,created_at,updated_at : exclude specified columns}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Returns models\' table columns listing with specified formatting';


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->tableLister = new TableLister();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $modelNames = $this->argument('modelNames');
        $long = $this->option('long');
        $full = $this->option('full');

        if ($full === true) {
            $toShow = TableLister::$fullToShow;
        } elseif ($long === true) {
            $toShow = TableLister::$longToShow;
        } else {
            $toShow = TableLister::$defaultToShow;
        }

        foreach ($modelNames as $modelName) {
            $tableName = $this->getModelsTable($modelName);
            $columns = TableLister::getColumns($tableName);
            $output = TableLister::format($columns, $toShow);

            $this->info('Class: ' . $this->getClassName($modelName));
            $this->table($output['headers'], $output['rows']);
            $this->line('');
        }
    }

    /**
     * 
     */
    protected function getClassName($modelName) {
        $appNamespace = $this->getAppNamespace();
        $namespacedModelName = str_replace('/', '\\', $modelName);
        $className = "{$appNamespace}{$namespacedModelName}";

        return $className;
    }

    /**
     * 
     */
    public function getModelsTable($modelName)
    {
        $className = $this->getClassName($modelName);
        $tableName = (new $className)->getTable();

        return $tableName;
    }
}
