<?php

namespace App\Models\Repositories\Abstracts;

abstract class AbstractShopData
{
    abstract public function setData($data);
    abstract public function getData();
}
