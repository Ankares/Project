<?php

namespace App\Models\Repositories;

use App\Models\Repositories\Abstracts\AbstractShopItems;
use App\Catalog;
use App\Models\ShopModel;

class ShopRepository extends AbstractShopItems
{
    
    public function getProductData(ShopModel $model)
    {
        return $model->getChosenItemData();
    }
    
    public function getAllProducts(Catalog $catalogObj)
    {
        $items = [];
        foreach($catalogObj->catalog as $item) {
            array_push($items, $item);
        }
        return $items;
    }

    public function getOneProduct(Catalog $catalogObj, $name)
    {
        $neededItem = null;
        foreach($catalogObj->catalog as $item) {
            if ($name == $item['item']) {
                $neededItem = $item;
            }
        }
        return $neededItem;
    }

}