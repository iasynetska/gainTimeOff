<?php
namespace models;

use core\DBDriver;

class BaseModel
{
    protected $dbDriver;
    protected $nameTable;
    
    public function __construct(DBDriver $dbDriver, $nameTable)
    {
        $this->dbDriver = $dbDriver;
        $this->nameTable = $nameTable;
    }
    
    public function isExisting(string $nameColumn, string $valueColumn): bool
    {
        $sql = sprintf("SELECT * FROM %s WHERE %s =:value", $this->nameTable, $nameColumn);
        $items = $this->dbDriver->select($sql, ['value'=> $valueColumn], DBDriver::FETCH_ALL);
        $itemsCount = count($items);
        return $itemsCount > 0;
    }
    
    public function addItem(array $params)
    {
        return $this->dbDriver->insert($this->nameTable, $params);
    }
}