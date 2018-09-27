<?php

namespace App\Commons\Traits;

use Exception;
use Illuminate\Support\Facades\DB;

trait BulkCRUDTrait
{
    /**
     * Update the multiple records at once time
     *
     * Notes: only apply for MySQL
     *
     * @param  array $records
     * @param  string $primaryKey
     * @param  string $table
     *
     * @return bool
     */
    public static function updateMany($records = [], $primaryKey = null, $table = null)
    {
        if (static::isDatabaseSupported()) {
            $table = $table ? $table : (new static)->getTable();
            $primaryKey = $primaryKey ? $primaryKey : (new static)->getKeyName();

            $container = [];
            foreach ($records as $record) {
                $id = $record[$primaryKey];
                unset($record[$primaryKey]);
                $container['in'][] = $id;
                foreach ($record as $column => $value) {
                    $container[$column]['params'][] = $id;    // 1st => ?
                    $container[$column]['params'][] = $value; // 2nd => ?
                    $container[$column]['sql'][] = 'WHEN ? THEN ?';
                }
            }

            $sql = 'UPDATE `'.$table.'` SET ';
            $params = [];
            $in = $container['in'];
            unset($container['in']);
            foreach ($container as $column => $row) {
                $params = array_merge($params, $row['params']);
                $sql .= '`'.$column.'`=CASE `'.$primaryKey.'` '.implode(' ', $row['sql']).' END, ';
            }
            $sql = rtrim(trim($sql), ',');
            $sql .= ' WHERE `'.$primaryKey.'` IN ('.implode(',', $in).')';
            $params = array_merge($params, $in);

            return DB::statement($sql, $params);
        }
        throw new Exception('Method [updateMany] is only supported for database [mysql]');
    }

    /**
     * Check database whether it is supported for creating updateMany function
     *
     * @return bool
     */
    private static function isDatabaseSupported()
    {
        return config('database.default') == 'mysql';
    }
}
