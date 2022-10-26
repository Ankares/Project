<?php

namespace App\Controllers;

use App\Catalog;
use App\Models\Repositories\ShopRepository;
use App\Services\CartService;
use App\Services\ShopService;
use Twig\Environment;

class ShopController 
{
    public function __construct(
        private readonly ShopService $shopService,
        private readonly CartService $cartService,
        private readonly ShopRepository $shopRepository,
        private readonly Catalog $catalog,
        private readonly Environment $twig 
    )
    {}

    public function index()
    {
        $items = $this->shopRepository->getAllProducts($this->catalog);
        echo $this->twig->render('/shop/index.php.twig', ['items' => $items]);
    }

    public function services($id)
    {
        $oneItem = $this->shopRepository->getOneProduct($this->catalog, $id);
        $itemServices = $this->shopRepository->getProductServices($this->catalog, $id);
        echo $this->twig->render('/shop/additionalServices.php.twig', ['item' => $oneItem, 'itemServices' => $itemServices]);
    }

    public function cart()
    {
        if (!isset($_SESSION['auth'])) {
            header('Location: /dashboard');

            return;
        }
        if (isset($_POST['itemId'])) {
            $this->shopService->addItemToSession($_POST);
        }
        $session = $this->shopService->getSession();
        $items = $this->cartService->getItemsFromSession();
        echo $this->twig->render('/shop/cart.php.twig', ['items' => $items ?? null, 'session' => $session]);
    }
}