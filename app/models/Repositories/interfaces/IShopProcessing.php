<?php

namespace App\Models\Repositories\Interfaces;

use App\Catalog;

interface IShopProcessing
{
    public function getAllProducts(Catalog $catalogObj);
    public function getOneProduct(Catalog $catalogObj, $name);
    public function getProductServices(Catalog $catalogObj, $itemId);
}