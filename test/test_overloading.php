<?php

class Sum
{
    //private $sum = 10;
    
    function getSum($num)
    {
       //echo "Sum is: ".$this->sum; 
       echo "Sum is: ".($num*2)."<br />"; 
    }
    
    public static function getNewSum($num)
    {
       echo "Sum is: ".($num*10)."<br />"; 
    }
    
//    function __call($name, $arguments)
//    {
//        echo "<br />Calling method: ".$name."; with arguments: ".implode(", ",$arguments);
//    }
    
    function __call($name, $arguments)
    {
        $sum = 0;
        foreach($arguments as $num) 
        {
        $sum += $num;
        }
        echo "__call: ";
        $this->getSum($sum);
    }
    
    public static function __callStatic($name, $arguments) {
        $sum = 0;
        foreach($arguments as $num) 
        {
        $sum += $num;
        }
        echo "__call_Static: ";
        self::getNewSum($sum);
    }
    
}



$result = new Sum();
$result->getSum(2, 5);
//$result->calculate();
$result->getYears(2000, 2015, 2010);
$result::getMonth(10, 20);