<?php

namespace App\Models\Repositories;
use App\Models\Repositories\Interfaces;
use App\Models\DB;

class ShopRepository implements Interfaces\IShopProcessing
{
    private $db = null;

    public function __construct()
    {
        $this->db = DB::getInstance();
    }

    public function getShopItems()
    {
        $sql = $this->db->query("SELECT * FROM shopItems");
        return $sql->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getOneItem($name)
    {
        $sql = $this->db->query("SELECT * FROM shopItems WHERE itemName = '$name'");
        return $sql->fetch(\PDO::FETCH_ASSOC);
    }

    public function getSessionItems($items)
    {
        $sql = $this->db->query("SELECT * FROM shopItems WHERE id IN ($items)");
        return $sql->fetchAll(\PDO::FETCH_ASSOC);
    }

}