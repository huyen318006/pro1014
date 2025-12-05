<?php
class ServicesController {
    private $serviceModel;
    private $departureModel;
    private $modelTour;

    public function __construct() {
        $this->serviceModel   = new Services();
        $this->departureModel = new Departures();
        $this->modelTour      = new TourModel();
    }

    // ==============================================
    // 1. Danh sách + lọc theo Tour
    // ==============================================
    public function index() {
        $tours = $this->modelTour->getAllTours();

        $selectedTourId = $_POST['tour_id'] ?? null;
        $services = [];

        if ($selectedTourId) {
            $services = $this->serviceModel->getServicesByTour($selectedTourId);
        }

        require_once BASE_URL_VIEWS . 'admin/services/list.php';
    }

    // ==============================================
    // 2. Trang thêm dịch vụ theo departure (có modal chọn ngày)
    // ==============================================
    public function createByDeparture() {
    $departure_id = $_GET['departure_id'] ?? null;

    // Fix lỗi: Kiểm tra departure_id hợp lệ
    if (!$departure_id || !is_numeric($departure_id)) {
        $_SESSION['error'] = "Lịch khởi hành không hợp lệ!";
        header('Location: index.php?act=services');
        exit;
    }

    // Lấy departure
    $departure = $this->departureModel->getAllDepartures($departure_id);
    if (!$departure) {
        $_SESSION['error'] = "Không tìm thấy lịch khởi hành!";
        header('Location: index.php?act=services');
        exit;
    }

    // Fix lỗi: tour_id có thể null → kiểm tra trước khi gọi getTourById
    $tour = ['name' => 'Không xác định'];
    if (!empty($departure['tour_id'])) {
        $tour = $this->modelTour->getTourById($departure['tour_id']);
        if (!$tour) $tour = ['name' => 'Không xác định'];
    }

    // Gán biến để view dùng
    $GLOBALS['current_departure'] = $departure;
    $GLOBALS['current_tour']      = $tour;

    // Fix đường dẫn: DÙNG HẰNG BASE_URL_VIEWS ĐÃ KHAI BÁO
    require_once BASE_URL_VIEWS . 'admin/services/create.php';
}

    // ==============================================
    // 3. Lưu dịch vụ từ form checkbox
    // ==============================================
    public function storeByDeparture() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?act=services');
            exit;
        }

        $departure_id = $_POST['departure_id'] ?? null;
        $services     = $_POST['services'] ?? [];

        if (!$departure_id || empty($services)) {
            $_SESSION['error'] = "Vui lòng chọn ít nhất 1 dịch vụ!";
            header("Location: index.php?act=servicesCreateByDeparture&departure_id=$departure_id");
            exit;
        }

        $count = 0;
        foreach ($services as $name) {
            $name = trim($name);
            if ($name === '') continue;

            $result = $this->serviceModel->create(
                $departure_id,
                $name,
                $name,           // partner_name tạm = tên dịch vụ
                'confirmed',
                'Thêm nhanh từ form checkbox'
            );

            if ($result) $count++;
        }

        $_SESSION['success'] = "Đã thêm thành công $count dịch vụ!";
        header('Location: index.php?act=services');
        exit;
    }

    // ==============================================
    // 4. Trang thêm dịch vụ nhanh (không cần chọn departure – dùng sau nếu muốn)
    // ==============================================
    public function quickCreate() {
        require_once BASE_URL_VIEWS . 'admin/services/quick_create.php';
    }

    public function quickStore() {
        $tour_id  = $_POST['tour_id'] ?? null;
        $services = $_POST['services'] ?? [];

        if (!$tour_id || empty($services)) {
            $_SESSION['error'] = "Vui lòng chọn tour và ít nhất 1 dịch vụ!";
            header('Location: index.php?act=servicesQuickCreate');
            exit;
        }

        // Lấy tất cả departure của tour này
        $departures = $this->departureModel->getAllDepartures($tour_id);
        $total = 0;

        foreach ($services as $name) {
            $name = trim($name);
            if ($name === '') continue;

            foreach ($departures as $dep) {
                $this->serviceModel->create(
                    $dep['id'],
                    $name,
                    $name,
                    'confirmed',
                    "Thêm nhanh cho toàn bộ lịch tour #$tour_id"
                );
                $total++;
            }
        }

        $_SESSION['success'] = "Đã thêm $total dịch vụ cho " . count($departures) . " lịch khởi hành!";
        header('Location: index.php?act=services');
        exit;
    }

    // ==============================================
    // 5. Các hàm cũ (giữ lại để không lỗi)
    // ==============================================
    public function edit() {
    $id = $_GET['id'] ?? 0;

    if (!$id || !is_numeric($id)) {
        $_SESSION['error'] = "ID dịch vụ không hợp lệ!";
        header('Location: index.php?act=services');
        exit;
    }

    // Lấy dịch vụ
    $service = $this->serviceModel->getServiceById($id);
    if (!$service) {
        $_SESSION['error'] = "Không tìm thấy dịch vụ!";
        header('Location: index.php?act=services');
        exit;
    }

    // Lấy departure và tour để hiển thị thông tin
    $departure = $this->departureModel->getAllDepartures($service['departure_id']);
    $tour = null;
    if ($departure && !empty($departure['tour_id'])) {
        $tour = $this->modelTour->getTourById($departure['tour_id']);
    }

    // TRUYỀN DỮ LIỆU QUA BIẾN TOÀN CỤC ĐỂ VIEW DÙNG
    $GLOBALS['service']   = $service;
    $GLOBALS['departure'] = $departure;
    $GLOBALS['tour']      = $tour ?? ['name' => 'Không xác định', 'code' => ''];

    require_once BASE_URL_VIEWS . 'admin/services/edit.php';
}

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error'] = "Phương thức không hợp lệ!";
            header('Location: index.php?act=servicesCreate'); 
            exit;
        }

        $departure_id = trim($_POST['departure_id'] ?? '');
        $service_name = trim($_POST['service_name'] ?? '');
        $partner_name = trim($_POST['partner_name'] ?? '');
        $status       = $_POST['status'] ?? 'pending';
        $note         = trim($_POST['note'] ?? '');

        if (empty($departure_id) || empty($service_name)) {
            $_SESSION['error'] = "Vui lòng điền đầy đủ thông tin!";
            $_SESSION['old'] = $_POST;
            header('Location: index.php?act=servicesCreate'); 
            exit;
        }

        $result = $this->serviceModel->create(
            $departure_id, 
            $service_name, 
            $partner_name, 
            $status, 
            $note
        );

        $_SESSION[$result ? 'success' : 'error'] = $result ? "Thêm thành công!" : "Thêm thất bại!";
        header('Location: index.php?act=services'); 
        exit;
    }

    // Có thể thêm update(), delete() sau nếu cần
}
?>