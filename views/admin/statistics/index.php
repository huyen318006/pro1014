<?php
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: index.php?act=/');
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thống kê tổng quan | LOFT CITY - Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap 5 + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>asset/css/trangchu.css">

</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <div class="logo">
        <i class="fas fa-user-shield text-info fa-2x"></i>
    </div>
    <h4>ADMIN PANEL</h4>
    <a href="index.php?act=home"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a>
    <a href="<?= BASE_URL ?>?act=account"><i class="fas fa-users-cog"></i> <span>Quản lý tài khoản</span></a>
    <a href="index.php?act=listTours"><i class="fas fa-map-marked-alt"></i> <span>Quản lý Tour</span></a>
    <a href="index.php?act=listItinerary"><i class="fas fa-route"></i> <span>Quản lý Lịch Trình</span></a>
    <a href="?act=listAssignments"><i class="fas fa-user-secret"></i> <span>Phân công HDV</span></a>
    <a href="index.php?act=services"><i class="fas fa-concierge-bell"></i> <span>Quản lý Dịch Vụ</span></a>
    <a href="index.php?act=policies"><i class="fas fa-scroll"></i> <span>Quản lý Chính Sách</span></a>
    <a href="?act=incidents"><i class="fas fa-exclamation-triangle"></i> <span>Báo cáo sự cố</span></a>
    <a href="<?= BASE_URL ?>?act=DepartureAdmin"><i class="fas fa-plane-departure"></i> <span>Lịch khởi hành</span></a>
    <a href="<?= BASE_URL ?>?act=booking"><i class="fas fa-receipt"></i> <span>Quản lý Booking</span></a>
    <a href="<?= BASE_URL ?>?act=adminJournals"><i class="fas fa-book"></i> <span>Nhật ký tour</span></a>
    <a href="index.php?act=statistics" class="active"><i class="fas fa-chart-bar"></i> <span>Thống kê</span></a>
    <a href="<?= BASE_URL ?>?act=logout"><i class="fas fa-sign-out-alt"></i> <span>Đăng xuất</span></a>
</div>

<!-- Header -->
<div class="header">
    <h5 class="mb-0"><i class="fas fa-cogs"></i> Bảng điều khiển quản trị</h5>
    <div class="user-info d-flex align-items-center gap-2">
        <i class="fas fa-user-circle fa-2x text-primary"></i>
        <div>
            <strong>Chào mừng,</strong><br>
            <span class="text-muted"><?= htmlspecialchars($_SESSION['user']['fullname'] ?? 'Admin') ?></span>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="main-content container-fluid px-4" style="width: 80%; margin-left: 300px; padding-top: 30px; padding-bottom: 30px;">

    <h2 class="mb-4 text-primary fw-bold">
        <i class="bi bi-graph-up-arrow"></i> Thống kê tổng quan hệ thống
    </h2>

    <?php 
    $summary         ??= [];
    $revenueByTour   ??= [];
    $customersByTour ??= [];
    $customersByMonth??= [];
    $revenueByMonth  ??= [];
    ?>

    <!-- 5 ô thống kê lớn -->
    <div class="row g-4 mb-5 stat-row">
        <div class="col-md-6 col-xl">
            <div class="stat-card card-hover">
                <h5><i class="bi bi-map-fill"></i> Tổng số tour</h5>
                <h2 class="mb-0"><?= number_format($summary['total_tours'] ?? 0) ?></h2>
            </div>
        </div>
        <div class="col-md-6 col-xl">
            <div class="stat-card card-hover" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <h5><i class="bi bi-calendar3"></i> Lịch khởi hành</h5>
                <h2 class="mb-0"><?= number_format($summary['total_departures'] ?? 0) ?></h2>
            </div>
        </div>
        <div class="col-md-6 col-xl">
            <div class="stat-card card-hover" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <h5><i class="bi bi-ticket-perforated"></i> Đơn đặt tour</h5>
                <h2 class="mb-0"><?= number_format($summary['total_bookings'] ?? 0) ?></h2>
            </div>
        </div>
        <div class="col-md-6 col-xl">
            <div class="stat-card card-hover" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                <h5><i class="bi bi-people-fill"></i> Tổng số khách</h5>
                <h2 class="mb-0"><?= number_format($summary['total_customers'] ?? 0) ?> khách</h2>
            </div>
        </div>
        <div class="col-md-6 col-xl">
            <div class="stat-card card-hover" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                <h5><i class="bi bi-wallet2"></i> Tổng doanh thu</h5>
                <h2 class="mb-0"><?= number_format($summary['total_revenue'] ?? 0) ?> ₫</h2>
            </div>
        </div>
    </div>

    <!-- Biểu đồ theo tháng -->
    <div class="row g-4 mb-5">
        <div class="col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-graph-up"></i> Doanh thu theo tháng</h5>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-people"></i> Số khách theo tháng</h5>
                </div>
                <div class="card-body">
                    <canvas id="customerChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Biểu đồ tròn tỷ lệ tour -->
    <div class="row mb-5">
        <div class="col-lg-10 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header text-center text-white" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                    <h4 class="mb-1">Tỷ lệ đóng góp doanh thu theo tour</h4>
                    <small>Top tour có doanh thu cao nhất (các tour còn lại gộp thành "Khác")</small>
                </div>
                <div class="card-body p-4">
                    <canvas id="tourPieChart" height="120"></canvas>
                </div>
                <div class="card-footer bg-light text-center">
                    <small class="text-muted">Tổng doanh thu toàn hệ thống: 
                        <strong class="text-primary"><?= number_format($summary['total_revenue'] ?? 0) ?> ₫</strong>
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Top tour -->
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">Top 10 tour doanh thu cao nhất</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="60">STT</th>
                                    <th>Tên tour</th>
                                    <th class="text-end">Doanh thu</th>
                                    <th width="100"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach(array_slice($revenueByTour, 0, 10) as $i => $row): ?>
                                <tr>
                                    <td class="text-center"><?= $i + 1 ?></td>
                                    <td><strong><?= htmlspecialchars($row['tour_name']) ?></strong></td>
                                    <td class="text-end text-danger fw-bold">
                                        <?= number_format($row['total_revenue']) ?> ₫
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Top 10 tour đông khách nhất</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="60">STT</th>
                                    <th>Tên tour</th>
                                    <th class="text-end">Số khách</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach(array_slice($customersByTour, 0, 10) as $i => $row): ?>
                                <tr>
                                    <td class="text-center"><?= $i + 1 ?></td>
                                    <td><strong><?= htmlspecialchars($row['tour_name']) ?></strong></td>
                                    <td class="text-end text-success fw-bold">
                                        <?= number_format($row['total_customers']) ?> khách
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Scripts -->
<script>
// Dữ liệu biểu đồ tháng
const months = <?= json_encode(array_column(array_reverse($revenueByMonth), 'month')) ?>;
const revenues = <?= json_encode(array_column(array_reverse($revenueByMonth), 'total_revenue')) ?>;
const customers = <?= json_encode(array_column(array_reverse($customersByMonth), 'total_customers')) ?>;

