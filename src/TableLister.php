<?php

namespace A2Design\LaravelListDb;

use DB;

class TableLister 
{


	public static $defaultExclude = ['id', 'created_at', 'updated_at'];

    public static function getColumns($tableName)
    {
        $columns = DB::connection()
          ->getDoctrineSchemaManager()
          ->listTableColumns($tableName);

        return $columns;
    }

    public static function format($columns, $format = "%c#%t", $excludeList = ['id', 'created_at', 'updated_at'])
    {
        $formatted = [];
        foreach ($columns as $key => $column) {
            if (in_array($column->getName(), $excludeList)) {
                continue;
            }
            $str = $format;
            $str = str_replace('%c', $column->getName(), $str);
            $str = str_replace('%t', $column->getType()->getName(), $str);

            $formatted[] = $str;
        }

        return $formatted;
    }
	
}