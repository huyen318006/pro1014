<?php
class AssignmentController
{
    public $assignment;

    public function __construct()
    {
        $this->assignment = new UserModel();
    }

    // Hiển thị danh sách phân công
    public function index()
    {
        $assignList = $this->assignment->getAllAssignments();
        require_once BASE_URL_VIEWS . 'admin/assignments/main.php';
    }

    // Hiển thị form tạo phân công
    public function create()
    {
        $guides = $this->assignment->getAllGuides();
        $departures = $this->assignment->getAllDepartures();
        require_once BASE_URL_VIEWS . 'admin/assignments/create.php';
    }

    // Lưu phân công
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $guide_id = $_POST['guide_id'];
            $departure_id = $_POST['departure_id'];

            // 1. Kiểm tra trùng tour
            if ($this->assignment->checkDuplicate($guide_id, $departure_id)) {
                $_SESSION['error'] = "Hướng dẫn viên đã được phân công vào tour này!";
                header("Location: ?act=createAssignment");
                exit();
            }

            // 2. Lưu phân công
            $data = [
                ':departure_id' => $departure_id,
                ':guide_id' => $guide_id,
                ':assigned_at' => date('Y-m-d H:i:s')
            ];
            $this->assignment->storeAssignment($data);
        }

        header('Location: ?act=listAssignments');
        exit();
    }

    // Hiển thị form sửa phân công
    public function edit()
    {
        if (isset($_GET['id'])) {
            $assign = $this->assignment->getAssignmentById($_GET['id']);
            $guides = $this->assignment->getAllGuides();
            $departures = $this->assignment->getAllDepartures();
            require_once BASE_URL_VIEWS . 'admin/assignments/edit.php';
        } else {
            header('Location: ?act=listAssignments');
            exit();
        }
    }

    // Cập nhật phân công
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                ':id' => $_POST['id'],
                ':departure_id' => $_POST['departure_id'],
                ':guide_id' => $_POST['guide_id'],
                ':assigned_at' => $_POST['assigned_at']
            ];
            $this->assignment->updateAssignment($data);
        }

        header('Location: ?act=listAssignments');
        exit();
    }

    // Xóa phân công
    public function delete()
    {
        if (isset($_GET['id'])) {
            $this->assignment->deleteAssignment($_GET['id']);
        }

        header('Location: ?act=listAssignments');
        exit();
    }
}
?>