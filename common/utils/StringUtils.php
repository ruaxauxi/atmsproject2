<?php
/**
 * Copyright (c) 2017 by Dang Vo
 */

/**
 * Created by PhpStorm.
 * User: dangvo
 * Date: 4/12/17
 * Time: 10:45 PM
 */

namespace common\utils;


 class StringUtils
{

    public static function SplitName($fullname){
        $fullname = trim($fullname);

        $fullname = preg_replace('/\s\s+/', ' ', $fullname);

        $parts = explode(" ", $fullname);

        $firstname = null;
        $lastname  = null;
        $middlename = null;

        if (count($parts) >=3){
            $partClone = $parts;

            $firstname =  end($partClone);
            //remove the last element
            array_pop($partClone);

            $lastname = $partClone[0];
            // remove first element
            //$partClone = array_shift($partClone)uns
            unset($partClone[0]);

            $middlename = implode(" ", $partClone);

        }

        if (count($parts) == 2){
            $lastname = $parts[0];
            $middlename  = null;
            $firstname = $parts[1];
        }elseif (count($parts) == 1){
            $firstname = $parts[0];
            $middlename = null;
            $lastname = null;
        }

        $firstname  = mb_convert_case($firstname, MB_CASE_TITLE, "UTF-8");
        $lastname = mb_convert_case($lastname, MB_CASE_TITLE, "UTF-8");
        $middlename = mb_convert_case($middlename, MB_CASE_TITLE, "UTF-8");

        return [
            'firstname' => $firstname,
            'lastname'  => $lastname,
            'middlename'  =>$middlename
        ];
    }

    public static function DateFormatConverter($date, $from, $to)
    {
        if (($date)){
            $str =  \DateTime::createFromFormat($from,$date)->format($to);
            
            return (!$str)?null:$str;
        }
        return null;
    }

}