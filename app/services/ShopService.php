<?php

namespace App\Services;

use App\Catalog;
use App\Models\Repositories\ServicesRepository;
use App\Models\Repositories\ShopRepository;
use App\Models\ShopModel;

class ShopService
{
    private $sessionName = 'items';

    public function __construct(
        private readonly ShopRepository $shopRepository,
        private readonly ServicesRepository $servicesRepository,
        private readonly ShopModel $shopModel,
        private readonly Catalog $catalog
    ) {}

    public function addItemToSession($post)
    {
        if (!$post) {
            return;
        }
        $itemExist = false;
        $this->servicesRepository->setProductData($this->shopModel, $post);
        $data = $this->shopRepository->getProductData($this->shopModel);
        if (!$this->issetSession()) {
            $_SESSION[$this->sessionName] = [$data];
            return;
        }
        foreach ($_SESSION[$this->sessionName] as $item) {
            if ($item && $item['itemName'] == $post['itemName']) {
                $itemExist = true;
            } 
        }
        if($itemExist === false) {
            $session = $_SESSION[$this->sessionName];
            array_push($session, $data);  
            $_SESSION[$this->sessionName] = $session;
        }
    }

    private function issetSession()
    {
        return isset($_SESSION[$this->sessionName]);
    }

    public function getSession()
    {
        if($this->issetSession()) {
            return $_SESSION[$this->sessionName];
        }
    }

    public function getItemsInSessionFromCatalog()
    {
        $items = [];
        $itemInSession = '';
        if ($this->issetSession()) {
            $session = $this->getSession();
            foreach ($session as $item) {
                if ($item) {
                    $itemInSession = $item['itemName'];
                    $itemFromCatalog = $this->shopRepository->getOneProduct($this->catalog, $itemInSession);
                    array_push($items, $itemFromCatalog);
                }
            }            
        }
        return $items;
    }
}