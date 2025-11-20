<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quản lý Dịch vụ đi kèm</title>
    
    <!-- Bootstrap 5 + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        body { background-color: #f8f9fa; }
        .container { max-width: 1200px; }
        .status-confirmed { background-color: #d4edda; }
        .status-pending   { background-color: #fff3cd; }
        .status-cancelled { background-color: #f8d7da; }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-primary">
                <i class="bi bi-bus-front"></i> Quản lý Dịch vụ đi kèm (Khách sạn, Xe, Nhà hàng...)
            </h2>
            <a href="index.php?act=servicesCreate" class="btn btn-success btn-lg shadow">
                <i class="bi bi-plus-circle"></i> Thêm Dịch vụ
            </a>
        </div>

        <!-- Thông báo -->
        <?php if(isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <?= $_SESSION['success']; unset($_SESSION['success']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <?php if(isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th width="5%">#ID</th>
                                <th width="25%">Chuyến đi</th>
                                <th width="15%">Loại dịch vụ</th>
                                <th width="20%">Đối tác</th>
                                <th width="10%">Trạng thái</th>
                                <th width="15%">Ghi chú</th>
                                <th width="10%">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($services)): ?>
                                <?php foreach($services as $s): ?>
                                    <tr class="<?= $s['status']=='confirmed'?'status-confirmed':($s['status']=='pending'?'status-pending':'status-cancelled') ?>">
                                        <td class="fw-bold"><?= $s['id'] ?></td>
                                        
                                        <!-- Cột hiển thị chuyến đi đẹp -->
                                        <td>
                                            <?php if(!empty($s['tour_name'])): ?>
                                                <div class="fw-bold text-primary"><?= htmlspecialchars($s['tour_name']) ?></div>
                                                <small class="text-muted">
                                                    <i class="bi bi-calendar-event"></i> <?= $s['departure_date_formatted'] ?? 'Chưa có ngày' ?>
                                                    <?php if(!empty($s['meeting_point'])): ?>
                                                        <br><i class="bi bi-geo-alt"></i> <?= htmlspecialchars($s['meeting_point']) ?>
                                                    <?php endif; ?>
                                                </small>
                                            <?php else: ?>
                                                <span class="text-danger fst-italic">Chưa gắn chuyến</span>
                                            <?php endif; ?>
                                        </td>

                                        <td>
                                            <span class="badge bg-info fs-6">
                                                <?= htmlspecialchars(ucfirst($s['service_name'])) ?>
                                            </span>
                                        </td>

                                        <td class="fw-bold"><?= htmlspecialchars($s['partner_name']) ?></td>

                                        <td>
                                            <?php
                                            $statusClass = $s['status']=='confirmed' ? 'success' : ($s['status']=='pending' ? 'warning' : 'danger');
                                            $statusText  = $s['status']=='confirmed' ? 'Đã xác nhận' : ($s['status']=='pending' ? 'Chờ xử lý' : 'Đã hủy');
                                            ?>
                                            <span class="badge bg-<?= $statusClass ?> fs-6">
                                                <?= $statusText ?>
                                            </span>
                                        </td>

                                        <td>
                                            <small><?= nl2br(htmlspecialchars($s['note'] ?? '-')) ?></small>
                                        </td>

                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="index.php?act=servicesEdit&id=<?= $s['id'] ?>" 
                                                   class="btn btn-sm btn-warning" title="Sửa">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <a href="index.php?act=servicesDelete&id=<?= $s['id'] ?>" 
                                                   class="btn btn-sm btn-danger" 
                                                   onclick="return confirm('Xóa dịch vụ này?\n\nĐối tác: <?= htmlspecialchars($s['partner_name']) ?>');"
                                                   title="Xóa">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox display-1"></i><br>
                                        Chưa có dịch vụ nào được thêm
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>