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

    // Lấy thông tin tour
    $departureInfo = $this->model->getDepartureInfo($departureId);

    // Tạo checklist mặc định nếu chưa có
    $this->model->createDefaultChecklist($departureId);

    // Lấy danh sách checklist
    $checklistItems = $this->model->getChecklistByDeparture($departureId);

    // Lấy tên HDV từ session
    $guideName = $_SESSION['user']['fullname'];

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
   // Admin xem checklist
    public function showChecklistForAdmin() {
    $departureId = $_GET['departure_id'];

    // Lấy checklist + tên HDV + tên tour
    $checklistItems = $this->model->getChecklistFullForAdmin($departureId);

    require_once BASE_URL_VIEWS . 'admin/checklist/admin_checklist.php';
}

}
