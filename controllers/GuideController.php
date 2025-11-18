<?php 
//trang chức  năng  hiển thị tour của guide
class GuideController {

    public $departureModel;
    function __construct() {
  
        $this->departureModel = new Departures();
    }

    public function guideDashboard() {
        // Kiểm tra session
        if (!isset($_SESSION['user']['id'])) {
            header('Location: /login.php'); 
            exit(); // nên dùng exit() sau header để dừng script
        }
      
        include './views/guide/guide.php';
    }
//trang lịch khởi hành của guide
    public function guideDepartures() {
        // Kiểm tra session
        if (!isset($_SESSION['user']['id'])) {
            header('Location: /login.php'); 
            exit(); // nên dùng exit() sau header để dừng script
        }
        $departures = $this->departureModel->getAllDepartures();
      
        include './views/guide/Departures.php';
    }

    //ham hiển thị tour được giao cho guide
    public function MyTour() {
        // Kiểm tra session
        if (!isset($_SESSION['user']['id'])) {
            header('Location: /login.php'); // <-- đóng nháy và chấm phẩy
            exit(); // nên dùng exit() sau header để dừng script
        }
        $guide_id = $_SESSION['user']['id']; // Lấy ID hướng dẫn viên từ session
        $MyTour = $this->departureModel->getDeparturesByGuide($guide_id);
      
        include './views/guide/Mytour.php';
    }


}
?>