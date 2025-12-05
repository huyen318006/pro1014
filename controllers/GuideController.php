<?php
//trang chức  năng  hiển thị tour của guide
class GuideController
{

    public $departureModel;
    public $userModel;
    public $itineraryModel;

    function __construct()
    {
        $this->departureModel = new Departures();
        $this->userModel = new UserModel();
        $this->itineraryModel = new ItineraryModel();
    }

    public function guideDashboard()
    {
        // Kiểm tra session
        if (!isset($_SESSION['user']['id'])) {
            header('Location: /login.php');
            exit(); // nên dùng exit() sau header để dừng script
        }

        include './views/guide/guide.php';
    }
    //trang lịch khởi hành của guide
    public function guideDepartures()
    {
        // Kiểm tra session
        if (!isset($_SESSION['user']['id'])) {
            header('Location: /login.php');
            exit(); // nên dùng exit() sau header để dừng script
        }
        $departures = $this->departureModel->getAllDepartures();

        include './views/guide/Departures.php';
    }

    //ham hiển thị tour được giao cho guide
    public function MyTour()
    {
        // Kiểm tra session
        if (!isset($_SESSION['user']['id'])) {
            header('Location: /login.php'); // <-- đóng nháy và chấm phẩy
            exit(); // nên dùng exit() sau header để dừng script
        }
        $guide_id = $_SESSION['user']['id']; // Lấy ID hướng dẫn viên từ session
        $MyTour = $this->departureModel->getDeparturesByGuide($guide_id);

        include './views/guide/Mytour.php';
    }

    /**
     * Hiển thị lịch trình tour cho guide
     */
    public function guideItinerary()
    {
        // Kiểm tra session
        if (!isset($_SESSION['user']['id'])) {
            header('Location: ' . BASE_URL);
            exit();
        }

        $guide_id = $_SESSION['user']['id'];
        $departure_id = $_GET['departure_id'] ?? 0;

        if (!$departure_id) {
            $_SESSION['error'] = 'Không tìm thấy thông tin chuyến đi';
            header('Location: ' . BASE_URL . '?act=MyTour');
            exit();
        }

        // Verify guide được giao departure này
        $myTours = $this->departureModel->getDeparturesByGuide($guide_id);
        $hasAccess = false;
        $departureInfo = null;

        foreach ($myTours as $tour) {
            if ($tour['id'] == $departure_id) {
                $hasAccess = true;
                $departureInfo = $tour;
                break;
            }
        }

        if (!$hasAccess) {
            $_SESSION['error'] = 'Bạn không có quyền xem lịch trình này';
            header('Location: ' . BASE_URL . '?act=MyTour');
            exit();
        }

        // Lấy lịch trình với checkpoint status
        $itineraries = $this->itineraryModel->getItinerariesByDepartureId($departure_id, $guide_id);

        // Tính toán ngày hiện tại trong tour
        $currentDate = date('Y-m-d');
        $departureDate = $departureInfo['departure_date'];
        $currentDayNumber = floor((strtotime($currentDate) - strtotime($departureDate)) / 86400) + 1;

        // Tính progress
        $totalCheckpoints = count($itineraries);
        $completedCheckpoints = 0;
        foreach ($itineraries as $itinerary) {
            if (!empty($itinerary['is_checked'])) {
                $completedCheckpoints++;
            }
        }
        $progressPercent = $totalCheckpoints > 0 ? round(($completedCheckpoints / $totalCheckpoints) * 100) : 0;

        include './views/guide/itinerary.php';
    }

    /**
     * AJAX endpoint để update checkpoint
     */
    public function updateCheckpoint()
    {
        // Set header cho JSON response
        header('Content-Type: application/json');

        // Kiểm tra session
        if (!isset($_SESSION['user']['id'])) {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit();
        }

        // Chỉ chấp nhận POST request
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            exit();
        }

        $guide_id = $_SESSION['user']['id'];

        // Lấy JSON data từ request body
        $input = json_decode(file_get_contents('php://input'), true);

        $departure_id = $input['departure_id'] ?? 0;
        $itinerary_id = $input['itinerary_id'] ?? 0;
        $action = $input['action'] ?? ''; // 'check' hoặc 'uncheck'
        $notes = $input['notes'] ?? null;

        // Validate input
        if (!$departure_id || !$itinerary_id || !in_array($action, ['check', 'uncheck'])) {
            echo json_encode(['success' => false, 'message' => 'Invalid parameters']);
            exit();
        }

        // Verify guide có quyền truy cập departure này
        $myTours = $this->departureModel->getDeparturesByGuide($guide_id);
        $hasAccess = false;

        foreach ($myTours as $tour) {
            if ($tour['id'] == $departure_id) {
                $hasAccess = true;
                break;
            }
        }

        if (!$hasAccess) {
            echo json_encode(['success' => false, 'message' => 'Access denied']);
            exit();
        }

        // Thực hiện action
        if ($action === 'check') {
            $result = $this->itineraryModel->markCheckpoint($departure_id, $itinerary_id, $guide_id, $notes);
        } else {
            $result = $this->itineraryModel->unmarkCheckpoint($departure_id, $itinerary_id, $guide_id);
        }

        echo json_encode($result);
        exit();
    }
}
