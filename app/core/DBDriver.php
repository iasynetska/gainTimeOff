<?php
namespace core;

class DBDriver
{
    const FETCH_ALL = 'all';
    const FETCH_ONE = 'one';
    
    private $pdo;
    
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
    
    public function insert()
    {
        ;
    }
    
    public function update()
    {
        ;
    }
    
    public function delete()
    {
        ;
    }
}