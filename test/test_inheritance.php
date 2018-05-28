<?php

class A
{
    public $wartosc_1 = 10;
    protected $wartosc_2 = 20;
    private $wartosc_3 = 30;
    
    public function wyswietl()
    {
        echo "wartosc_1 = ". $this->wartosc_1 . "<br />";
        echo "wartosc_2 = ". $this->wartosc_2 . "<br />";
        echo "wartosc_3 = ". $this->wartosc_3 . "<br />";
    }
    
    public static function doEcho()
    {
        echo "HELLO!";
    }
}


class B extends A
{
    public $wartosc_1 = 50;
    protected $wartosc_2 = 200;
    private $wartosc_3 = 100;
    public function wyswietl()
    {
        echo "wartosc_1 = ". $this->wartosc_1 . "<br />";
        echo "wartosc_2 = ". $this->wartosc_2 . "<br />";
        echo "wartosc_3 = ". $this->wartosc_3 . "<br />";
        parent::wyswietl();
        
        self::doEcho();
    }
}


$objA = new A();
$objB = new B();

echo "Zawartość obiektu \$objA: <br />";
echo $objA->wartosc_1 . "<br />";
//echo $objA->wartosc_2 . "<br />";
//echo $objA->wartosc_3 . "<br />";


$objA->wyswietl();

echo "<br />Zawartość obiektu \$objB: <br />";

$objB->wyswietl();


