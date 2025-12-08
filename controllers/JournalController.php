<?php
// JournalController.php - Controller
class JournalController {
    private $model;

    public function __construct() {
        $this->model = new Journals();
    }

    // Check login helper
    private function checkLogin() {
        if (empty($_SESSION['user']['id'])) {
            header('Location: ?act=logout');
            exit;
        }
        return $_SESSION['user']['id'];
    }

    public function index() {
        $guide_id = $this->checkLogin();
        $journals = $this->model->getJournalsByGuide($guide_id);
        $title = "Nhật ký tour của tôi";
        require './views/guide/journals/index.php';
    }

    public function create() {
        $guide_id = $this->checkLogin();
        $assignments = $this->model->getAssignmentsForJournal($guide_id);
        $title = "Viết nhật ký mới";
        require './views/guide/journals/create.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?act=guideJournals');
            exit;
        }
        $guide_id = $this->checkLogin();

        // Validate dữ liệu
        $assignment_id = intval($_POST['assignment_id'] ?? 0);
        $title = trim($_POST['title'] ?? '');
        $content = trim($_POST['content'] ?? '');
        if (!$assignment_id || !$title || !$content) {
            $_SESSION['error'] = "Vui lòng nhập đầy đủ thông tin!";
            header('Location: ?act=guideJournals');
            exit;
        }

        // Upload nhiều ảnh
        $photos = [];
        if (!empty($_FILES['photos']['name'][0])) {
            foreach ($_FILES['photos']['tmp_name'] as $key => $tmp) {
                if ($_FILES['photos']['error'][$key] == 0) {
                    $path = uploadFile([
                        'name' => $_FILES['photos']['name'][$key],
                        'tmp_name' => $tmp
                    ], 'uploads/journals/');
                    if ($path) $photos[] = $path;
                }
            }
        }

        $data = [
            'assignment_id' => $assignment_id,
            'guide_id' => $guide_id,
            'journal_date' => $_POST['journal_date'],
            'journal_time' => $_POST['journal_time'],
            'title' => $title,
            'content' => $content,
            'location' => $_POST['location'] ?? null,
            'incident' => $_POST['incident'] ?? null,
            'extra_cost' => $_POST['extra_cost'] ?? 0,
            'photos' => !empty($photos) ? json_encode($photos) : null,
            'sent_to_admin' => isset($_POST['sent_to_admin']) ? 1 : 0
        ];

        if ($this->model->create($data)) {
            $_SESSION['success'] = "Thêm nhật ký thành công!";
        } else {
            $_SESSION['error'] = "Thêm thất bại!";
        }
        header('Location: ?act=guideJournals');
        exit;
    }

    public function edit($id = 0) {
        $guide_id = $this->checkLogin();
        $journal = $this->model->getById($id);
        if (!$journal || $journal['guide_id'] != $guide_id) {
            $_SESSION['error'] = "Không có quyền truy cập!";
            header('Location: ?act=guideJournals');
            exit;
        }

        $assignments = $this->model->getAssignmentsForJournal($guide_id);
        $title = "Sửa nhật ký tour";
        require './views/guide/journals/edit.php';
    }

    public function update($id = 0) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?act=guideJournals');
            exit;
        }
        $guide_id = $this->checkLogin();
        $journal = $this->model->getById($id);
        if (!$journal || $journal['guide_id'] != $guide_id) {
            $_SESSION['error'] = "Không có quyền!";
            header('Location: ?act=guideJournals');
            exit;
        }

        // Validate dữ liệu
        $title = trim($_POST['title'] ?? '');
        $content = trim($_POST['content'] ?? '');
        if (!$title || !$content) {
            $_SESSION['error'] = "Vui lòng nhập đầy đủ thông tin!";
            header('Location: ?act=guideJournals');
            exit;
        }

        // Giữ ảnh cũ
        $photos = $journal['photos'] ? json_decode($journal['photos'], true) : [];

        // Upload ảnh mới nếu có
        if (!empty($_FILES['photos']['name'][0])) {
            foreach ($photos as $old) {
                if (file_exists($old)) unlink($old);
            }
            $photos = [];
            foreach ($_FILES['photos']['tmp_name'] as $key => $tmp) {
                if ($_FILES['photos']['error'][$key] == 0) {
                    $path = uploadFile([
                        'name' => $_FILES['photos']['name'][$key],
                        'tmp_name' => $tmp
                    ], 'uploads/journals/');
                    if ($path) $photos[] = $path;
                }
            }
        }

        $data = [
            'journal_date' => $_POST['journal_date'],
            'journal_time' => $_POST['journal_time'],
            'title' => $title,
            'content' => $content,
            'location' => $_POST['location'] ?? null,
            'incident' => $_POST['incident'] ?? null,
            'extra_cost' => $_POST['extra_cost'] ?? 0,
            'photos' => !empty($photos) ? json_encode($photos) : null,
            'sent_to_admin' => isset($_POST['sent_to_admin']) ? 1 : 0
        ];

        if ($this->model->update($id, $data)) {
            $_SESSION['success'] = "Cập nhật thành công!";
        } else {
            $_SESSION['error'] = "Cập nhật thất bại!";
        }
        header('Location: ?act=guideJournals');
        exit;
    }

    public function delete($id = 0) {
        $guide_id = $this->checkLogin();
        $journal = $this->model->getById($id);
        if ($journal && $journal['guide_id'] == $guide_id) {
            $this->model->delete($id);
            $_SESSION['success'] = "Xóa nhật ký thành công!";
        } else {
            $_SESSION['error'] = "Không có quyền xóa!";
        }
        header('Location: ?act=guideJournals');
        exit;
    }

}
