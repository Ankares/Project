<?php

namespace App\Models;

use App\Models\Repositories\Abstracts\AbstractShopData;

class ShopItemsModel extends AbstractShopData
{
    private $chosenItemData = [
        'itemId' => '',
        'itemName' => '',
    ];

    public function setData(array $itemData) : void
    {
        foreach ($itemData as $key => $value) {
            if (array_key_exists($key, $this->chosenItemData)) {
                $this->chosenItemData[$key] = $value;
            }
        }
    }

    public function getData() : array
    {
        return array_filter($this->chosenItemData); 
    }
}
