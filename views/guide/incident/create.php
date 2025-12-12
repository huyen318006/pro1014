<!DOCTYPE html>

<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Tour Được Giao | LOFT CITY</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- CSS Guide -->
    <link rel="stylesheet" href="<?= BASE_URL ?>asset/css/guide.css">
    <style>
        /* ===== MY TOUR TABLE ===== */
        .table-card table th {
            background-color: #dedfe0ff;
            color: white;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.88rem;
        }

        .table-card table td {
            font-size: 0.92rem;
            vertical-align: middle;
        }

        /* STATUS BADGE */
        .status-badge {
            display: inline-block;
            padding: 0.45em 0.9em;
            font-size: 0.85rem;
            font-weight: 600;
            border-radius: 20px;
            text-transform: capitalize;
            color: #c45252ff;
            transition: all 0.3s ease;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        }

        .status-pending {
            background-color: #f7b456ff;
        }

        .status-confirmed {
            background-color: #28a745;
        }

        .status-cancelled {
            background-color: #dc3545;
        }

        .status-unknown {
            background-color: #6c757d;
        }

        .status-badge:hover {
            transform: scale(1.05);
            opacity: 0.9;
        }

        /* BUTTON XEM CHECKLIST */
        .btn-checklist {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.45rem 1rem;
            font-size: 0.9rem;
            font-weight: 600;
            color: #f8f8f5 !important;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 12px;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(124, 215, 225, 0.25);
        }

        .btn-checklist:hover {
            background: linear-gradient(135deg, #00bcd4, #006978);
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 6px 16px rgba(0, 151, 167, 0.35);
        }

        /* ROW HOVER */
        .table-card table tbody tr:hover {
            background: #f4f9fa;
            transition: 0.25s;
        }
    </style>
</head>
<body>
    <!-- SIDEBAR -->
    <div class="sidebar">
        <div class="logo"><i class="fas fa-hiking"></i></div>
        <h4>HƯỚNG DẪN VIÊN</h4>
        <a href="<?= BASE_URL . '?act=guideDashboard' ?>"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a>
        <a href="<?= BASE_URL . '?act=guideDepartures' ?>"><i class="fas fa-calendar-alt"></i> <span>Lịch khởi hành</span></a>
        <a href="<?= BASE_URL . '?act=MyTour' ?>" class="active"><i class="fas fa-map-marked-alt"></i> <span>Tour được giao</span></a>
        <a href="<?= BASE_URL . '?act=guideJournals' ?>"><i class="fas fa-book"></i> <span>Nhật ký tour</span></a>
        <a href="<?= BASE_URL . '?act=incident' ?>"><i class="fas fa-exclamation-triangle"></i> <span>Báo cáo sự cố</span></a>
        <a href="<?= BASE_URL . '?act=logout' ?>"><i class="fas fa-sign-out-alt"></i> <span>Đăng xuất</span></a>

    </div>

    <!-- HEADER -->

    <div class="header">
        <h5><i class="fas fa-user-tie"></i> Tour Bạn Được Giao</h5>
        <div class="user-info">
            <i class="fas fa-user-circle"></i>
            <span><?= $_SESSION['user']['fullname'] ?? '' ?></span>
        </div>
        </div>

<h2 class="page-title">Tạo báo cáo sự cố</h2>

<form action="?act=incident" method="POST">
    <label>Hướng dẫn viên:</label>
    <input type="text" value="<?= $_SESSION['user']['fullname'] ?>" class="form-control" disabled>
    <br><br>

    <label>Chọn Tour báo cáo:</label>
    <select name="assignment_id" required>
        <option value="">-- Chọn --</option>
        <?php foreach($assignments as $a): ?>
            <option value="<?= $a['id'] ?>"><?= $a['tour_name'] ?></option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <label>Ngày sự cố:</label>
    <input type="date" name="incident_date" required>
    <br><br>

    <label>Mô tả:</label>
    <textarea name="description" required></textarea>
    <br><br>

    <label>Mức độ:</label>
    <select name="severity" required>
        <option value="low">Low</option>
        <option value="medium">Medium</option>
        <option value="high">High</option>
    </select>
    <br><br>

    <label>Cách xử lý:</label>
    <textarea name="resolution"></textarea>
    <br><br>

    <button type="submit">Gửi báo cáo</button>
</form>

</body>


<style>
form {
    max-width: 650px;
    margin: 30px auto;
    padding: 30px 35px;
    background: #fefefe;
    border-radius: 16px;
    box-shadow: 0 10px 28px rgba(0,0,0,0.1);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    transition: all 0.3s ease;
}
form:hover {
    transform: translateY(-2px);
    box-shadow: 0 14px 36px rgba(0,0,0,0.15);
}
form h2 {
    color: #006978;
    margin-bottom: 25px;
    font-size: 1.9rem;
    text-align: center;
}
form label {
    display: block;
    font-weight: 600;
    margin-bottom: 8px;
    color: #333;
}
form input[type="date"],
form select,
form textarea {
    width: 100%;
    padding: 12px 14px;
    margin-bottom: 20px;
    border: 1.5px solid #ccc;
    border-radius: 12px;
    font-size: 1rem;
    transition: border-color 0.3s, box-shadow 0.3s;
}
form input[type="date"]:focus,
form select:focus,
form textarea:focus {
    border-color: #0097A7;
    box-shadow: 0 0 10px rgba(0,151,167,0.2);
    outline: none;
}
form textarea {
    min-height: 120px;
    resize: vertical;
}
form button {
    width: 100%;
    padding: 14px 0;
    font-size: 1.1rem;
    font-weight: 600;
    color: #fff;
    background: linear-gradient(135deg, #0097A7, #006978);
    border: none;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 6px 20px rgba(0,151,167,0.25);
}
form button:hover {
    background: linear-gradient(135deg, #00bcd4, #006978);
    transform: translateY(-2px) scale(1.03);
    box-shadow: 0 8px 28px rgba(0,151,167,0.35);
}
form select option {
    padding: 5px 10px;
}
@media (max-width: 640px) {
    form { padding: 20px 15px; }
}

/* Bảng */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 25px;
    background: #fff;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    box-shadow: 0 6px 18px rgba(0,0,0,0.1);
    border-radius: 10px;
    overflow: hidden;
}
table thead th {
    background-color: #006978;
    color: #fff;
    padding: 12px 10px;
}
table tbody td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
}
table tbody tr:nth-child(even) {
    background-color: #f9f9f9;
}
table tbody tr:hover {
    background-color: #e0f7fa;
}
table a {
    color: #d9534f;
    font-weight: 600;
}
table a:hover {
    text-decoration: underline;
    color: #c9302c;
}
td.severity-low { color: #006400; font-weight: 600; }
td.severity-medium { color: #ff8c00; font-weight: 600; }
td.severity-high { color: #c00; font-weight: 600; }
</style>
<style>
/* Page header for incident create */
.page-title {
    text-align: center;
    color: #006978;
    font-size: 30px;
    font-weight: 700;
    margin: 20px auto 12px;
}

@media (max-width: 640px) {
    .page-title { font-size: 1.3rem; margin-top: 12px; }
}
</style>
</html>