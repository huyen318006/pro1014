<?php
class IncidentReportController {
    private $model;
    private $userModel;

    public function __construct() {
        $this->model = new IncidentReportModel();
        $this->userModel = new UserModel();
    }

    // HDV tạo báo cáo
    public function create() {
        // Lấy danh sách assignment + guide
        $assignments = $this->userModel->getAllAssignments();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'assignment_id' => $_POST['assignment_id'], // từ select list
                'incident_date' => $_POST['incident_date'],
                'description' => $_POST['description'],
                'severity' => $_POST['severity'],
                'resolution' => $_POST['resolution'],
                'reported_at' => date('Y-m-d H:i:s'),
            ];
            $this->model->insert($data);

            // Chuyển về trang dashboard của HDV
            header("Location: ?act=guideDashboard");
            exit;
        }

        require './views/guide/incident/create.php';
    }

    // Admin: danh sách báo cáo
    public function index() {
        $reports = $this->model->getAll();
        require './views/admin/incident/index.php';
    }

    // Admin: xóa báo cáo
    public function delete() {
        $id = $_GET['id'] ?? 0;
        $this->model->delete($id);
        header("Location: ?act=incidents");
        exit;
    }
}
?>