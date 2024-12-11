<?php
require_once "../App/Models/Service.php";

class CreateController {
    private $ServiceModel;

    public function __construct() {
        $this->ServiceModel = new Service();
    }
    public function create() {
        require '../App/View/create.html';
    }
    public function store() {
        error_log(print_r($_POST, true));

        if (isset($_POST['name'], $_POST['description'], $_POST['cost'], $_POST['availability'])) {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $cost = $_POST['cost'];
            $availability = $_POST['availability'];
            $result = $this->ServiceModel->createService($name, $description, $cost, $availability);

            if ($result) {
                header("Location: ../CreateController/view");
                exit;
            } else {
                echo json_encode("Service insertion failed");
            }
        } else {
            echo json_encode(["message" => "Missing required fields"]);
        }
    }
    public function view() {
        $services = $this->ServiceModel->getAllServices();
        require '../App/View/show.php';
    }
    public function edit($id) {
        if (!isset($id)) {
            echo json_encode(["message" => "Service ID is required for editing."]);
            return;
        }
        $service = $this->ServiceModel->getServiceById($id);

        if (!$service) {
            echo json_encode(["message" => "Service not found."]);
            return;
        }
        require '../App/View/edit.php';  
    }
public function update() {
    if (isset($_POST['id'], $_POST['name'], $_POST['description'], $_POST['cost'], $_POST['availability'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $cost = $_POST['cost'];
        $availability = $_POST['availability'];
        $result = $this->ServiceModel->updateService($id, $name, $description, $cost, $availability);
    
        if ($result) {
            echo json_encode(["message" => "Service Updated Successfully"]);
        } else {
            echo json_encode(["message" => "Service updation failed"]);
        }
    } else {
        error_log("Missing fields: " . print_r($_POST, true));
        echo json_encode(["message" => "Missing required fields for updating."]);
    }
}    

}
