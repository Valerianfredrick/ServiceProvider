<?php
require_once "../App/Models/User.php";
require_once '../vendor/autoload.php';  

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ForgotPasswordController {

    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    
    public function view() {
        require_once "../App/View/forgotPassword.html";
    }


    public function sendResetLink() {
        if (isset($_POST['email'])) {
            $email = $_POST['email'];

            $user = $this->userModel->getEmail($email);

            if (!$user) {
                echo "No account found with that email address.";
                return;
            }

        
            $token = bin2hex(random_bytes(50)); 
            $this->userModel->storeResetToken($email, $token);
            $resetLink = "http://localhost/ServiceProvider/public/ForgotPasswordController/resetPassword?token=" . $token;
            $this->sendResetEmail($email, $resetLink);

            echo "A password reset link has been sent to your email.";
        } else {
            echo "Please provide a valid email.";
        }
    }

    private function sendResetEmail($email, $resetLink) {
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
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Request';
            $mail->Body    = "Click the link below to reset your password:<br><br><a href='$resetLink'>Reset Password</a>";

            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
    public function resetPasswordHandler(){
if (isset($_POST['token'], $_POST['new_password'])) {
    $token = $_POST['token'];
    $newPassword = $_POST['new_password'];

    // Validate token
    $userModel = new User();
    $user = $userModel->getByResetToken($token);

    if ($user) {
        // Hash the new password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Update the password in the database
        $userModel->updatePassword($user['email'], $hashedPassword);

        echo "Your password has been reset successfully.";
    } else {
        echo "Invalid or expired token.";
    }
}
    }
    public function resetPassword(){
        if (isset($_GET['token'])) {
            $token = $_GET['token'];
        
            // Validate token in the database
            $userModel = new User();
            $user = $userModel->getByResetToken($token);
        
            if ($user) {
                echo '<form method="POST" action="resetPasswordHandler"
                        <input type="hidden" name="token" value="' . $token . '">
                        <label for="new_password">New Password:</label>
                        <input type="password" name="new_password" required>
                        <button type="submit">Reset Password</button>
                      </form>';
            } else {
                echo "Invalid or expired token.";
            }
        }
        
}
}
