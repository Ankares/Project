<?php

namespace App\Services;

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
    ) {
    }

    public function issetSession() : bool
    {
        return isset($_SESSION[$this->sessionName]);
    }

    public function getSession()
    {
        if ($this->issetSession()) {
            return $_SESSION[$this->sessionName];
        }
    }

    private function setItemAndServicesData(array $post) : void
    {
        $this->itemModel->setData($post);
        $this->servicesModel->setData($post);
    }

    private function getItemAndServicesData() : array
    {
        $product = $this->itemModel->getData();
        $services = $this->servicesModel->getData();

        if ($product['itemId'] == $services['itemId']) {
            return [
                'product' => $product,
                'services' => $services,
            ];
        }
    }

    public function addItemToSession(array $post) : void
    {
        $itemExist = false;

        $this->setItemAndServicesData($post);
        $itemData = $this->getItemAndServicesData();
        $data = [...$itemData['product'], ...$itemData['services']];

        if (!$this->issetSession()) {
            $_SESSION[$this->sessionName] = [$data];

            return;
        }

        foreach ($_SESSION[$this->sessionName] as $product) {
            if ($product && $product['itemId'] == $post['itemId']) {
                $itemExist = true;
                break;
            }
        }

        if ($itemExist === false) {
            $session = $_SESSION[$this->sessionName];
            array_push($session, $data);
            $_SESSION[$this->sessionName] = $session;
        }
    }
}
