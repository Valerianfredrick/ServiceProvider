<?php

class AuthController{
    private $userModel;

    public function __construct()
    {   
        $this->userModel = new User();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "Invalid email address";
                return;
            }
    
    
            if (!empty($email) && !empty($password)) {

                $user = $this->userModel->getByEmail($email);
    
                if ($user) {
                    var_dump($user);  
    
    
                    if (hash('sha256', $password) === $user['password_hash']) {
                        
                        $userObject = [
                            "id" => $user["id"],
                            "email" => $user["email"],
                            //"role" => $user["role"]
                        ];

                        $_SESSION['authUser'] = json_encode($userObject);
    
                        header("Location: ../HomeController/home");
                        exit();
                    } else {
                        echo "<script>alert('Invalid password, please insert the correct password')</script>";
                    }
                } else {
                    echo "<script>alert('No user found with that email address')</script>";
                }
            } else {
                echo "<script>alert('Email and password cannot be empty')</script>";
            }
        } else {
            require "../App/View/login.html";
        }
    }
}
