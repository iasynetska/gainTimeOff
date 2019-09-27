<?php
namespace models;

use core\DbConnection;
use core\DBDriver;
use core\Exceptions\ValidatorException;
use Exception;
use models\entities\UserKid;

class TimeFacade
{
    private $kidModel;
    private $timeToPlayModel;
    
    public function __construct()
    {
        $this->kidModel = new KidModel(new DBDriver(DbConnection::getPDO()));
        $this->timeToPlayModel = new TimeToPlayModel(new DBDriver(DbConnection::getPDO()));
    }
    
    public function saveTimeAndChangeKidTime(UserKid $kid, $timePlayed)
    {
        try
        {
            DbConnection::getPDO()->beginTransaction();
            
            $this->timeToPlayModel->saveTime([
                'time' => $timePlayed,
                'date' => date('Y/m/d'),
                'kid_id' => $kid->getId()
            ]);
            
            $this->kidModel->changeKidTime($kid, $timePlayed);
            
            DbConnection::getPDO()->commit();
        }
        catch (ValidatorException $e)
        {
            DbConnection::getPDO()->rollBack();
            throw $e;
        }
        catch (Exception $e)
        {
            DbConnection::getPDO()->rollBack();
            throw $e;
        }
    }
}