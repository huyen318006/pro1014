<?php
class IncidentReportController
{
    private $model;
    private $userModel;

    public function __construct()
    {
        $this->model = new IncidentReportModel();
        $this->userModel = new UserModel();
    }

    // HDV tạo báo cáo
    public function create()
    {
        $guide_id = $_SESSION['user']['id'];

        // Lấy danh sách assignment của HDV
        $assignments = $this->userModel->getAssignmentsByGuide($guide_id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $assignment_id = $_POST['assignment_id'];

            // Lấy tour_id từ assignment
            $tour_id = $this->getTourIdFromAssignment($assignment_id);

            $data = [
                'assignment_id' => $assignment_id,
                'incident_date' => $_POST['incident_date'],
                'description'   => $_POST['description'],
                'severity'      => $_POST['severity'],
                'resolution'    => $_POST['resolution'],
                'reported_at'   => date('Y-m-d H:i:s'),
                'tour_id'       => $tour_id,
            ];

            $this->model->insert($data);

            header("Location: ?act=guideDashboard");
            exit;
        }

        require './views/guide/incident/create.php';
    }

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

    public function index()
    {
        $reports = $this->model->getAll();
        require './views/admin/incident/index.php';
    }

    public function delete()
    {
        $id = $_GET['id'] ?? 0;
        $this->model->delete($id);
        header("Location: ?act=incidents");
        exit;
    }
}

