<?php


namespace App\services;


class Censurator
{

    /**
     * Fonction qui permet de verifier la présence de mots interdits
     * dans une chaine de caractère et de les remplacer par des *****.
     * @param String $text
     * @return String
     */
    public function purify(String $text):String{
        $search = ['toto', 'titi', 'tata'];
        $remplace = '******';

        return str_ireplace($search, $remplace, $text);
    }
}