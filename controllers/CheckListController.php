<?php
class ChecklistController {
    private $model;
    private $rollcall;

    public function __construct() {
        $this->model = new ChecklistModel();
        $this->rollcall = new RollcallModel();
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

                                // đoạn điểm danh - (tiến hùng)//
                                $getkhachhang = $this->rollcall->Getboking($departureId);
                                



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

    // Lấy dữ liệu điểm danh (nếu có) để hiển thị cho admin
    $rollcallEntries = $this->rollcall->getRollcallByDeparture($departureId);

    require_once BASE_URL_VIEWS . 'admin/checklist/admin_checklist.php';
}



    //////////////-tiến hùng////////
    //lưu điểm danh 
    public function saveChecklistRollCall()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $form_departure_ids = $_POST['form_departure_id'];
            $form_booking_ids   = $_POST['form_booking_id'];
            $form_presents      = $_POST['form_present'];
            $form_absents       = $_POST['form_absent'];
            $form_lates         = $_POST['form_late'];
            $form_notes         = $_POST['form_note'];

            foreach ($form_booking_ids as $i => $booking_id) {
                $departure_id = (int)$form_departure_ids[$i];
                $absent       = (int)$form_absents[$i];
                $late         = (int)$form_lates[$i];
                $note         = $form_notes[$i] ?? '';

                // Lấy số lượng khách từ booking
                $sql = "SELECT quantity FROM bookings WHERE id = :booking_id";
                $stmt = $this->rollcall->conn->prepare($sql);
                $stmt->bindParam(':booking_id', $booking_id, PDO::PARAM_INT);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $quantity = $row ? (int)$row['quantity'] : 0;

                $present = isset($form_presents[$i]) ? (int)$form_presents[$i] : null;
                if ($present === null || $present === 0) {
                    $present = max($quantity - $absent - $late, 0);
                }

                $this->rollcall->saveCall($departure_id, $booking_id, $present, $absent, $late, $note);
            }

            // Thông báo thành công và chuyển về trang itinerary để HDV thấy kết quả
            $_SESSION['success_attendance'] = 'Đã lưu điểm danh thành công.';
            // Nếu có departure_id, redirect về trang itinerary của chuyến đó
            $firstDeparture = (int)($form_departure_ids[0] ?? 0);
            if ($firstDeparture) {
                header('Location: ?act=guideItinerary&departure_id=' . $firstDeparture);
            } else {
                header("Location: ?act=MyTour");
            }
        }
    }
}
