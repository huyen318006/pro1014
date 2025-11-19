<?php
// có class chứa các function thực thi xử lý logic 
class ItineraryController
{
    public $modelItinerary;

    public function __construct()
    {
        $this->modelItinerary = new ItineraryModel();
    }

    /////////////////////////////////////////        phần hiển thị danh sách lịch trình      /////////////////////////////////////////
    public function listItinerary()
    {
        $itineraries = $this->modelItinerary->getAllItineraries();
        require_once BASE_URL_VIEWS . 'admin/itinerary/list.php';
    }

    /////////////////////////////////////////        phần thêm lịch trình      /////////////////////////////////////////
    public function addItinerary()
    {
        $modelTour = new TourModel();
        $tours = $modelTour->getAllTours();
        
        $errors = [];
        $tour_id = '';
        $day_number = '';
        $title = '';
        $activities = '';
        $notes = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tour_id = $_POST['tour_id'] ?? '';
            $day_number = $_POST['day_number'] ?? '';
            $title = $_POST['title'] ?? '';
            $activities = $_POST['activities'] ?? '';
            $notes = $_POST['notes'] ?? '';

            $data = [
                ':tour_id' => $tour_id,
                ':day_number' => $day_number,
                ':title' => $title,
                ':activities' => $activities,
                ':notes' => $notes,
            ];

            try {
                $result = $this->modelItinerary->addItinerary($data);
                if ($result) {
                    $_SESSION['success'] = 'Thêm lịch trình thành công';
                    header('Location: ' . BASE_URL . '?act=listItinerary');
                    exit();
                } else {
                    $_SESSION['error'] = 'Thêm lịch trình thất bại';
                }
            } catch (PDOException $e) {
                if ($e->getCode() == 23000) {
                    $_SESSION['error'] = 'Mã tour không tồn tại. Vui lòng chọn tour hợp lệ.';
                } else {
                    $_SESSION['error'] = 'Lỗi: ' . $e->getMessage();
                }
            }
        }

        require_once BASE_URL_VIEWS . 'admin/itinerary/add.php';
    }

    /////////////////////////////////////////        phần sửa lịch trình      /////////////////////////////////////////
    public function editItinerary($id)
    {
        $modelTour = new TourModel();
        $tours = $modelTour->getAllTours();
        
        $errors = [];
        $itinerary = $this->modelItinerary->getItineraryById($id);

        if (!$itinerary) {
            $_SESSION['error'] = 'Lịch trình không tồn tại';
            header('Location: ' . BASE_URL . '?act=listItinerary');
            exit();
        }

        $tour_id = $itinerary['tour_id'];
        $day_number = $itinerary['day_number'];
        $title = $itinerary['title'];
        $activities = $itinerary['activities'];
        $notes = $itinerary['notes'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tour_id = $_POST['tour_id'] ?? '';
            $day_number = $_POST['day_number'] ?? '';
            $title = $_POST['title'] ?? '';
            $activities = $_POST['activities'] ?? '';
            $notes = $_POST['notes'] ?? '';

            $data = [
                ':id' => $id,
                ':tour_id' => $tour_id,
                ':day_number' => $day_number,
                ':title' => $title,
                ':activities' => $activities,
                ':notes' => $notes,
            ];

            try {
                $result = $this->modelItinerary->editItinerary($data);
                if ($result) {
                    $_SESSION['success'] = 'Sửa lịch trình thành công';
                    header('Location: ' . BASE_URL . '?act=listItinerary');
                    exit();
                } else {
                    $_SESSION['error'] = 'Sửa lịch trình thất bại';
                }
            } catch (PDOException $e) {
                if ($e->getCode() == 23000) {
                    $_SESSION['error'] = 'Mã tour không tồn tại. Vui lòng chọn tour hợp lệ.';
                } else {
                    $_SESSION['error'] = 'Lỗi: ' . $e->getMessage();
                }
            }
        }

        require_once BASE_URL_VIEWS . 'admin/itinerary/edit.php';
    }

    /////////////////////////////////////////        phần xoá lịch trình      /////////////////////////////////////////
    public function deleteItinerary($id)
    {
        $result = $this->modelItinerary->deleteItinerary($id);
        if ($result) {
            $_SESSION['success'] = 'Xoá lịch trình thành công';
        } else {
            $_SESSION['error'] = 'Xoá lịch trình thất bại';
        }
        header('Location: ' . BASE_URL . '?act=listItinerary');
        exit();
    }
}
