<?php
namespace models;

use core\DBDriver;
use models\entities\UserKid;

class ReportReceivedMarksModel
{
    protected $dbDriver;

    public function __construct(DBDriver $dbDriver)
    {
        $this->dbDriver = $dbDriver;
    }

    public  function getReportReceivedMarks(UserKid $kid, String $startDate, String $endDate)
    {
        $sql = "
            SELECT s.name, m.name, rm.date FROM kids AS k
                JOIN subjects as s on s.kid_id = k.id
                LEFT JOIN marks as m on m.kid_id = k.id
                LEFT JOIN received_marks as rm on rm.subject_id = s.id AND rm.mark_id = m.id                
            where k.id=:kid_id AND ((rm.date>='$startDate' AND rm.date<'$endDate') OR rm.date is null) ORDER BY s.name, rm.date;
        ";
        $receivedMarks_result = $this->dbDriver->select($sql, [
            'kid_id' => $kid->getId()
            ],
            DBDriver::FETCH_ALL,
            \PDO::FETCH_NUM
        );

        if(!$receivedMarks_result) {
            return NULL;
        }

        return $this->prepareReport($receivedMarks_result);
    }

    private function prepareReport(array $receivedMarks_result) {
        $report = array();

        foreach ($receivedMarks_result as $receivedMark) {
            if(!array_key_exists($receivedMark[0], $report)) {
                is_null($receivedMark[2]) ? $report += [$receivedMark[0] => array()] : $report += [$receivedMark[0] => array($receivedMark[1])];
            }
            else {
                if(!is_null($receivedMark[2])) {
                    array_push($report[$receivedMark[0]], $receivedMark[1]);
                }
            }
        }
        return $report;
    }
}