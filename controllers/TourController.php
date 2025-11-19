<?php
// có class chứa các function thực thi xử lý logic 
class TourController
{
    public $modelTour;
    private $allowedStatuses = ['draft', 'published', 'archived'];


    public function __construct()
    {
        $this->modelTour = new TourModel();
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

    /////////////////////////////////////////        phần thêm danh sách tour      /////////////////////////////////////////
    public function addTourForm()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $code = $_POST['code'] ?? '';
            $name = $_POST['name'] ?? '';
            $destination = $_POST['destination'] ?? '';
            $type = $_POST['type'] ?? '';
            $status = $_POST['status'] ?? 'published';
            $price = $_POST['price'] ?? '';
            $duration_days = $_POST['duration_days'] ?? '';
            $data = [
                ':code' => $code,
                ':name' => $name,
                ':destination' => $destination,
                ':type' => $type,
                ':status' => $status,
                ':price' => $price,
                ':duration_days' => $duration_days
            ];
            $result = $this->modelTour->addTour($data);
            if($result){
                $_SESSION['success'] = 'Thêm tour thành công';
            }else{
                $_SESSION['error'] = 'Thêm tour thất bại';
            }
            header('Location: ' . BASE_URL . '?act=listTours');
            exit();
        }
        require_once BASE_URL_VIEWS . 'admin/tour/add.php';
    }

    /////////////////////////////////////////        phần sửa tour      /////////////////////////////////////////
    public function editTourForm($id)
    {
        if (!$id) {
            header('Location: ' . BASE_URL . '?act=listTours');
            exit();
        }

        $tour = $this->modelTour->getTourById($id);

        if (!$tour) {
            header('Location: ' . BASE_URL . '?act=listTours');
            exit();
        }


            $id = $tour['id'];
            $code = $tour['code'];
            $name = $tour['name'];
            $destination = $tour['destination'];
            $type = $tour['type'];
            $status = $tour['status'];
            $price = $tour['price'];
            $duration_days = $tour['duration_days'];
            if (empty($errors)) {
                $data = [
                    ':code' => $code,
                    ':name' => $name,
                    ':destination' => $destination,
                    ':type' => $type,
                    ':status' => $status,
                    ':price' => $price,
                    ':duration_days' => $duration_days,
                    ':id' => $id
                ];
                $result = $this->modelTour->updateTour($data);
                if($result){
                    $_SESSION['success'] = 'Cập nhật tour thành công';
                }else{
                    $_SESSION['error'] = 'Cập nhật tour thất bại';
                }
                header('Location: ' . BASE_URL . '?act=listTours');
                exit();
            }
            require_once BASE_URL_VIEWS . 'admin/tour/edit.php';
    }
    /////////////////////////////////////////        phần xoá tour      /////////////////////////////////////////
    public function deleteTourForm($id)
    {
        if(isset($_POST['submit'])){
            $result = $this->modelTour->deleteTour($id);
            if($result){
                $_SESSION['success'] = 'Xoá tour thành công';
            }else{
                $_SESSION['error'] = 'Xoá tour thất bại';
            }
            header('Location: ' . BASE_URL . '?act=listTours');
            exit();
        }
    }

}
