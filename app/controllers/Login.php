<?php

class Login extends Controller{
    
    // public static string $COOKIE_NAME = "AUTH-SESSION";

    public function index(){
        $data['title'] = 'Login';
        $this->view('templates/header', $data);
        $this->view('login/index', $data);
        $this->view('templates/footer');
    }

    public function postLogin(){
        
        // Init data
        $data=[
            'email' => trim($_POST['email']),
            'pwd' => trim($_POST['pwd'])
        ];
        
        if ($data['email'] == null || $data['pwd'] == null ||
            trim($data['email']) == "" || trim($data['pwd']) == "") {

            Flasher::setFlash('Email dan password tidak boleh kosong', '', 'danger');
            header('Location: ' . BASEURL . '/login');
            exit;
        }

        //Check for user/email
        if($this->model('UserModel')->findUserByEmail($data['email'])){

             $loggedInUser = $this->model('UserModel')->login($data['email'], $data['pwd']);
             if($loggedInUser){

                //Create jwt session
                $this->service('SessionService')->create($loggedInUser);
                header('Location: ' . BASEURL . '/');
            }else{
                
                Flasher::setFlash('Password salah', '', 'danger');
                header('Location: ' . BASEURL . '/login');
                exit;
            }
        }else{
            Flasher::setFlash('email tidak ditemukan ', '', 'danger');
            header('Location: ' . BASEURL . '/login');
            exit;
        }

    }

}