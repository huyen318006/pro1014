<?php
// có class chứa các function thực thi xử lý logic 
class ScheduleController
{
    public $modelSchedule;

    public function __construct()
    {
        $this->modelSchedule = new ScheduleModel();
    }

    public function listSchedule()
    {
        $schedules = $this->modelSchedule->getAllSchedules();
        require_once BASE_URL_VIEWS . 'admin/schedule/list.php';
    }
    public function addScheduleForm()
    {
        require_once BASE_URL_VIEWS . 'admin/schedule/add.php';
    }
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            
            // Xử lý upload ảnh
            if (isset($_FILES['urlSP']) && $_FILES['urlSP']['size'] > 0) {
                $data['urlSP'] = upload_file('product', $_FILES['urlSP']);
            } else {
                $data['urlSP'] = 'product/default.jpg';
            }
            
            $this->product->insert($data);
        }
        header("Location:" . BASE_URL);
    }
    public function editScheduleForm()
    {
        if (isset($_GET['id'])) {
            $schedule = $this->modelSchedule->getScheduleById($_GET['id']);
            require_once BASE_URL_VIEWS . 'admin/schedule/edit.php';
        }
    }
    function delete()
    {
        if (isset($_GET['id'])) {
            $this->modelSchedule->deleteSchedule($_GET['id']);
        }
        header("Location:" . BASE_URL . "?act=listSchedule");
    }
}
