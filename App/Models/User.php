<?php
require_once "../App/Models/Database.php";

class User {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM admin WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function save($params) {
        $existingUser = $this->getByEmail($params[':email']);
        if ($existingUser) {
            return "Error: Email already exists.";
        }

        $sql = "INSERT INTO users (username, email, phone, password) 
                VALUES (:username, :email, :phone, :hashed_password)";

        try {
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return true; 
        } catch (PDOException $e) {
            error_log("Error saving user: " . $e->getMessage());
            return "Database error: " . $e->getMessage();
        }
    }
    public function storeResetToken($email, $token) {
        $stmt = $this->db->prepare("UPDATE users SET reset_token = :token WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':token', $token);
        $stmt->execute();
    }

    public function getByResetToken($token) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE reset_token = :token");
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function updatePassword($email, $hashedPassword) {
        $stmt = $this->db->prepare("UPDATE users SET password = :password, reset_token = NULL WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->execute();
    }
}
?>
