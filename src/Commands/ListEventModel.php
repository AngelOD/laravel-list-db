<?php

namespace AngelOD\LaravelListDb\Commands;

use Illuminate\Console\Command;

class ListEventModel extends Command
{

    use \Illuminate\Console\DetectsApplicationNamespace;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'show:events {modelNames*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Returns models\' event names';


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
        $modelNames = $this->argument('modelNames');

        foreach ($modelNames as $modelName) {
            $className = $this->getClassName($modelName);
            $events = (new $className)->getObservableEvents();
            $rows = [];

            foreach ($events as $event) {
                $rows[] = ['Event' => $event];
            }

            $this->info('Class: ' . $this->getClassName($modelName));
            $this->table(['Event'], $rows);
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
}
