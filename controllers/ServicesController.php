<?php
class ServicesController {
    private $serviceModel;
    private $modelTour;

    public function __construct() {
        $this->serviceModel = new Services();
        $this->modelTour    = new TourModel();
    }

    // =====================================================
    // 1. Danh sách dịch vụ + Lọc theo Tour
    // =====================================================
    public function index() {
        $tours = $this->modelTour->getAllTours();

        $selectedTourId = $_POST['tour_id'] ?? null;
        $services = [];

        if ($selectedTourId) {
            $services = $this->serviceModel->getByTourId($selectedTourId);
        } else {
            $services = $this->serviceModel->getAll();
        }

        require_once BASE_URL_VIEWS . 'admin/services/list.php';
    }

    // =====================================================
    // 2. Trang thêm dịch vụ nhanh
    // =====================================================
    public function quickCreate() {
        $tours = $this->modelTour->getAllTours();
        require_once BASE_URL_VIEWS . 'admin/services/quick_create.php';
    }

    // =====================================================
    // 3. Lưu dịch vụ nhanh
    // =====================================================
    public function quickStore() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?act=services');
            exit;
        }

        $tour_id  = $_POST['tour_id'] ?? null;
        $services = $_POST['services'] ?? [];

        if (!$tour_id || empty($services)) {
            $_SESSION['error'] = "Vui lòng chọn tour và nhập ít nhất 1 dịch vụ!";
            header('Location: index.php?act=servicesQuickCreate');
            exit;
        }

        $tour_ids = is_array($tour_id) ? $tour_id : [$tour_id];
        $total = 0;

        foreach ($services as $name) {
            $name = trim($name);
            if ($name === '') continue;

            foreach ($tour_ids as $tid) {
                $tid = (int)$tid;
                if ($tid <= 0) continue;

                $this->serviceModel->createByTour(
                    $tid,
                    $name,
                    $name,
                    'confirmed',
                    "Dịch vụ chung cho tour ID #$tid"
                );

                $total++;
            }
        }

        $_SESSION['success'] = "Đã thêm $total dịch vụ!";
        header('Location: index.php?act=services');
        exit;
    }

    // =====================================================
    // 4. Trang sửa dịch vụ
    // =====================================================
    public function edit() {
        $id = $_GET['id'] ?? 0;

        if (!$id) {
            $_SESSION['error'] = "ID dịch vụ không hợp lệ!";
            header('Location: index.php?act=services');
            exit;
        }

        $service = $this->serviceModel->getServiceById($id);
        if (!$service) {
            $_SESSION['error'] = "Không tìm thấy dịch vụ!";
            header('Location: index.php?act=services');
            exit;
        }

        $tours = $this->modelTour->getAllTours();
        $GLOBALS['service'] = $service;

        require_once BASE_URL_VIEWS . 'admin/services/edit.php';
    }

    // =====================================================
    // 5. Lưu cập nhật dịch vụ
    // =====================================================
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?act=services');
            exit;
        }

        $id           = $_POST['id'] ?? 0;
        $service_name = trim($_POST['service_name'] ?? '');
        $partner_name = trim($_POST['partner_name'] ?? '');
        $status       = $_POST['status'] ?? 'pending';
        $note         = trim($_POST['note'] ?? '');

        if (!$id || empty($service_name)) {
            $_SESSION['error'] = "Thông tin không hợp lệ!";
            header("Location: index.php?act=servicesEdit&id=$id");
            exit;
        }

        $result = $this->serviceModel->update(
            $id,
            $service_name,
            $partner_name,
            $status,
            $note
        );

        $_SESSION[$result ? 'success' : 'error'] =
            $result ? "Cập nhật thành công!" : "Cập nhật thất bại!";

        header('Location: index.php?act=services');
        exit;
    }

    // =====================================================
    // 6. Xóa dịch vụ
    // =====================================================
    public function delete() {
        $id = $_GET['id'] ?? 0;

        if (!$id) {
            $_SESSION['error'] = "ID không hợp lệ!";
            header('Location: index.php?act=services');
            exit;
        }

        $service = $this->serviceModel->getServiceById($id);
        if (!$service) {
            $_SESSION['error'] = "Không tìm thấy dịch vụ!";
            header('Location: index.php?act=services');
            exit;
        }

        $result = $this->serviceModel->delete($id);

        $_SESSION[$result ? 'success' : 'error'] =
            $result ? "Đã xóa dịch vụ!" : "Xóa thất bại!";

        header('Location: index.php?act=services');
        exit;
    }
}
?>
