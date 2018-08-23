<?php

namespace AngelOD\LaravelListDb\Commands;

use Illuminate\Console\Command;
use AngelOD\LaravelListDb\TableLister;
use Symfony\Component\Finder\Finder as SymfonyFinder;
use hanneskod\classtools\Iterator\ClassIterator;

class ListDbModels extends Command
{

    use \Illuminate\Console\DetectsApplicationNamespace;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'show:models '
                            .'{--s|short : Short and simple} '
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
        $short = $this->option('short');
        $exclude = $this->option('exclude');
        $long = $this->option('long');
        $full = $this->option('full');

        $finder = new SymfonyFinder();
        $finder->in(app_path());
        $iter = new ClassIterator($finder->files());
        $iter->enableAutoloading();

        $modelClasses = [];
        foreach ($iter->type('Illuminate\Database\Eloquent\Model') as $class) {
            $modelClasses[] = $class->getName();
        }

        if ($short === true) {
            $this->line('');

            foreach ($modelClasses as $modelClass) {
                $tableName = (new $modelClass)->getTable();
                $columns = [];

                foreach (TableLister::getColumns($tableName) as $column) {
                    $columns[] = $column->getName();
                }

                $this->info($modelClass . ':');
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

            foreach ($modelClasses as $modelClass) {
                $tableName = (new $modelClass)->getTable();
                $columns = TableLister::getColumns($tableName);
                $output = TableLister::format($columns, $toShow, $exclude);

                $this->info('Class: ' . $modelClass);
                $this->table($output['headers'], $output['rows']);
                $this->line('');
            }
        }
    }
}
