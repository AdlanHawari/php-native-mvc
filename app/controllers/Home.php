<?php

class Home extends Controller{
    public function index(){


        $user = $this->service('SessionService')->getCurrentSession();

        if($user){
            if($this->model('UserModel')->findUserByEmail($user->email)){
                $data['title'] = 'Home';
                $data['email'] = $user->email;
                // echo $user->email;
                $this->view('templates/header', $data);
                $this->view('home/index', $data);
                $this->view('templates/footer');
            }else{
                Flasher::setFlash('Unauthorized', '', 'danger');
                header('Location: ' . BASEURL . '/login');
                exit;
            }
           
        }else{
            Flasher::setFlash('Unauthorized', '', 'danger');
            header('Location: ' . BASEURL . '/login');
            exit;
        }
    }
}