<?php

namespace App\Services;

use App\Models\Repositories\ShopRepository;
use App\Models\ShopModel;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Twig\Environment;
use Twig\TwigTest;

class ShopService
{
    private $sessionName = 'items';

    public function __construct(
        private readonly ShopRepository $shopRepository,
        private readonly ShopModel $shopModel,
        private readonly Environment $twig,
    ) {}

    public function addItemToSession($post)
    {
        $itemExist = false;
        $this->shopModel->setServiceData($post);
        $data = $this->shopModel->getServiceData();
        if (!$this->issetSession()) {
            $_SESSION[$this->sessionName] = [$data];
            return;
        }
        foreach ($_SESSION[$this->sessionName] as $item) {
            if ($item['itemId'] == $post['itemId']) {
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

    public function getItemsInSessionFromDB()
    {
        $items = [];
        $idInSession = '';
        if ($this->issetSession()) {
            $session = $this->getSession();
            foreach ($session as $item) {
                $idInSession = $item['itemId'];
                $itemFromDB = $this->shopRepository->getSessionItemsFromDB($idInSession);
                array_push($items, $itemFromDB);
            }            
        }
        return $items;
    }
}