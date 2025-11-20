<?php
class AssignmentController
{


    private $model;
    public $assign;
    public function __construct()
    {
        $this->model = new UserModel();
 
    }
    
 
    


    // Hiển thị danh sách phân công
    public function index()
    {
        $assignList = $this->model->getAllAssignments();
        require_once 'views/admin/assignments/main.php';
    }

    // Hiển thị form thêm
    public function create()
    {
        $guides = $this->model->getAllGuides();
        $departures = $this->model->getAllDepartures();
        require_once 'views/admin/assignments/create.php';
    }

    // Xử lý lưu phân công mới
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD']==='POST') {
            $guide_id = $_POST['guide_id'];
            $departure_id = $_POST['departure_id'];

            // Kiểm tra trùng lịch
            if ($this->model->checkDuplicate($guide_id, $departure_id)) {
                $_SESSION['error'] = "Hướng dẫn viên đã được phân công cho tour này!";
                header("Location: ?act=createAssignment");
                exit();
            }

            $data = [
                ':guide_id'=>$guide_id,
                ':departure_id'=>$departure_id,
                ':assigned_at'=>date('Y-m-d H:i:s')
            ];

            $this->model->storeAssignment($data);
            header("Location: ?act=listAssignments");
            exit();
        }
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
   



