<?php

namespace App\Models\Repositories\Interfaces;

interface IShopProcessing
{
    public function getAllProducts() : array;
    public function getOneProductById(int $productId) : array;
    public function getOneProductServices(int $productId) : array;
}
