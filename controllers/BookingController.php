<?php 
class BookingController {
    public $bookingModel;
    public $depaturesModel;


    private $model;

    public $assign;

    public function __construct(){
        $this->bookingModel= new BookingModel();
        $this->depaturesModel= new Departures();
        $this->model = new UserModel();
    }
    

    //giao dienj booking
    function booking() {
        $departures = $this->bookingModel->getAllDepartures();
        require_once BASE_URL_VIEWS.'admin/booking/booking.php';
    }

    //phần khi nhấn vào đặt tour//
    public function bookingassig() {
       if(isset($_GET['id'])){
        $id=$_GET['id'];
        $departuer=$this->depaturesModel->departureandbooking($id);
            $guides = $this->model->getAllGuides();
            $getallbooking = $this->bookingModel->getallbooking();
            require_once BASE_URL_VIEWS . 'admin/booking/bookingassig.php';
       }
    }
    public function addbooking()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Lấy dữ liệu
            $departure_id   = $_POST['departure_id'] ?? null;
            $customer_name  = $_POST['customer_name'] ?? '';
            $customer_phone = $_POST['customer_phone'] ?? '';
            $customer_email = $_POST['customer_email'] ?? '';
            $quantity       = (int)($_POST['quantity'] ?? 1);
            $note           = $_POST['note'] ?? '';
            $guide_id       = $_POST['guide_id'] ?? null;

            // KIỂM TRA TRÙNG GUIDE
            if (!empty($guide_id) && $this->model->checkDuplicate($guide_id, $departure_id)) {
                // TRÙNG → báo lỗi + ở lại trang form
                $_SESSION['error'] = "Hướng dẫn viên này đã được phân công cho lịch khởi hành này rồi!";
                header("Location: ?act=bookingassig&id=" . $departure_id);
                exit();
            } else {
                // KHÔNG TRÙNG → được phép đặt tour
                $this->bookingModel->addbooking($departure_id, $customer_email, $customer_name, $customer_phone, $quantity, $note, $guide_id);
                $this->depaturesModel->updateSeats($departure_id, $quantity);

                $_SESSION['success'] = "Đặt tour thành công!";
                header('Location: ?act=booking');
                exit();
            }
        }
    }



}
?>