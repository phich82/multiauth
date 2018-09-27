<?php

namespace App\Commons\Traits;

trait SupportTableTrait
{
    /**
     * Get table name from model
     *
     * @return string
     */
    public static function getTableName()
    {
        return with(new static)->getTable();
    }

    /**
     * Get name of primary key from model
     *
     * @return string
     */
    public static function getPrimaryKey()
    {
        return with(new static)->getKeyName();
    }
}
