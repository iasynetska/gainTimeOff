<?php
namespace core;

class ReceivedMarkDBDriver extends DBDriver
{
    public function __construct(\PDO $pdo)
    {
        parent::__construct($pdo);
    }
    
    public  function deleteReceivedMarksByKid($nameTable, int $kidId)
    {
        $sql = sprintf('DELETE FROM %s WHERE mark_id IN (SELECT id FROM marks WHERE kid_id=:kid_id)', $nameTable);
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':kid_id', $kidId);
        $stmt->execute();
    }
}