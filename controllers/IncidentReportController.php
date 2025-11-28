<?php
class IncidentReportController
{
    private $model;
    private $userModel;
    private $tourModel;

    public function __construct()
    {
        $this->model = new IncidentReportModel();
        $this->userModel = new UserModel();
        $this->tourModel = new TourModel();
    }

    // HDV tạo báo cáo
    public function create()
    {
        // Lấy danh sách assignment + guide
        $assignments = $this->userModel->getAllAssignments();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy tour_id từ assignment
            $assignment_id = $_POST['assignment_id'];
            $tour_id = $this->getTourIdFromAssignment($assignment_id);

            $data = [
                'assignment_id' => $assignment_id,
                'tour_id' => $tour_id,
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

    // Helper method để lấy tour_id từ assignment
    private function getTourIdFromAssignment($assignment_id)
    {
        $sql = "SELECT d.tour_id 
                FROM assignments a 
                JOIN departures d ON a.departure_id = d.id 
                WHERE a.id = ?";
        $stmt = $this->model->conn->prepare($sql);
        $stmt->execute([$assignment_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['tour_id'] ?? null;
    }

    // Admin: danh sách báo cáo
    public function index()
    {
        $reports = $this->model->getAll();
        require './views/admin/incident/index.php';
    }

    // Admin: xóa báo cáo
    public function delete()
    {
        $id = $_GET['id'] ?? 0;
        $this->model->delete($id);
        header("Location: ?act=incidents");
        exit;
    }
}
