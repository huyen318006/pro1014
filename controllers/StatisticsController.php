<?php

class StatisticsController
{
    private $model;

    public function __construct()
    {
        $this->model = new StatisticsModel();
    }

    // Trang thống kê tổng hợp
    public function index()
    {
        // 1. Tổng quan
        $summary = $this->model->getSummaryStats();

        // 2. Doanh thu theo tour
        $revenueByTour = $this->model->getRevenueByTour();

        // 3. Số khách theo tour
        $customersByTour = $this->model->getCustomerCountByTour();

        // 4. Số khách theo tháng
        $customersByMonth = $this->model->getCustomerByMonth();

        // 5. Doanh thu theo tháng
        $revenueByMonth = $this->model->getRevenueByMonth();

        // Trả dữ liệu sang view
        $title = "Thống kê tổng quan";

        require_once "views/admin/statistics/index.php";
    }

    public function tourDetail()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            die("Thiếu ID tour!");
        }

        $tour = $this->model->getTourDetail($id);

        if (!$tour) {
            die("Không tìm thấy tour!");
        }

        $title = "Chi tiết thống kê tour";

        require_once "views/admin/statistics/detail.php";
    }


}
