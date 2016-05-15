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
            $str = str_replace('%po', $column->getPlatformOptions(), $str);
            $str = str_replace('%nn', $column->getNotnull(), $str);
            $str = str_replace('%dt', $column->getDefault(), $str);
            $str = str_replace('%ai', $column->getAutoincrement(), $str);
            $str = str_replace('%c', $column->getName(), $str);
            $str = str_replace('%t', $column->getType()->getName(), $str);
            $str = str_replace('%u', $column->getUnsigned(), $str);
            $str = str_replace('%l', $column->getLength(), $str);
            $str = str_replace('%p', $column->getPrecision(), $str);
            $str = str_replace('%s', $column->getScale(), $str);
            $str = str_replace('%f', $column->getFixed(), $str);

            $formatted[] = $str;
        }

        return $formatted;
    }
	
}