<?php

class Register extends Controller{
    public function index(){
        $data['title'] = 'Home';
        $this->view('templates/header', $data);
        $this->view('register/index', $data);
        $this->view('templates/footer');
    }

    public function postRegister(){
          // Init data
          $data=[
            'email' => trim($_POST['email']),
            'pwd' => trim($_POST['pwd']),
            'first_name' => trim($_POST['first_name']),
            'last_name' => trim($_POST['last_name'])
        ];

         //Validate inputs
         if(empty($data['email']) || empty($data['pwd']) || empty($data['first_name']) || empty($data['last_name'])){
            Flasher::setFlash('Data tidak boleh kosong', '', 'danger');
            header('Location: ' . BASEURL . '/register');
            exit;
         }

         if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
            Flasher::setFlash('email tidak valid', '', 'danger');
            header('Location: ' . BASEURL . '/register');
            exit;
        }
        else if(strlen($data['pwd']) < 6){
            Flasher::setFlash('password harus lebih dari 6 karakter', '', 'danger');
            header('Location: ' . BASEURL . '/register');
            exit;
        }

         //User with the same email or password already exists
         if($this->model('UserModel')->findUserByEmail($data['email'])){
            
            Flasher::setFlash($data['email'] . ' sudah terdaftar', '', 'danger');
            header('Location: ' . BASEURL . '/register');
            exit;
        }

        //Passed all validation checks.
        //Now going to hash password
        $data['pwd'] = password_hash($data['pwd'], PASSWORD_BCRYPT);

         //Register User
         if($this->model('UserModel')->register($data) > 0){
            
            Flasher::setFlash('Register berhasil', 'Silakan login', 'success');

            header('Location: ' . BASEURL . '/login');
            exit;
        }else{
            
            Flasher::setFlash('Register gagal', '', 'danger');

            header('Location: ' . BASEURL . '/register');
            exit;
        }
    }
}