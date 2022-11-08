<?php

class UserModel{

    private string $table = 'users';
    private $db;

    public function __construct()
    {
        $this->db = new Database;    
    }

    public function findUserByEmail($email){
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE email=:email');
        $this->db->bind('email', $email);

        return $this->db->single();
        
    }

    public function register($data){
        $this->db->query('INSERT INTO ' . $this->table . '(email, password, first_name, last_name) 
        VALUES (:email, :pwd, :first_name, :last_name)');
        //Bind values
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':pwd', $data['pwd']);
        $this->db->bind(':first_name', $data['first_name']);
        $this->db->bind(':last_name', $data['last_name']);

        $this->db->execute();
        

        return $this->db->rowCount();
    }

    public function login($email, $password){
        $row = $this->findUserByEmail($email);
        $hashedPassword = $row['password'];
        if(password_verify($password, $hashedPassword)){
            return $row;
        }else{
            return false;
        }

    }
}