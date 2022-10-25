<?php

namespace App\Models\Repositories;

use App\Catalog;
use App\Models\Repositories\Abstracts\AbstractItemServices;
use App\Models\ShopModel;

class ServicesRepository extends AbstractItemServices
{
    public function setProductData(ShopModel $model, $services)
    {
        $model->setChosenItemData($services);
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