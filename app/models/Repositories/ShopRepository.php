<?php

namespace App\Models\Repositories;

use App\Catalog;
use App\Models\Repositories\Interfaces\IShopProcessing;

class ShopRepository implements IShopProcessing
{
    public function __construct(
        private readonly Catalog $calatog
    ) {
    }
    public function getAllProducts()
    {
        $items = [];
        foreach ($this->calatog->itemCatalog as $item) {
            array_push($items, $item);
        }

        return $items;
    }

    public function getOneProductById($productId)
    {
        $neededItem = null;
        foreach ($this->calatog->itemCatalog as $item) {
            if ($productId == $item['id']) {
                $neededItem = $item;
            }
        }

        return $neededItem;
    }

    public function getOneProductServices($productId)
    {
        $itemServices = null;
        foreach ($this->calatog->itemServices as $services) {
            if ($productId == $services['itemId']) {
                $itemServices = $services;
            }
        }

        return $itemServices;
    }
}
