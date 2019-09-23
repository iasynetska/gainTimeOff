<?php
namespace core;

class ComplitedTaskDBDriver extends DBDriver
{
    public  function deleteComplitedTasksByKid($nameTable, int $kidId)
    {
        $sql = sprintf('DELETE FROM %s WHERE task_id IN (SELECT id FROM tasks WHERE kid_id=:kid_id)', $nameTable);
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':kid_id', $kidId);
        $stmt->execute();
    }
}