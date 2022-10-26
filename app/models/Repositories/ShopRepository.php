<?php

namespace App\Models\Repositories;

use App\Catalog;
use App\Models\Repositories\Interfaces\IShopProcessing;

class ShopRepository implements IShopProcessing
{

    public function getAllProducts(Catalog $catalogObj)
    {
        $items = [];
        foreach($catalogObj->itemCatalog as $item) {
            array_push($items, $item);
        }
        return $items;
    }

    public function getOneProduct(Catalog $catalogObj, $itemId)
    {
        $neededItem = null;
        foreach($catalogObj->itemCatalog as $item) {
            if ($itemId == $item['id']) {
                $neededItem = $item;
            }
        }
        return $neededItem;
    }

    public function getProductServices(Catalog $catalogObj, $itemId)
    {
        $itemServices = null;
        foreach($catalogObj->itemServices as $services) {
            if ($itemId == $services['itemId']) {
                $itemServices = $services;
            }
        }
        return $itemServices;
    }

}