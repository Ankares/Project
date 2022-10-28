<?php

namespace App\Models;

use App\Models\Repositories\Abstracts\AbstractShopData;

class ShopServicesModel extends AbstractShopData
{
    private $chosenServicesData = [
        'itemId' => '',
        'warranty' => '',
        'delivery' => '',
        'setUp' => '',
    ];

    public function setData(array $servicesData) : void
    {
        foreach ($servicesData as $key => $value) {
            if (array_key_exists($key, $this->chosenServicesData)) {
                $this->chosenServicesData[$key] = $value;
            }
        }
    }

    public function getData() : array
    {
        return array_filter($this->chosenServicesData); 
    }
}
