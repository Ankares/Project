<?php

namespace App\Models\Repositories;

use App\Models\DB;
use App\Models\Repositories\Interfaces\ILoginProcessing;

class LoginRepository implements ILoginProcessing
{
    private $db = null;

    public function __construct()
    {
        $this->db = DB::getInstance();
    }

    public function getUserByEmail($email)
    {
        $sql = $this->db->query("SELECT * FROM regUsers WHERE email = '$email'");

        return $sql->fetch(\PDO::FETCH_ASSOC);
    }

    public function getUserBySession($session)
    {
        $sql = $this->db->query("SELECT * FROM regUsers WHERE id = '$session'");

        return $sql->fetch(\PDO::FETCH_ASSOC);
    }
}
