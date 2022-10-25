<?php

namespace App\Models\Repositories\Abstracts;

use App\Models\Repositories\Interfaces\IShopProcessing;
use App\Models\ShopModel;

abstract class AbstractItemServices implements IShopProcessing
{
    abstract public function setProductData(ShopModel $model, $services);
}