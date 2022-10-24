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

    public function addServiceDataToDB($data, $id)
    {
        $sql = "INSERT INTO servicesForItems(itemId, userId, warranty, delivery, setUp) VALUES(:itemId, :userId, :warranty, :delivery, :setup)";
        $query = $this->db->prepare($sql);
        $query->execute(['itemId' => $data['itemId'], 'userId' => $id, 'warranty' => $data['warranty'], 'delivery' => $data['delivery'], 'setup' => $data['setUp'] ]);
    }

    public function getServiceDataFromDB($id, $itemId)
    {
        $sql = $this->db->query("SELECT * FROM servicesForItems WHERE userId = '$id' AND itemId = '$itemId'");
        return $sql->fetch(\PDO::FETCH_ASSOC);
    }

    public function removeServieceDataFromDB($itemId, $userId)
    {
        $this->db->query("DELETE FROM servicesForItems WHERE itemId = '$itemId' AND userId = '$userId'");
    }

    public function removeAllServieceDataFromDB($userId)
    {
        $this->db->query("DELETE FROM servicesForItems WHERE userId = '$userId'");
    }

}