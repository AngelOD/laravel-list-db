<?php

namespace A2Design\LaravelListDb;

class TableLister 
{


	public static $defaultExclude = ['id', 'created_at', 'updated_at'];

    public static function getColumnListing($tableName)
    {
        $columns = DB::connection()
          ->getDoctrineSchemaManager()
          ->listTableColumns($tableName);

        return $columns;
    }

    public static function formatColumns($columns, $format = "%c#%t", $excludeList = self::$defaultExclude])
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