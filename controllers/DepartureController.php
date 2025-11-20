<?php 
class DepartureController {

    public $departures;
    public $TourModel;
    public function __construct()
    {
        $this->departures = new Departures();
        $this->TourModel = new TourModel();
   
      
    }

    //lịch khởi hành dành cho admin xem và phân công hướng dẫn viên
    public function DepartureAdmin()
    {
        $departures = $this->departures->getAllDepartures();
        
        require_once BASE_URL_VIEWS . 'admin/departureAdmin/DepartureAdmin.php';
    }
    public function editDepartureAdmin()
    {
        if (isset($_GET['id'])) {
            $departures_id = $_GET['id'];
            $departures = $this->departures->getBydeparture($departures_id);
            $getAllTours = $this->TourModel->getAllTours();
            require_once BASE_URL_VIEWS . 'admin/departureAdmin/editdeparture.php';
        }
       
    }

    function updateDeparture()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $departure_id = $_POST['departure_id'];
            $tour_id = $_POST['tour_id'];
            $departure_date = $_POST['departure_date'];
            $max_participants = $_POST['max_participants'];
            $note = $_POST['note'];


            $updateguideDeparture = $this->departures->Updatedeparture($departure_id, $tour_id, $departure_date, $max_participants, $note);
        }
        header("Location: ?act=DepartureAdmin");
    }
    //xóa lịch khởi hành
    public function deleteDepartureAdmin()
    {
        if ($_GET['id']) {
            $id_DepartureAdmin = $_GET['id'];
            $delete_DepartureAdmin = $this->departures->delete_DepartureAdmin($id_DepartureAdmin);
            header("Location: ?act=DepartureAdmin");
        }
    }

    //add thêm lịch
    public function addDepartureAdmin(){
        $getAllTours = $this->TourModel->getAllTours();
        require_once BASE_URL_VIEWS . 'admin/departureAdmin/addDepartureAdmin.php';

    }
    public function addDepartureForm(){
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $tour_id=$_POST['tour'];
            $departure_date= $_POST['departure_date'];
            $meeting_point= $_POST['meeting_point'];
            $max_participants = $_POST['max_participants'];
            $note = $_POST['note'];
            $this->departures->addDeparture($tour_id,$departure_date, $meeting_point,$max_participants,$note);
            header("Location: ?act=DepartureAdmin");
        }


    }
}
?>