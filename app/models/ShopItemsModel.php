<?php

namespace App\Models;

use App\Models\Repositories\Abstracts\AbstractShopItemsProcessing;

class ShopItemsModel extends AbstractShopItemsProcessing {
    
    private $chosenItemData = [
        'itemId' => '',
        'itemName' => ''
    ];

    public function setData($itemData)
    {
        foreach ($itemData as $key => $value) {
            if (array_key_exists($key, $this->chosenItemData)) {
                $this->chosenItemData[$key] = $value;
            }
        }
    } 

    public function getData()
    {
        $settedItemData = [];
        $data = $this->chosenItemData;
        foreach($data as $key => $value) {
            if ($value) {
                $settedItemData[$key] = $value;
            }
        }
        return $settedItemData;
    }
}