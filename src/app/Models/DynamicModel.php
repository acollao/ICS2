<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DynamicModel extends Model
{
    private static array $modelClassToTableMap = [];

     /**
     * Protected constructor to make sure this is called from either
     * DynamicModel::table or internal static methods of Model. Otherwise, we cannot
     * track the class name related to the table
     */
    protected function __construct(array $attributes = [], ?string $table = null)
    {
        if (isset($table)) {
            // use table passed from DynamicModel::table
            $this->setTable($table);
        } elseif (isset(self::$modelClassToTableMap[\get_class($this)])) {
            // restore used table from map while internally creating new instances
            $this->setTable(self::$modelClassToTableMap[\get_class($this)]);
        } else {
            throw new \LogicException('Call DynamicModel::table to get a new instance and be able use any static model method.');
        }

        parent::__construct($attributes);
    }

    public static function table(string $table): self
    {
        return new class([], $table) extends DynamicModel {};
    }

    public function setTable($table): self
    {
        self::$modelClassToTableMap[\get_class($this)] = $table;

        return parent::setTable($table);
    }
}
