<?php
namespace core;

class CompletedTaskDBDriver extends DBDriver
{
    public function __construct(\PDO $pdo)
    {
        parent::__construct($pdo);
    }

    public function deleteCompletedTasksByKid($nameTable, int $kidId)
    {
        $sql = sprintf('DELETE FROM %s WHERE task_id IN (SELECT id FROM tasks WHERE kid_id=:kid_id)', $nameTable);
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':kid_id', $kidId);
        $stmt->execute();
    }
}