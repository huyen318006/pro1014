<?php
class AssignmentController
{


    private $model;
    private $bookingmodel;
    public $assign;
    public function __construct()
    {
        $this->model = new UserModel();
        $this->bookingmodel= new BookingModel();
 
    }
    // Hiển thị danh sách phân công
    public function index()
    {
        $assignList = $this->model->getAllAssignments();
        require_once 'views/admin/assignments/main.php';
    }


    // Hiển thị form sửa
    public function edit()
    {
        $id = $_GET['id'];
        $assign = $this->model->getAssignmentById($id);
        $guides = $this->model->getAllGuides();
        $departures = $this->model->getAllDepartures();
        require_once 'views/admin/assignments/edit.php';
    }

    // Cập nhật phân công
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD']==='POST') {
            $data = [
                ':id'=>$_POST['id'],
                ':guide_id'=>$_POST['guide_id'],
                ':departure_id'=>$_POST['departure_id'],
                ':assigned_at'=>$_POST['assigned_at']
            ];
            $this->model->updateAssignment($data);
            header("Location: ?act=listAssignments");
            exit();
        }
    }

    // Xóa phân công
    public function delete()
    {
        $id = $_GET['id'];
        $this->model->deleteAssignment($id);
        header("Location: ?act=listAssignments");
        exit();
    }

  // Cập nhật trạng thái tour
    public function updateStatus()
    {
        if ($_SERVER['REQUEST_METHOD']==='POST') {
            $departure_id = $_POST['departure_id'];
            $status = $_POST['status'];
            $this->model->updateDepartureStatus($departure_id, $status);
            header("Location: ?act=listAssignments");
            exit();
        }
    }      
 }
         






?>
   



