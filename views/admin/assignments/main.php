<!DOCTYPE html>

<html lang="vi">

<head>
  <meta charset="UTF-8">
  <title>Danh sách phân công HDV | LOFT CITY</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap 5 + FontAwesome -->

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?= BASE_URL ?>asset/css/trangchu.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>asset/css/assignments.css">
</head>

<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <div class="logo">
      <i class="fas fa-user-shield"></i>
    </div>
    <h4>ADMIN</h4>
    <a href="index.php?act=home" class="active"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a>
    <a href="<?= BASE_URL . '?act=account' ?>"><i class="fas fa-users-cog"></i> <span>Quản lý tài khoản</span></a>
    <a href="index.php?act=listTours"><i class="fas fa-map-marked-alt"></i> <span>Quản lý Tour</span></a>
    <a href="index.php?act=listItinerary"><i class="fas fa-route"></i> <span>Quản lý Lịch Trình</span></a>
    <a href="?act=listAssignments"><i class="fas fa-user-secret"></i> <span>Phân công HDV</span></a>
    <a href="index.php?act=services"><i class="fas fa-concierge-bell"></i> <span>Quản lý Dịch Vụ</span></a>
    <a href="index.php?act=policies"><i class="fas fa-scroll"></i> <span>Quản lý Chính Sách</span></a>
    <a href="?act=incidents"><i class="fas fa-exclamation-triangle"></i><span>Danh sách báo cáo</span></a>
    <a href="<?= BASE_URL . '?act=DepartureAdmin' ?>"><i class="fas fa-plane-departure"></i> <span>Lịch khởi hành</span></a>
    <a href="<?= BASE_URL . '?act=booking'  ?>"><i class="fas fa-receipt"></i><span>Quản lý Booking</span></a>
    <a href="<?= BASE_URL . '?act=logout'  ?>"><i class="fas fa-sign-out-alt"></i> <span>Đăng xuất</span></a>
  </div>

  <!-- Header -->

  <div class="header">
    <h5><i class="fas fa-list"></i> Danh sách phân công HDV</h5>
    <div class="user-info"><i class="fas fa-user-circle"></i> Admin <?= htmlspecialchars($_SESSION['user']['fullname'] ?? '') ?></div>
  </div>

  <!-- Content -->

  <div class="content">
    <
      <div class="table-card">
      <div class="table-responsive">
        <table class="table table-hover align-middle">
          <thead class="table-light">
            <tr>
              <th>ID</th>
              <th>Hướng dẫn viên</th>
              <th>Tour</th>
              <th>Ngày khởi hành</th>
              <th>Điểm tập trung</th>
              <th>Số lượng tối đa</th>
              <th>Ghi chú</th>
              <th>Trạng thái</th>
              <th>Thời gian phân công</th>
              <th>Hành động</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($assignList)): ?>
              <?php foreach ($assignList as $a): ?>
                <tr>
                  <td><?= $a['id'] ?></td>
                  <td><?= $a['guide_name'] ?></td>
                  <td><?= $a['tour_name'] ?></td>
                  <td><?= $a['departure_date'] ?></td>
                  <td><?= $a['meeting_point'] ?></td>
                  <td><?= $a['max_participants'] ?></td>
                  <td><?= $a['note'] ?></td>
                  <td>
                    <form method="POST" action="<?= BASE_URL ?>?act=updateStatus" class="d-inline">
                      <input type="hidden" name="departure_id" value="<?= $a['departure_id'] ?>">
                      <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="planned" <?= $a['departure_status'] == 'planned' ? 'selected' : '' ?>>Planned</option>
                        <option value="ready" <?= $a['departure_status'] == 'ready' ? 'selected' : '' ?>>Ready</option>
                      </select>
                    </form>
                  </td>
                  <td><?= date('d/m/Y H:i', strtotime($a['assigned_at'])) ?></td>
                  <td>
                    <?php
                    if ($a['departure_status'] !== 'ready') {
                    ?>
                      <div class="btn-action-group">
                        <a href="<?= BASE_URL ?>?act=editAssignment&id=<?= $a['id'] ?>" class="btn btn-primary btn-action"><i class="fas fa-edit"></i></a>
                        <a href="<?= BASE_URL ?>?act=deleteAssignment&id=<?= $a['id'] ?>" class="btn btn-danger btn-action" onclick="return confirm('Xóa phân công này?')"><i class="fas fa-trash"></i></a>
                        <a href="<?= BASE_URL ?>?act=showChecklistForAdmin&departure_id=<?= $a['departure_id'] ?>" class="btn btn-info btn-action"><i class="fas fa-clipboard-check"></i></a>
                      </div>
                    <?php
                    } else { ?>
                      <!-- Khi trạng thái là ready, dùng onclick alert -->
                      <a href="javascript:void(0);"
                        onclick="alert('Không thể sửa khi trạng thái tour đã Ready!');"
                        class="btn btn-secondary btn-action">
                        <i class="fas fa-edit text-light" title="Không thể sửa"></i>
                      </a>

                      <a href="javascript:void(0);"
                        onclick="alert('Không thể xóa khi trạng thái tour đã Ready!');"
                        class="btn btn-secondary btn-action">
                        <i class="fas fa-trash text-light" title="Không thể xóa"></i>
                      </a>
                      <a href="<?= BASE_URL ?>?act=showChecklistForAdmin&departure_id=<?= $a['departure_id'] ?>" class="btn btn-info btn-action"><i class="fas fa-clipboard-check"></i></a>


                    <?php

                    }
                    ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="10" class="text-center">Chưa có phân công nào</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
  </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>