<?php

namespace App\Models;

class UserModel
{
    private $repo;
    
    public function __construct(Repositories\UserInterface $repo)
    {
      $this->repo = $repo;
    }

    public function initRepo() {
        return $this->repo;
    }
}
