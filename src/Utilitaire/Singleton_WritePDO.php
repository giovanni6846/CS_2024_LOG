<?php

namespace App\Utilitaire;

use PDO;

class Singleton_WritePDO extends PDO
{
    protected static ?PDO $_PDO = null;
    private function __construct()
    {
        $myFile = "paramBDDWrite.txt";
        $lines = file($myFile);//file in to an array
        foreach($lines as $line)
        {
            $var = explode(' ', $line, 2);
            if(!isset($var[1]))
                $var[1] = "";
            $arr[$var[0]] = trim($var[1]);
        }

        parent::__construct('mysql:host='.$arr["IPBDD"].';dbname='.$arr["BDD"].';charset=UTF8',
            $arr["USERBDD"],
            $arr["MDPBDD"],
            array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));

    }

    public static function getInstance(): PDO
    {

        if (is_null(self::$_PDO)) {
            self::$_PDO = new Singleton_WritePDO();
        }
        return self::$_PDO;
    }
}