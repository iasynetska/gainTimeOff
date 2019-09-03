<?php
namespace core;

class TimeConverter
{    
    public static function convertStrToSeconds(string $time): int
    {
        $arrTime = explode(':', $time);
//         $timeSeconds = $arrTime[0]*3600 + $arrTime[1]*60 + $arrTime[2];
        $timeSeconds = $arrTime[0]*3600 + $arrTime[1]*60;
        
        return $timeSeconds;
    }
    
    public static function convertSecondsToTimeFormat(int $timeSeconds): string
    {
        $sign = "";
        
        if($timeSeconds < 0)
        {
            $sign = "-";
            $timeSeconds = (-1) * $timeSeconds;
        }
        
        $hours = floor($timeSeconds / 3600);
        $minutes = floor(($timeSeconds / 60) % 60);
//         $seconds = $timeSeconds % 60;
        
//         return $sign . ($hours<10 ? "0" . $hours : $hours) . ":" . ($minutes<10 ? "0" . $minutes : $minutes) . ":" . ($seconds<10 ? "0" . $seconds : $seconds);
        return $sign . ($hours<10 ? "0" . $hours : $hours) . ":" . ($minutes<10 ? "0" . $minutes : $minutes);
    }
}