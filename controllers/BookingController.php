<?php 
class BookingController {
    public $bookingModel;
    public $depaturesModel;

    public function __construct(){
        $this->bookingModel= new BookingModel();
        $this->depaturesModel= new Departures();
    }
    

    //giao dienj booking
    function booking() {
        $departures = $this->depaturesModel->getAllDepartures();
        require_once BASE_URL_VIEWS.'admin/booking/booking.php';
    }
    public function bookingassig() {
       if(isset($_GET['id'])){
        $id=$_GET['id'];
        $departuer=$this->depaturesModel->departureandbooking($id);
            require_once BASE_URL_VIEWS . 'admin/booking/bookingassig.php';
       }
    }
    public function addbooking()
    {
        // Lấy dữ liệu từ form POST
        $departure_id   = $_POST['departure_id'] ?? null;
        $customer_name  = $_POST['customer_name'] ?? '';
        $customer_phone = $_POST['customer_phone'] ?? '';
        $customer_email = $_POST['customer_email'] ?? '';
        $quantity       = $_POST['quantity'] ?? 1;
        $note           = $_POST['note'] ?? '';

        $this->bookingModel->addbooking($departure_id,$customer_email,$customer_name,$customer_phone,$quantity,$note);
        //cập nhật số ghế khi khách đã đặt xong
        $this->depaturesModel->updateSeats($departure_id, $quantity);
        header('location: ?act=booking');

        
    }
}
?>