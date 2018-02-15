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
    protected $signature = 'dbshow:model {modelNames*} {--f|format=%c#%t : columns format} {--e|exclude=id,created_at,updated_at : exclude specified columns}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Returns models\' table columns listing with specified formatting';


    private $__format = "%c#%t";
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

        foreach ($modelNames as $modelName) {
            $tableName = $this->getModelsTable($modelName);
            $format = $this->option('format');
            $columns = TableLister::getColumns($tableName);
            $output = TableLister::format($columns, $format);

            $this->info(implode(', ', $output));
        }
    }

    public function getModelsTable($modelName)
    {
        $appNamespace = $this->getAppNamespace();
        $namespacedModelName = str_replace('/', '\\', $modelName);
        $className = "{$appNamespace}{$namespacedModelName}";
        $tableName = (new $className)->getTable();

        return $tableName;
    }
}
