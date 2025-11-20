<?php
class ChecklistController {
    private $model;

    public function __construct() {
        $this->model = new ChecklistModel();
    }

    // HDV xem checklist
    public function showChecklistForGuide() {
        $departureId = $_GET['departure_id'];
        $guideId = $_SESSION['user']['id'];

        // Tạo checklist mặc định nếu chưa có
        $this->model->createDefaultChecklist($departureId);

        $checklistItems = $this->model->getChecklistByDeparture($departureId);
        require_once BASE_URL_VIEWS . 'guide/checklist/guide_checklist.php';
    }

    // HDV lưu checklist
    public function saveChecklistForGuide() {
    $departureId = $_POST['departure_id'];
    $guideId = $_SESSION['user']['id'];
    $checkedItems = $_POST['checked'] ?? [];

    // Lưu checklist
    $this->model->saveChecklist($departureId, $guideId, $checkedItems);

    // Quay về dashboard của HDV
    header("Location: ?act=guideDashboard&success=1");
    exit;
}


    // Admin xem checklist
    public function showChecklistForAdmin() {
        $departureId = $_GET['departure_id'];
        $checklistItems = $this->model->getChecklistByDeparture($departureId);
        require_once BASE_URL_VIEWS . 'admin/checklist/admin_checklist.php';
    }
}
