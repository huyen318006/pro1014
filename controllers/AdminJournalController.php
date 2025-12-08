<?php
// AdminJournalController.php
class AdminJournalController {
    private $model;

    public function __construct() {
        $this->model = new Journals();
    }

    // Trang danh sách nhật ký
    public function index() {
        // Lấy tất cả nhật ký
        $journals = $this->model->getAllJournalsForAdmin();
        $title = "Danh sách nhật ký tour";
        require './views/admin/journals/index.php';
    }

    // Xem chi tiết một nhật ký
    public function show($id = 0) {
        $journal = $this->model->getByIdForAdmin($id);
        if (!$journal) {
            $_SESSION['error'] = "Không tìm thấy nhật ký!";
            header('Location: ?act=adminJournals');
            exit;
        }
        $title = "Chi tiết nhật ký tour";
        require './views/admin/journals/show.php';
    }
}
