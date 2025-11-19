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
}
