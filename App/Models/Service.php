<?php
class Service {
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    public function createService($name, $description, $cost, $availability) {
        if (isset($_SESSION['authUser'])) {
            $authUser = json_decode($_SESSION['authUser'], true);

            if (isset($authUser['id'])) {
                $userId = $authUser['id'];

                if (empty($availability)) {
                    $availability = 'N/A';  
                }

                $query = "INSERT INTO services (name, description, cost, availability) 
                          VALUES (:name, :description, :cost, :availability)";

                $stmt = $this->db->prepare($query);
                $stmt->bindParam(":name", $name);
                $stmt->bindParam(":description", $description);
                $stmt->bindParam(":cost", $cost);
                $stmt->bindParam(":availability", $availability);

                if (!$stmt->execute()) {
                    error_log("Failed to create service: " . implode(", ", $stmt->errorInfo()));
                    return false;
                }

                return true;
            } else {
                error_log("User ID not found in session data.");
            }
        } else {
            error_log("User is not authenticated.");
            header("Location: ../AuthController/login");
            exit();
        }
    }
    public function getAllServices() {
        $query = "SELECT * FROM services";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getServiceById($id) {
        $stmt = $this->db->prepare("SELECT * FROM services WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }
    public function updateService($id, $name, $description, $cost, $availability) {
        $query = "UPDATE services 
                  SET name = :name, description = :description, cost = :cost, availability = :availability 
                  WHERE id = :id";
    
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":cost", $cost);
        $stmt->bindParam(":availability", $availability);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
    
}
