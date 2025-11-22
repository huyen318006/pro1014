<?php
class PolicyController
{
    private $modelPolicy;
    private $modelTour;

    public function __construct()
    {
        $this->modelPolicy = new Policy();
        $this->modelTour   = new TourModel(); // để load tên tour, select tour_id
    }

    // ===========================
    // HIỂN THỊ DANH SÁCH POLICIES
    // ===========================
    public function index()
    {
        $policies = $this->modelPolicy->getAllPolicies();
        $tours    = $this->modelTour->getAllTours();

        require_once './views/admin/policies/list.php';
    }

    // ===========================
    // FORM THÊM CHÍNH SÁCH
    // ===========================
    public function create()
    {
        $tours = $this->modelTour->getAllTours();
        require_once './views/admin/policies/create.php';
    }

    // ===========================
    // XỬ LÝ THÊM MỚI
    // ===========================
    public function store()
    {
        if (isset($_POST['submit'])) {
            $tour_id      = $_POST['tour_id'];
            $policy_type  = $_POST['policy_type'];
            $content      = $_POST['content'];

            $result = $this->modelPolicy->createPolicy($tour_id, $policy_type, $content);

            if ($result) {
                $_SESSION['success'] = "Thêm chính sách thành công";
            } else {
                $_SESSION['error'] = "Thêm chính sách thất bại";
            }

            header("Location: " . BASE_URL . "?act=policies");
            exit();
        }
    }

    // ===========================
    // FORM SỬA CHÍNH SÁCH
    // ===========================
    public function edit()
    {
        $id = $_GET['id'] ?? 0;
        $policy = $this->modelPolicy->getPolicyById($id);
        $tours = $this->modelTour->getAllTours();

        require_once './views/admin/policies/edit.php';
    }

    // ===========================
    // XỬ LÝ CẬP NHẬT
    // ===========================
    public function update()
    {
        if (isset($_POST['submit'])) {
            $id          = $_POST['id'];
            $tour_id     = $_POST['tour_id'];
            $policy_type = $_POST['policy_type'];
            $content     = $_POST['content'];

            $result = $this->modelPolicy->updatePolicy($id, $tour_id, $policy_type, $content);

            if ($result) {
                $_SESSION['success'] = "Cập nhật chính sách thành công";
            } else {
                $_SESSION['error'] = "Cập nhật chính sách thất bại";
            }

            header("Location: " . BASE_URL . "?act=policies");
            exit();
        }
    }

    // ===========================
    // XÓA CHÍNH SÁCH
    // ===========================
    public function delete()
    {
        $id = $_GET['id'] ?? 0;

        $result = $this->modelPolicy->deletePolicy($id);

        if ($result) {
            $_SESSION['success'] = "Xóa chính sách thành công";
        } else {
            $_SESSION['error'] = "Xóa chính sách thất bại";
        }

        header("Location: " . BASE_URL . "?act=policies");
        exit();
    }
}
