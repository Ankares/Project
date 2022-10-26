<?php

namespace App\Models;

use App\Models\Repositories\Abstracts\AbstractShopItemsProcessing;

class ShopServicesModel extends AbstractShopItemsProcessing {
    
    private $chosenServicesData = [
        'itemId' => '',
        'warranty' => '',
        'delivery' => '',
        'setUp' => ''
    ];

    public function setData($servicesData)
    {
        foreach ($servicesData as $key => $value) {
            if (array_key_exists($key, $this->chosenServicesData)) {
                $this->chosenServicesData[$key] = $value;
            }
        }
    } 

    public function getData()
    {
        $settedServicesData = [];
        $services = $this->chosenServicesData;
        foreach($services as $key => $value) {
            if ($value) {
                $settedServicesData[$key] = $value;
            }
        }
        return $settedServicesData;
    }
}