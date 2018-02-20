<?php

namespace AngelOD\LaravelListDb;

use DB;

class TableLister
{


	public static $defaultExclude = ['id', 'created_at', 'updated_at'];
    public static $defaultToShow = ['name', 'type'];
    public static $longToShow = ['name', 'type', 'null', 'default', 'autoinc', 'unsigned', 'length', 'precision', 'scale', 'fixed'];
    public static $fullToShow = ['name', 'type', 'null', 'default', 'autoinc', 'unsigned', 'length', 'precision', 'scale', 'fixed', 'platform'];

    /**
     *
     */
    public static function getTables()
    {
        $tables = DB::connection()
                    ->getDoctrineSchemaManager()
                    ->listTables();

        return $tables;
    }

    /**
     *
     */
    public static function getColumns($tableName)
    {
        $columns = DB::connection()
                    ->getDoctrineSchemaManager()
                    ->listTableColumns($tableName);

        return $columns;
    }

    /**
     *
     */
    public static function format($columns, $toShow, $excludeList = ['id', 'created_at', 'updated_at'])
    {
        $toShowData = [
            'name' => function ($c) { return $c->getName(); },
            'type' => function ($c) { return $c->getType()->getName(); },
            'null' => function ($c) { return $c->getNotnull(); },
            'default' => function ($c) { return $c->getDefault(); },
            'autoinc' => function ($c) { return $c->getAutoincrement(); },
            'unsigned' => function ($c) { return $c->getUnsigned(); },
            'length' => function ($c) { return $c->getLength(); },
            'precision' => function ($c) { return $c->getPrecision(); },
            'scale' => function ($c) { return $c->getScale(); },
            'fixed' => function ($c) { return $c->getFixed(); },
            'platform' => function ($c) {
                $options = $c->getPlatformOptions();
                return implode(':', $options);
            }
        ];

        if (!is_array($excludeList)) {
            $excludeList = [];
        }

        $retVal = [
            'headers' => [],
            'rows' => [],
        ];

        foreach ($toShow as $entry) {
            $retVal['headers'][] = $entry;
        }

        foreach ($columns as $column) {
            if (in_array($column->getName(), $excludeList)) {
                continue;
            }

            $row = [];

            foreach ($toShow as $entry) {
                $row[$entry] = $toShowData[$entry]($column);
            }

            $retVal['rows'][] = $row;
        }

        return $retVal;
    }

}