// Doanh thu theo tháng
new Chart(document.getElementById('revenueChart'), {
    type: 'line',
    data: {
        labels: months,
        datasets: [{
            label: 'Doanh thu (₫)',
            data: revenues,
            borderColor: '#667eea',
            backgroundColor: 'rgba(102, 126, 234, 0.15)',
            tension: 0.4,
            fill: true,
            pointBackgroundColor: '#667eea',
            pointRadius: 5
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'top' } },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { callback: v => new Intl.NumberFormat('vi-VN').format(v) + ' ₫' }
            }
        }
    }
});

// Số khách theo tháng
new Chart(document.getElementById('customerChart'), {
    type: 'bar',
    data: {
        labels: months,
        datasets: [{
            label: 'Số khách',
            data: customers,
            backgroundColor: '#38f9d7',
            borderRadius: 8
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'top' } },
        scales: { y: { beginAtZero: true } }
    }
});

// Biểu đồ tròn - Tỷ lệ doanh thu tour
const tourData = <?= json_encode($revenueByTour) ?>;
const topTours = tourData.slice(0, 8);
const otherRevenue = tourData.slice(8).reduce((sum, t) => sum + parseFloat(t.total_revenue || 0), 0);

const pieLabels = topTours.map(t => t.tour_name);
const pieData = topTours.map(t => parseFloat(t.total_revenue || 0));

if (otherRevenue > 0) {
    pieLabels.push('Các tour khác');
    pieData.push(otherRevenue);
}

new Chart(document.getElementById('tourPieChart'), {
    type: 'doughnut',
    data: {
        labels: pieLabels,
        datasets: [{
            data: pieData,
            backgroundColor: ['#FF6384','#36A2EB','#FFCE56','#4BC0C0','#9966FF','#FF9F40','#FF5733','#C70039','#900C3F'],
            borderWidth: 3,
            borderColor: '#fff',
            hoverOffset: 15
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'right', labels: { padding: 20, usePointStyle: true } },
            tooltip: {
                callbacks: {
                    label: ctx => {
                        const val = ctx.parsed;
                        const total = ctx.dataset.data.reduce((a,b)=>a+b,0);
                        const percent = ((val/total)*100).toFixed(1);
                        return `${ctx.label}: ${new Intl.NumberFormat('vi-VN').format(val)} ₫ (${percent}%)`;
                    }
                }
            }
        }
    }
});
</script>
</body>
</html>