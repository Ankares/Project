<?php

namespace App\Models;

class ShopModel {
    
    private $chosenItemData = [
        'itemName' => '',
        'warranty' => '',
        'delivery' => '',
        'setUp' => ''
    ];

    public function setChosenItemData($data)
    {
        foreach ($data as $key => $value) {
            if (array_key_exists($key, $this->chosenItemData)) {
                $this->chosenItemData[$key] = $value;
            }
        }
    } 

    public function getChosenItemData()
    {
        $settedData = [];
        $data = $this->chosenItemData;
        foreach($data as $key => $value) {
            if ($value) {
                $settedData[$key] = $value;
            }
        }
        return $settedData;
    }
}