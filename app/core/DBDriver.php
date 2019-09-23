<?php
namespace core;

class DBDriver
{
    const FETCH_ALL = 'all';
    const FETCH_ONE = 'one';
    
    protected $pdo;
    
    public function __construct(\PDO $pdo) 
    {
        $this->pdo = $pdo;
    }
    
    public function select($sql, array $params = [], $fetch = self::FETCH_ALL) 
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        
        return $fetch === self::FETCH_ALL ? $stmt->fetchAll() : $stmt->fetch();
    }
    
    public function insert($table, array $params)
    {
        $columns = sprintf('(%s)', implode(', ', array_keys($params)));
        $masks = sprintf('(:%s)', implode(', :', array_keys($params)));
        
        $sql = sprintf('INSERT INTO %s %s VALUES %s', $table, $columns, $masks);
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
    }
    
    public function update($table, array $params, array $paramsCondition, $operator)
    {
        $set = array();
        $condition = array();
        
        while(list($key)=each($params)) {
            $set[] = $key . ' = :' . $key;
        }
        
        $setValues = implode($set, ',');
        
        while(list($key)=each($paramsCondition)) {
            $condition[] = $key . ' = :' . $key;
        }
        
        $setCondition = implode($condition, $operator);
        
        $sql = sprintf('UPDATE %s SET %s WHERE %s', $table, $setValues, $setCondition);
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array_merge($params, $paramsCondition));
    }
    
    public function delete($table, array $paramsCondition, $operator)
    {
        $condition = array();
        
        while(list($key)=each($paramsCondition)) {
            $condition[] = $key . ' = :' . $key;
        }
        
        $setCondition = implode($condition, $operator);
        
        $sql = sprintf('DELETE FROM %s WHERE %s', $table, $setCondition);
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($paramsCondition);
    }
}