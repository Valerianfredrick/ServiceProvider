<?php
require_once "../App/Models/User.php";
require_once '../vendor/autoload.php';  

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    private function generateRandomPassword($length = 8) {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()';
        return substr(str_shuffle($chars), 0, $length);
    }

    private function sendPasswordEmail($email, $password, $username) {
        $mail = new PHPMailer(true);

        try {
        
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'valerianmuganda97@gmail.com'; 
            $mail->Password   = 'jfbu jsfb gqht nlnm';  
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

        
            $mail->setFrom('valerianmuganda97@gmail.com', 'valerian');
            $mail->addAddress($email, $username);
            $mail->isHTML(true);
            $mail->Subject = 'Your New Account Password';
            $mail->Body    = "Dear user,<br><br>Your account has been created. Your login credentials are as follows:<br><br>Username: $username<br>Password: $password<br><br>Please keep this information safe.";

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    public function store() {
        if (isset($_POST['username'], $_POST['email'], $_POST['phone'])) {
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                echo "Invalid email format!";
                return;
            }

            $existingUser = $this->userModel->getEmail($_POST['email']);
            if ($existingUser) {
                echo "Email is already in use!";
                return; 
            }

            $randomPassword = $this->generateRandomPassword();
            $hashedPassword = password_hash($randomPassword, PASSWORD_DEFAULT);

            $params = [
                ":username" => $_POST['username'],
                ":email" => $_POST['email'],
                ":phone" => $_POST['phone'],
                ":hashed_password" => $hashedPassword,
            ];

            $result = $this->userModel->save($params);

            if ($result === true) {
                $this->sendPasswordEmail($_POST['email'], $randomPassword, $_POST['username']);
                echo "User created successfully. A password has been sent to the provided email.";
            } else {
                echo "Error creating user: " . $result;
            }
        } else {
            echo "All fields (username, email, phone) are required!";
        }
    }
    public function UserLogin(){
        
    }
    public function register() {
        require_once "../App/View/register.html";
    }
}
?>
