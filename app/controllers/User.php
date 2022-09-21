<?php

  class User extends Controller {
    public function index() {

      // User (reg/auth/dashboard)
      $data=[];

        if(isset($_POST['name'])) {
          $user = $this->model('UserModel'); 
          $user->setData(     
            $_POST['name'],
            $_POST['email'],
            $_POST['pass'],
            $_POST['re_pass']);

            $user->addUser();                
        }
        $this->view('user/reg', $data);
    }
  }