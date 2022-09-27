<?php

interface User 
{
    public static function loadDB();
    public function add();
    public function validation();
    public function getAllData();
    public function getDataByID($id);
    public function deleteByID($id);
}
