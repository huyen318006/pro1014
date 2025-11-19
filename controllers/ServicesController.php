<?php
class ServicesController
{
    private $serviceModel;

    public function __construct()
    {
        $this->serviceModel = new Services();
    }

    // ============================
    // LIST SERVICES
    // ============================
    public function index()
    {
        $services = $this->serviceModel->getAll();
        require './views/services/list.php';
    }

    // ============================
    // SHOW FORM CREATE
    // ============================
    public function create()
    {
        require './views/services/add.php';
    }

    // ============================
    // STORE DATA
    // ============================
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name        = $_POST['name'];
            $type        = $_POST['type'];
            $price       = $_POST['price'];
            $description = $_POST['description'];

            if (empty($name) || empty($type) || empty($price)) {
                $_SESSION['error'] = "Tên dịch vụ, loại và giá không được để trống!";
                header('Location: index.php?controller=services&action=create');
                exit;
            }

            $this->serviceModel->insert($name, $type, $price, $description);

            $_SESSION['success'] = "Thêm dịch vụ thành công!";
            header('Location: index.php?controller=services&action=index');
            exit;
        }
    }

    // ============================
    // SHOW FORM EDIT
    // ============================
    public function edit()
    {
        $id = $_GET['id'] ?? 0;
        $service = $this->serviceModel->getServiceById($id);

        if (!$service) {
            $_SESSION['error'] = "Không tìm thấy dịch vụ!";
            header('Location: index.php?controller=services&action=index');
            exit;
        }

        require './views/services/edit.php';
    }

    // ============================
    // UPDATE SERVICE
    // ============================
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id          = $_POST['id'];
            $name        = $_POST['name'];
            $type        = $_POST['type'];
            $price       = $_POST['price'];
            $description = $_POST['description'];

            $this->serviceModel->update($id, $name, $type, $price, $description);

            $_SESSION['success'] = "Cập nhật dịch vụ thành công!";
            header('Location: index.php?controller=services&action=index');
            exit;
        }
    }

    // ============================
    // DELETE SERVICE
    // ============================
    public function delete()
    {
        $id = $_GET['id'] ?? 0;
        $this->serviceModel->delete($id);

        $_SESSION['success'] = "Xóa dịch vụ thành công!";
        header('Location: index.php?controller=services&action=index');
        exit;
    }
}
