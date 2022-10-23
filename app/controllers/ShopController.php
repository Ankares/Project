<?php

namespace App\Controllers;

use App\Models\Repositories\ShopRepository;
use App\Models\ShopModel;
use App\Services\ShopService;
use Twig\Environment;

class ShopController 
{
    public function __construct(
        private readonly ShopService $shopService,
        private readonly Environment $twig,
        private readonly ShopModel $shopModel,
        private readonly ShopRepository $shopRepository
    )
    {}

    public function index()
    {
        $items = $this->shopRepository->getShopItems();
        echo $this->twig->render('/shop/index.php.twig', ['items' => $items]);
    }

    public function services($name)
    {
        $oneItem = $this->shopRepository->getOneItem($name);
        echo $this->twig->render('/shop/additionalServices.php.twig', ['item' => $oneItem]);
    }

    public function cart()
    {
        $items = null;
        $data = null;
        if (!isset($_SESSION['auth'])) {
            header('Location: /login');

            return;
        }
        if (isset($_POST['itemId'])) {
            $this->shopService->addItemToSession($_POST['itemId']);
        }
        $items = $this->shopService->getItemsFromSession();
        echo $this->twig->render('/shop/cart.php.twig', ['items' => $items, 'data' => $data]);
    }
}