<?php

namespace App\Services;

use App\Catalog;
use App\Models\Repositories\ShopRepository;
use App\Services\ShopService;

class CartService
{
    public function __construct(
        private readonly ShopService $shopService,
        private readonly ShopRepository $shopRepository,
        private readonly Catalog $catalog
    ){}
    
    public function getItemsFromSession()
    {
        $itemsWithChosenServices = [];
        $itemInSession = '';
        if ($this->shopService->issetSession()) {
            $session = $this->shopService->getSession();
            foreach ($session as $sessionItem) {
                if ($sessionItem) {
                    $itemInSession = $sessionItem['itemId'];
                    $item = $this->shopRepository->getOneProduct($this->catalog, $itemInSession);
                    $itemServices = $this->shopRepository->getProductServices($this->catalog, $itemInSession);
                    if ($item['id'] == $itemServices['itemId']) {
                        $items[] = [...$item];
                        foreach ($items as $oneItemFromArray) {
                            if ($oneItemFromArray['id'] === $itemServices['itemId']) {
                                if (!empty($sessionItem['warranty'])) {
                                    $oneItemFromArray = [...$oneItemFromArray, 'warrantyPeriod' => $itemServices['warranty'], 'warrantyCost' => $itemServices['warrantyCost']];
                                }
                                if (!empty($sessionItem['delivery'])) {
                                    $oneItemFromArray = [...$oneItemFromArray, 'deliveryPeriod' => $itemServices['delivery'], 'deliveryCost' => $itemServices['deliveryCost']];
                                }
                                if (!empty($sessionItem['setUp'])) {
                                    $oneItemFromArray = [...$oneItemFromArray, 'setupCost' => $itemServices['setupCost']];
                                }
                                $itemsWithChosenServices[] = $oneItemFromArray;
                            }    
                        }   
                    }
                }
            }            
        }
        return $itemsWithChosenServices; // all session data = item + chosen services (for next displaying)
    }
}