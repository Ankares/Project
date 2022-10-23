<?php

namespace App\Models\Repositories\Interfaces;

interface iShopProcessing
{
    public function getShopItems();
    public function getOneItem($id);
}