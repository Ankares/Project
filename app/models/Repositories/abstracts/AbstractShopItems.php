<?php

namespace App\Models\Repositories\Abstracts;

use App\Models\Repositories\Interfaces\IShopProcessing;
use App\Models\ShopModel;

abstract class AbstractShopItems implements IShopProcessing
{
    abstract public function getProductData(ShopModel $model);
}