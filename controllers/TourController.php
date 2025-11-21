<?php
// có class chứa các function thực thi xử lý logic 
class TourController
{
    public $modelTour;
    public $modelCategory;
    private $allowedStatuses = ['draft', 'published', 'archived'];


    public function __construct()
    {
        $this->modelTour = new TourModel();
        $this->modelCategory = new CategoryModel();
    }

    public function Home()
    {
        $tours = $this->modelTour->getAllTours();
        require_once './views/admin/trangchu.php';
    }


    /////////////////////////////////////////        phần hiển thị danh sách tour      /////////////////////////////////////////
    public function listTours()
    {
        $tours = $this->modelTour->getAllTours();
        require_once BASE_URL_VIEWS . 'admin/tour/list.php';
    }

    /////////////////////////////////////////        phần hiển thị chi tiết tour      /////////////////////////////////////////
    public function detailTour($id)
    {
        $tour = $this->modelTour->getTourById($id);
        require_once BASE_URL_VIEWS . 'admin/tour/detail.php';
    }

    /////////////////////////////////////////        phần thêm danh sách tour      /////////////////////////////////////////
    public function addTourForm()
    {
        if (isset($_POST['submit'])) { // Kiểm tra người dùng đã submit hay chưa

            $code = $_POST['code'];
            $name = $_POST['name'];
            $destination = $_POST['destination'];
            $category_id = $_POST['category_id'];
            $status = $_POST['status'];
            $price = $_POST['price'];
            $duration_days = $_POST['duration_days'];
            
            $image = $_FILES['image'];
            
            // Upload file ảnh
            $from = $image['tmp_name'];
            $targetFolder = PATH_ROOT . 'uploads/';
            $to = $targetFolder . basename($image['name']); // Ghép thư mục lưu trữ + tên file
            move_uploaded_file($from, $to);

            // Lưu dữ liệu vào trong database
            $result = $this->modelTour->addTour($code, $name, $destination, $category_id, $status, $price, $duration_days, $to);
            
            if ($result) {
                $_SESSION['success'] = 'Thêm tour thành công';
                header('Location: ' . BASE_URL . '?act=listTours'); // Chuyển hướng đến trang danh sách tour
                exit();   
            } else {
                $_SESSION['error'] = 'Thêm tour thất bại';
                header('Location: ' . BASE_URL . '?act=addTourForm');
                exit();
            }
        }
        
        // Hiển thị form thêm tour
        $categories = $this->modelCategory->getCategories();
        require_once BASE_URL_VIEWS . 'admin/tour/add.php';
    }

    /////////////////////////////////////////        phần sửa tour      /////////////////////////////////////////
    public function editTourForm($id)
    {
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            
            // Lấy id của tour đang muốn sửa
            $id = $_GET['id'];
            $categories = $this->modelCategory->getCategories();
            // Lấy dữ liệu của tour đang muốn sửa
            $tour = $this->modelTour->getTourById($id);
            
            if (!$tour) {
                $_SESSION['error'] = 'Tour không tồn tại';
                header('Location: ' . BASE_URL . '?act=listTours');
                exit();
            }

            // Extract dữ liệu tour để đổ ra form
            $code = $tour['code'];
            $name = $tour['name'];
            $destination = $tour['destination'];
            $category_id = $tour['category_id'];
            $status = $tour['status'];
            $price = $tour['price'];
            $duration_days = $tour['duration_days'];

            // Xử lý khi submit form
            if (isset($_POST['submit'])) {
                // Lấy dữ liệu từ form
                $code = $_POST['code'];
                $name = $_POST['name'];
                $destination = $_POST['destination'];
                $category_id = $_POST['category_id'];
                $status = $_POST['status'];
                $price = $_POST['price'];
                $duration_days = $_POST['duration_days'];
                
                // Xử lý hình ảnh - chỉ update nếu có file mới
                $imagePath = $tour['image']; // Giữ nguyên hình ảnh cũ
                if (!empty($_FILES['image']['name'])) {
                    $image = $_FILES['image'];
                    $from = $image['tmp_name'];
                    $targetFolder = PATH_ROOT . 'uploads/';
                    $imagePath = $targetFolder . basename($image['name']);
                    move_uploaded_file($from, $imagePath);
                }

                // Cập nhật tour
                $result = $this->modelTour->updateTour($id, $code, $name, $destination, $category_id, $status, $price, $duration_days, $imagePath);

                if ($result) {
                    $_SESSION['success'] = 'Cập nhật tour thành công';
                    header('Location: ' . BASE_URL . '?act=listTours');
                    exit();
                } else {
                    $_SESSION['error'] = 'Cập nhật tour thất bại';
                    header('Location: ' . BASE_URL . '?act=editTourForm&id=' . $id);
                    exit();
                }
            }
            
            // Hiển thị form
            $categories = $this->modelCategory->getCategories();
            require_once BASE_URL_VIEWS . 'admin/tour/edit.php';
        }
    }
    /////////////////////////////////////////        phần xoá tour      /////////////////////////////////////////
    public function deleteTour($id)
    {
        $result = $this->modelTour->deleteTour($id);
        if ($result) {
            $_SESSION['success'] = 'Xoá tour thành công';
        } else {
            $_SESSION['error'] = 'Xoá tour thất bại';
        }
        header('Location: ' . BASE_URL . '?act=listTours');
        exit();
    }
}
