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
    
    public function saveItem(array $params)
    {
        return $this->dbDriver->insert($this->nameTable, $params);
    }
    
    public function updateItem(array $params, array $paramsCondition, $operator='AND')
    {
        return $this->dbDriver->update($this->nameTable, $params, $paramsCondition, $operator);
    }
    
    public function deleteItem(array $paramsCondition, $operator='AND')
    {
        return $this->dbDriver->delete($this->nameTable, $paramsCondition, $operator);
    }
}