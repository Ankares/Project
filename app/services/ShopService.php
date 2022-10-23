<?php

namespace App\Services;

use App\Models\Repositories\ShopRepository;
use App\Models\ShopModel;

class ShopService
{
    private $sessionName = 'items';

    public function __construct(
        private readonly ShopRepository $shopRepository,
        private readonly ShopModel $shopModel
    ) {}

    public function addItemToSession($id)
    {
        $itemExist = false;
        if (!$this->issetSession()) {
            $_SESSION[$this->sessionName] = $id;
            return;
        }
        $items = explode(',', $_SESSION[$this->sessionName]);
        foreach ($items as $item) {
            if ($item === $id) {
                $itemExist = true;
            }
        }
        if($itemExist === false) {
            $_SESSION[$this->sessionName] = $_SESSION[$this->sessionName].','.$id;
        }
       
    }

    private function issetSession()
    {
        return isset($_SESSION[$this->sessionName]);
    }

    private function getSession()
    {
        return $_SESSION[$this->sessionName];
    }

    public function getItemsFromSession()
    {
        $items = null;
        if ($this->issetSession()) {
            $session = $this->getSession();
            $items = $this->shopRepository->getSessionItems($session);
        }
        return $items;
    }
}