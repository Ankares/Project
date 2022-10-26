<?php

namespace App\Models\Repositories\Abstracts;

abstract class AbstractShopItemsProcessing
{
    abstract public function setData($data);
    abstract public function getData();
}