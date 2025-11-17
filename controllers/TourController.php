<?php
// có class chứa các function thực thi xử lý logic 
class TourController
{
    public $modelTour;


    public function __construct()
    {
        $this->modelTour = new TourModel();
    }

    public function Home()
    {
        require_once './views/trangchu.php';
    }


    /////////////////////////////////////////        phần hiển thị danh sách tour      /////////////////////////////////////////
    public function listTours()
    {
        $tours = $this->modelTour->getAllTours();
        require_once BASE_URL_VIEWS . 'tour/list.php';  
    }

    /////////////////////////////////////////        phần thêm danh sách tour      /////////////////////////////////////////
    public function addTourForm()
    {
        $errors = [];
        $success = false;
        $formData = [
            'id' => '',
            'code' => '',
            'name' => '',
            'destination' => '',
            'type' => '',
            'status' => 'active',
            'price' => '',
            'duration_days' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $formData = [
                'id' => trim($_POST['id'] ?? ''),
                'code' => trim($_POST['code'] ?? ''),
                'name' => trim($_POST['name'] ?? ''),
                'destination' => trim($_POST['destination'] ?? ''),
                'type' => trim($_POST['type'] ?? ''),
                'status' => $_POST['status'] ?? 'active',
                'price' => trim($_POST['price'] ?? ''),
                'duration_days' => trim($_POST['duration_days'] ?? '')
            ];

            if ($formData['name'] === '') $errors[] = "Tên tour không được để trống";
            if ($formData['code'] === '') $errors[] = "Mã tour không được để trống";
            if ($formData['destination'] === '') $errors[] = "Địa điểm không được để trống";
            if ($formData['type'] === '') $errors[] = "Loại tour không được để trống";
            if ($formData['price'] === '' || !is_numeric($formData['price'])) $errors[] = "Giá tour phải là số";
            if ($formData['duration_days'] === '' || !is_numeric($formData['duration_days'])) $errors[] = "Số ngày phải là số";

            if (empty($errors)) {
                $data = [
                    ':id' => $formData['id'],
                    ':code' => $formData['code'],
                    ':name' => $formData['name'],
                    ':destination' => $formData['destination'],
                    ':type' => $formData['type'],
                    ':status' => $formData['status'],
                    ':price' => $formData['price'],
                    ':duration_days' => $formData['duration_days']
                ];

                if ($this->modelTour->addTour($data)) {
                    $success = true;
                    $formData = [
                        'id' => '',
                        'code' => '',
                        'name' => '',
                        'destination' => '',
                        'type' => '',
                        'status' => 'active',
                        'price' => '',
                        'duration_days' => ''
                    ];
                } else {
                    $errors[] = "Không thể thêm tour. Vui lòng thử lại!";
                }
            }
        }

        extract($formData);
        require_once BASE_URL_VIEWS . 'tour/add.php';
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

        $errors = [];
        $success = false;
        $formData = [
            'id' => $tour['id'],
            'code' => $tour['code'],
            'name' => $tour['name'],
            'destination' => $tour['destination'],
            'type' => $tour['type'],
            'status' => $tour['status'],
            'price' => $tour['price'],
            'duration_days' => $tour['duration_days']
        ];
        $originalId = $tour['id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $originalId = $_POST['original_id'] ?? $tour['id'];
            $formData = [
                'id' => trim($_POST['id'] ?? ''),
                'code' => trim($_POST['code'] ?? ''),
                'name' => trim($_POST['name'] ?? ''),
                'destination' => trim($_POST['destination'] ?? ''),
                'type' => trim($_POST['type'] ?? ''),
                'status' => $_POST['status'] ?? 'active',
                'price' => trim($_POST['price'] ?? ''),
                'duration_days' => trim($_POST['duration_days'] ?? '')
            ];

            if ($formData['name'] === '') $errors[] = "Tên tour không được để trống";
            if ($formData['code'] === '') $errors[] = "Mã tour không được để trống";
            if ($formData['destination'] === '') $errors[] = "Địa điểm không được để trống";
            if ($formData['type'] === '') $errors[] = "Loại tour không được để trống";
            if ($formData['price'] === '' || !is_numeric($formData['price'])) $errors[] = "Giá tour phải là số";
            if ($formData['duration_days'] === '' || !is_numeric($formData['duration_days'])) $errors[] = "Số ngày phải là số";

            if (empty($errors)) {
                $data = [
                    ':id' => $formData['id'],
                    ':code' => $formData['code'],
                    ':name' => $formData['name'],
                    ':destination' => $formData['destination'],
                    ':type' => $formData['type'],
                    ':status' => $formData['status'],
                    ':price' => $formData['price'],
                    ':duration_days' => $formData['duration_days'],
                    ':original_id' => $originalId
                ];

                if ($this->modelTour->updateTour($data)) {
                    $success = true;
                    $originalId = $formData['id'];
                } else {
                    $errors[] = "Không thể cập nhật tour. Vui lòng thử lại!";
                }
            }
        }

        extract($formData);
        require_once BASE_URL_VIEWS . 'tour/edit.php';
    }
    /////////////////////////////////////////        phần xoá tour      /////////////////////////////////////////
    public function deleteTour($id)
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

        $this->modelTour->deleteTour($id);
        header('Location: ' . BASE_URL . '?act=listTours');
        exit();
    }

}
