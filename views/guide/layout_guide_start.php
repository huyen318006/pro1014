<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hướng Dẫn Viên | LOFT CITY</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap + FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL ?>asset/css/guide.css">
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <div class="logo"><i class="fas fa-route"></i></div>
    <h4>HƯỚNG DẪN VIÊN</h4>
    <a href="index.php?guide=dashboard" class="<?php if($active=='dashboard') echo 'active'; ?>"><i class="fas fa-chart-line"></i><span>Dashboard</span></a>
    <a href="index.php?guide=schedule" class="<?php if($active=='schedule') echo 'active'; ?>"><i class="fas fa-calendar-alt"></i><span>Lịch khởi hành</span></a>
    <a href="index.php?guide=assignedTours" class="<?php if($active=='assignedTours') echo 'active'; ?>"><i class="fas fa-map-marked-alt"></i><span>Tour được giao</span></a>
    <a href="index.php?guide=checklist" class="<?php if($active=='checklist') echo 'active'; ?>"><i class="fas fa-clipboard-check"></i><span>Checklist</span></a>
    <a href="index.php?guide=logbook" class="<?php if($active=='logbook') echo 'active'; ?>"><i class="fas fa-book"></i><span>Nhật ký tour</span></a>
    <a href="index.php?guide=incident" class="<?php if($active=='incident') echo 'active'; ?>"><i class="fas fa-exclamation-circle"></i><span>Báo cáo sự cố</span></a>
    <a href="index.php?guide=stats" class="<?php if($active=='stats') echo 'active'; ?>"><i class="fas fa-chart-pie"></i><span>Thống kê</span></a>
    <a href="index.php?guide=profile" class="<?php if($active=='profile') echo 'active'; ?>"><i class="fas fa-user-cog"></i><span>Tài khoản</span></a>
    <a href="index.php?guide=logout"><i class="fas fa-sign-out-alt"></i><span>Đăng xuất</span></a>
</div>

<!-- HEADER -->
<div class="header">
    <h5><i class="fas fa-route"></i> Trang dành cho Hướng Dẫn Viên</h5>
    <div class="user-info">
        <i class="fas fa-user-circle"></i>
        <span><?php echo $_SESSION["guide_name"] ?? "Hướng dẫn viên"; ?></span>
    </div>
</div>

<!-- START CONTENT -->
<div class="content">
