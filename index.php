<?php



require 'vendor/autoload.php';

(Dotenv\Dotenv::createImmutable(__DIR__))->load();

$app = new App\Core\App();
$app->run();



// class example {
//     public $array = [
//         'name' => '',
//         'surname' => '',
//         'email' => '',
//         'gender' => '',
//         'status' => '',
//         'error' => ''
//     ];
    
//     public function setData($arr)
//     {
//         foreach($arr as $key => $value) {
//             if(array_key_exists($key, $this->array)) {
//                 $this->array[$key] = $value;
//             }
//         }
//         print_r($this->array);
//     }
// }
// $_POST = ['name'=>'example','surname'=>'ororo'];
// $obj = new example();
// $obj->setData($_POST);