<?php

namespace App\Models\Repositories\Interfaces;

interface IShopProcessing
{
    public function getAllProducts();
    public function getOneProductById($productId);
    public function getOneProductServices($productId);
}
