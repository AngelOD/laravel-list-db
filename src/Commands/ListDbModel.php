<?php

namespace A2Design\LaravelListDb\Commands;

use Illuminate\Console\Command;
use A2Design\LaravelListDb\TableLister;

class ListDbModel extends Command
{

    use \Illuminate\Console\AppNamespaceDetectorTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'model:columns {modelName}';

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
        $this->tableLister = new TableLister();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $modelName = $this->argument('modelName');
        $tableName = $this->getModelsTable($modelName);

        $columns = TableLister::getColumns($tableName);

        $output = TableLister::format($columns);

        $this->info(implode(', ', $output));
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
