<?php
class ServicesController {
    private $serviceModel;
    private $departureModel;

    public function __construct() {
        $this->serviceModel   = new Services();
        $this->departureModel = new Departures();
    }

    public function index() {
        $services = $this->serviceModel->getAll();
        require_once BASE_URL_VIEWS . 'admin/services/list.php';   // ĐÚNG
    }

    public function create() {
        $departures = $this->departureModel->getAllWithTourInfo();
        require_once BASE_URL_VIEWS . 'admin/services/add.php';    // ĐÚNG
    }

    public function edit() {
        $id = $_GET['id'] ?? 0;
        if (!$id) {
            $_SESSION['error'] = "ID không hợp lệ!";
            header('Location: index.php?act=services'); exit;
        }

        $service    = $this->serviceModel->getServiceById($id);
        $departures = $this->departureModel->getAllWithTourInfo();

        if (!$service) {
            $_SESSION['error'] = "Không tìm thấy dịch vụ!";
            header('Location: index.php?act=services'); exit;
        }

        require_once BASE_URL_VIEWS . 'admin/services/edit.php';   // ĐÚNG
    }

    // store(), update(), delete() giữ nguyên như trước (đã gửi)
    public function store() {
    // Kiểm tra phương thức POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $_SESSION['error'] = "Phương thức không hợp lệ!";
        header('Location: index.php?act=servicesCreate'); 
        exit;
    }

    // Kiểm tra CSRF token
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'])) {
        $_SESSION['error'] = "Lỗi bảo mật!";
        header('Location: index.php?act=servicesCreate'); 
        exit;
    }

    // Lấy dữ liệu từ form
    $departure_id = trim($_POST['departure_id'] ?? '');
    $service_name = trim($_POST['service_name'] ?? '');
    $partner_name = trim($_POST['partner_name'] ?? '');
    $status       = $_POST['status'] ?? 'pending';
    $note         = trim($_POST['note'] ?? '');

    // Kiểm tra dữ liệu bắt buộc
    if (empty($departure_id) || empty($service_name) || empty($partner_name)) {
        $_SESSION['error'] = "Vui lòng điền đầy đủ thông tin!";
        $_SESSION['old'] = $_POST;
        header('Location: index.php?act=servicesCreate'); 
        exit;
    }

    // Thêm dịch vụ
    $result = $this->serviceModel->create($departure_id, $service_name, $partner_name, $status, $note);
    $_SESSION[$result ? 'success' : 'error'] = $result ? "Thêm thành công!" : "Thêm thất bại!";
    header('Location: index.php?act=services'); 
    exit;
}

public function update() {
    // Kiểm tra phương thức POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $_SESSION['error'] = "Phương thức không hợp lệ!";
        header('Location: index.php?act=services'); 
        exit;
    }

    // Kiểm tra CSRF token
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'])) {
        $_SESSION['error'] = "Lỗi bảo mật!";
        $id = $_POST['id'] ?? 0;
        header("Location: index.php?act=servicesEdit&id=$id"); 
        exit;
    }

    // Lấy dữ liệu từ form
    $id           = $_POST['id'] ?? 0;
    $departure_id = trim($_POST['departure_id'] ?? '');
    $service_name = trim($_POST['service_name'] ?? '');
    $partner_name = trim($_POST['partner_name'] ?? '');
    $status       = $_POST['status'] ?? 'pending';
    $note         = trim($_POST['note'] ?? '');

    // Kiểm tra dữ liệu bắt buộc
    if (!$id || empty($departure_id) || empty($service_name) || empty($partner_name)) {
        $_SESSION['error'] = "Dữ liệu không hợp lệ!";
        $_SESSION['old'] = $_POST;
        header("Location: index.php?act=servicesEdit&id=$id"); 
        exit;
    }

    // Cập nhật dịch vụ
    $result = $this->serviceModel->update($id, $departure_id, $service_name, $partner_name, $status, $note);
    $_SESSION[$result ? 'success' : 'error'] = $result ? "Cập nhật thành công!" : "Cập nhật thất bại!";
    header('Location: index.php?act=services'); 
    exit;
}

    public function delete() {
        $id = $_GET['id'] ?? 0;
        if ($id) {
            $this->serviceModel->delete($id);
            $_SESSION['success'] = "Xóa thành công!";
        }
        header('Location: index.php?act=services'); exit;
    }
}
?>