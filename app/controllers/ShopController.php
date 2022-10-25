<?php

namespace App\Controllers;

use App\Catalog;
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
        private readonly ShopRepository $shopRepository,
        private readonly Catalog $catalog
    )
    {}

    public function index()
    {
        $items = $this->shopRepository->getAllProducts($this->catalog);
        echo $this->twig->render('/shop/index.php.twig', ['items' => $items]);
    }

    public function services($name)
    {
        $oneItem = $this->shopRepository->getOneProduct($this->catalog, $name);
        echo $this->twig->render('/shop/additionalServices.php.twig', ['item' => $oneItem]);
    }

    public function cart()
    {
        if (!isset($_SESSION['auth'])) {
            header('Location: /dashboard');

            return;
        }
        if (isset($_POST['itemName'])) {
            $this->shopService->addItemToSession($_POST);
        }
        $session = $this->shopService->getSession();
        $items = $this->shopService->getItemsInSessionFromCatalog();
        echo $this->twig->render('/shop/cart.php.twig', ['items' => $items ?? null, 'session' => $session]);
    }
}