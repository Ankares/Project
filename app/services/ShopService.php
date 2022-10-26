<?php

namespace App\Services;

use App\Catalog;
use App\Models\Repositories\ShopRepository;
use App\Models\ShopItemsModel;
use App\Models\ShopServicesModel;

class ShopService
{
    private $sessionName = 'items';

    public function __construct(
        private readonly ShopRepository $shopRepository,
        private readonly ShopItemsModel $itemModel,
        private readonly ShopServicesModel $servicesModel,
        private readonly Catalog $catalog
    ) {}
    
    public function issetSession()
    {
        return isset($_SESSION[$this->sessionName]);
    }

    public function getSession()
    {
        if($this->issetSession()) {
            return $_SESSION[$this->sessionName];
        }
    }

    private function setItemAndServicesData($post)
    {
        $this->itemModel->setData($post);
        $this->servicesModel->setData($post);
    }

    private function getItemAndServicesData()
    {
        $item = $this->itemModel->getData();
        $services = $this->servicesModel->getData();

        if ($item['itemId'] == $services['itemId']) {
            return [
                'item' => $item,
                'services' => $services
            ];
        }
    }

    public function addItemToSession($post)
    {
        $itemExist = false;

        if (!$post) {
            return;
        }

        $this->setItemAndServicesData($post);
        $itemData = $this->getItemAndServicesData();
        $data = [...$itemData['item'],...$itemData['services']];

        if (!$this->issetSession()) {
            $_SESSION[$this->sessionName] = [$data];
            return;
        }

        foreach ($_SESSION[$this->sessionName] as $item) {
            if ($item && $item['itemId'] == $post['itemId']) {
                $itemExist = true;
            } 
        }

        if($itemExist === false) {
            $session = $_SESSION[$this->sessionName];
            array_push($session, $data);  
            $_SESSION[$this->sessionName] = $session;
        }
    }
}