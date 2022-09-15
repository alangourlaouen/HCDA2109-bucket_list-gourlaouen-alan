<?php

namespace App\Util;

class CensuratorService
{

    private $filters = ["connard", "con", "enfoiré"];


    public function __construct()
    {
    }

    public function purify(String $text): String
    {

        foreach ($this->filters as $filter) {
            $text = str_ireplace($filter, str_repeat('*', strlen($filter)), $text);
        }
        return $text;
    }
}
