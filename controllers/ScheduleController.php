<?php
// có class chứa các function thực thi xử lý logic 
class ScheduleController
{
    public $modelSchedule;

    public function __construct()
    {
        $this->modelSchedule = new ScheduleModel();
    }

    /////////////////////////////////////////        phần hiển thị danh sách lịch trình      /////////////////////////////////////////
    public function listSchedule()
    {
        $schedules = $this->modelSchedule->getAllSchedules();
        require_once BASE_URL_VIEWS . 'admin/schedule/list.php';
    }
    /////////////////////////////////////////        phần thêm lịch trình      /////////////////////////////////////////
    public function addSchedule()
    {
        require_once BASE_URL_VIEWS . 'admin/schedule/add.php';
    }
    /////////////////////////////////////////        phần sửa lịch trình      /////////////////////////////////////////
    public function editSchedule()
    {
        require_once BASE_URL_VIEWS . 'admin/schedule/edit.php';
        if(isset($_POST['submit'])){
            $tour_id = $_POST['tour_id'];
            $day_number = $_POST['day_number'];
            $title = $_POST['title'];
            $activities = $_POST['activities'];
            $notes = $_POST['notes'];
            $data = [
                ':tour_id' => $tour_id,
                ':day_number' => $day_number,
                ':title' => $title,
                ':activities' => $activities,
                ':notes' => $notes,
                ':id' => $id,
            ];
            $result = $this->modelSchedule->editSchedule($data);
            if($result){
                $_SESSION['success'] = 'Sửa lịch trình thành công';
            }else{
                $_SESSION['error'] = 'Sửa lịch trình thất bại';
            }
            header('Location: ' . BASE_URL . '?act=listSchedule');
            exit();
        }
        require_once BASE_URL_VIEWS . 'admin/schedule/edit.php';
    }
    /////////////////////////////////////////        phần xoá lịch trình      /////////////////////////////////////////
    public function deleteSchedule()
    {
        require_once BASE_URL_VIEWS . 'admin/schedule/delete.php';
        if(isset($_POST['submit'])){
            $id = $_POST['id'];
            $tour_id = $_POST['tour_id'];
            $data = [
                ':id' => $id,
                ':tour_id' => $tour_id,
            ];
            $result = $this->modelSchedule->deleteSchedule($data);
            if($result){
                $_SESSION['success'] = 'Xoá lịch trình thành công';
            }else{
                $_SESSION['error'] = 'Xoá lịch trình thất bại';
            }
            header('Location: ' . BASE_URL . '?act=listSchedule');
            exit();
        }
        require_once BASE_URL_VIEWS . 'admin/schedule/delete.php';
    }
}
