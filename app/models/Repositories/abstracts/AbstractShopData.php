<?php

namespace App\Models\Repositories\Abstracts;

abstract class AbstractShopData
{
    abstract public function setData(array $data) : void;
    abstract public function getData() : array;
}
