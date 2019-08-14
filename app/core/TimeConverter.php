<?php
namespace core;

class TimeConverter
{    
    public static function convertStrToSeconds(string $time): int
    {
        $arrTime = explode(':', $time);
        $timeSeconds = $arrTime[0]*3600 + $arrTime[1]*60 + $arrTime[2];
        
        return $timeSeconds;
    }
    
    public static function convertSecondsToTimeFormat(int $timeSeconds): string
    {
        $hours = floor($timeSeconds / 3600);
        $minutes = floor(($timeSeconds / 60) % 60);
        $seconds = $timeSeconds % 60;
        
        return ($hours<10 ? "0" . $hours : $hours) . ":" . ($minutes<10 ? "0" . $minutes : $minutes) . ":" . ($seconds<10 ? "0" . $seconds : $seconds);
    }
}