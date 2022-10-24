<?php

namespace App\Models;

class ShopModel {

    public $serviceData = [
        'itemId' => '',
        'warranty' => 'off',
        'delivery' => 'off',
        'setUp' => 'off'
    ];

    public function setServiceData($data)
    {
        foreach ($data as $key => $value) {
            if (array_key_exists($key, $this->serviceData)) {
                $this->serviceData[$key] = $value;
            }
        }
    } 

    public function getServiceData()
    {
        $settedData = [];
        $data = $this->serviceData;
        foreach($data as $key => $value) {
            if ($value) {
                $settedData[$key] = $value;
            }
        }
        return $settedData;
    }
}