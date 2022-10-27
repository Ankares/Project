<?php

namespace App\Services;

use App\Catalog;
use App\Models\Repositories\ShopRepository;

class CartService
{
    public function __construct(
        private readonly ShopService $shopService,
        private readonly ShopRepository $shopRepository,
        private readonly Catalog $catalog
    ) {
    }

    private function createArrayWithSelectedServices($product, $productServices, $sessionProduct)
    {
        if ($product['id'] != $productServices['itemId']) {
            return;
        }

        $totalPrice = $product['price'];

        if (!empty($sessionProduct['warranty'])) {
            $totalPrice += $productServices['warrantyCost'];
            $product = [...$product, 'warrantyPeriod' => $productServices['warranty'], 'warrantyCost' => $productServices['warrantyCost'], 'totalPrice' => $totalPrice];
        }
        if (!empty($sessionProduct['delivery'])) {
            $totalPrice += $productServices['deliveryCost'];
            $product = [...$product, 'deliveryPeriod' => $productServices['delivery'], 'deliveryCost' => $productServices['deliveryCost'], 'totalPrice' => $totalPrice];
        }
        if (!empty($sessionProduct['setUp'])) {
            $totalPrice += $productServices['setupCost'];
            $product = [...$product, 'setupCost' => $productServices['setupCost'], 'totalPrice' => $totalPrice];
        }

        return $product;
    }

    public function getProductsFromSession()
    {
        $productsWithChosenServices = [];

        if (!$this->shopService->issetSession()) {
            return;
        }

        $session = $this->shopService->getSession();
        foreach ($session as $sessionProduct) {
            if (!$sessionProduct) {
                return;
            }

            $productIdInSession = $sessionProduct['itemId'];
            $product = $this->shopRepository->getOneProductById($productIdInSession);
            $productsServices = $this->shopRepository->getOneProductServices($productIdInSession);
            $productWithServices = $this->createArrayWithSelectedServices($product, $productsServices, $sessionProduct);
            $productsWithChosenServices[] = $productWithServices;
        }

        return $productsWithChosenServices;
    }
}
