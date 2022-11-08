<?php

class Logout extends Controller{
    public function index(){
        $this->service('SessionService')->destroy();
        Flasher::setFlash('Logged out', '', 'danger');
        header('Location: ' . BASEURL . '/login');
        exit;
        
    }
}