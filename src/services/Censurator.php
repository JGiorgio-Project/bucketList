<?php


namespace App\services;


class Censurator
{

    public function purify(String $text):String{
        $search = ['toto', 'titi', 'tata'];
        $remplace = '******';

        return str_ireplace($search, $remplace, $text);
    }
}