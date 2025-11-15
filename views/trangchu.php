<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard | LOFT CITY</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap 5 + FontAwesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <style>
    :root {
      --primary: #00CED1;
      --primary-dark: #20B2AA;
      --light: #f8f9fa;
      --danger: #dc3545;
      --success: #28a745;
      --warning: #ffc107;
      --info: #17a2b8;
      --dark: #343a40;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background-color: var(--light);
      margin: 0;
    }

    /* Sidebar */
    .sidebar {
      position: fixed;
      top: 0;
      left: 0;
      height: 100%;
      width: 260px;
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      color: white;
      padding-top: 30px;
      box-shadow: 5px 0 20px rgba(0, 206, 209, 0.2);
      z-index: 1000;
    }

    .sidebar .logo {
      text-align: center;
      margin-bottom: 35px;
    }

    .sidebar .logo i {
      font-size: 2.5rem;
      color: white;
    }

    .sidebar h4 {
      text-align: center;
      margin: 10px 0 40px;
      color: #fff;
      font-weight: 700;
      font-size: 1.5rem;
      letter-spacing: 1.2px;
    }

    .sidebar a {
      display: block;
      color: #fff;
      padding: 14px 25px;
      text-decoration: none;
      transition: all 0.3s ease;
      font-weight: 500;
      border-left: 4px solid transparent;
    }

    .sidebar a i {
      width: 25px;
      text-align: center;
      margin-right: 14px;
      font-size: 1.15rem;
    }

    .sidebar a:hover,
    .sidebar a.active {
      background-color: rgba(255, 255, 255, 0.22);
      border-left-color: #fff;
      border-radius: 0 30px 30px 0;
      margin-right: 10px;
      transform: translateX(5px);
    }

    /* Header */
    .header {
      margin-left: 260px;
      background-color: #fff;
      padding: 18px 35px;
      box-shadow: 0 3px 15px rgba(0, 0, 0, 0 specialmente.08);
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: sticky;
      top: 0;
      z-index: 900;
    }

    .header h5 {
      margin: 0;
      color: var(--primary-dark);
      font-weight: 700;
      font-size: 1.35rem;
      letter-spacing: 0.5px;
    }

    .user-info {
      display: flex;
      align-items: center;
      gap: 12px;
      color: var(--primary);
      font-weight: 600;
    }

    .user-info i {
      font-size: 1.9rem;
      color: var(--primary);
    }

    /* Content */
    .content {
      margin-left: 260px;
      padding: 35px;
    }

    /* Stats Cards */
    .stat-card {
      background: #fff;
      border-radius: 16px;
      padding: 25px;
      text-align: center;
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
      transition: all 0.3s ease;
      border: 1px solid #eee;
    }

    .stat-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 12px 28px rgba(0, 206, 209, 0.18);
      border-color: var(--primary);
    }

    .stat-card h6 {
      color: #666;
      font-weight: 500;
      margin-bottom: 14px;
      font-size: 0.95rem;
      text-transform: uppercase;
      letter-spacing: 0.6px;
    }

    .stat-card h3 {
      margin: 0;
      font-weight: 700;
      font-size: 2.3rem;
      color: var(--primary-dark);
    }

    /* Table Cards */
    .table-card {
      background: white;
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
      margin-bottom: 35px;
      border: 1px solid #eee;
    }

    .table-card .card-header {
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      color: white;
      padding: 20px 28px;
      border: none;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .table-card .card-header h5 {
      margin: 0;
      font-weight: 600;
      font-size: 1.15rem;
      letter-spacing: 0.5px;
    }

    .btn-add {
      background: rgba(255, 255, 255, 0.25);
      border: 1px solid rgba(255, 255, 255, 0.4);
      color: white;
      font-size: 0.92rem;
      padding: 7px 16px;
      border-radius: 50px;
      transition: all 0.3s ease;
    }

    .btn-add:hover {
      background: white;
      color: var(--primary-dark);
      transform: translateY(-1px);
    }

    /* Table */
  .table {
    margin: 0;
    font-size: 0.94rem;
  } 

  th {
    background-color: transparent !important;
    color: gray !important;    /* TH = xám */
    font-weight: 600;
    font-size: 0.89rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  .table tbody td {
    color: #666 !important;
    font-weight: 500;
  }

  .table .th {
    color: gray !important;
  }
  .table .badge {
    color: white !important;  
  }

  /* Giữ màu trắng cho button */
  .btn-action {
    color: white !important;
  }
    .avatar {
      width: 42px;
      height: 42px;
      border-radius: 50%;
      object-fit: cover;
      border: 2.5px solid #fff;
      box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
    }

    .badge {
      font-size: 0.78rem;
      padding: 6px 12px;
      border-radius: 50px;
      font-weight: 500;
    }

    .btn-action {
      padding: 6px 10px;
      font-size: 0.88rem;
      border-radius: 10px;
      transition: all 0.2s;
    }

    .btn-action:hover {
      transform: scale(1.1);
    }

    .tour-img {
      width: 58px;
      height: 58px;
      object-fit: cover;
      border-radius: 12px;
      border: 2px solid #eee;
      box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    }

    /* Responsive */
    @media (max-width: 992px) {
      .sidebar {
        width: 80px;
        padding-top: 20px;
      }
      .sidebar .logo, .sidebar h4, .sidebar a span {
        display: none;
      }
      .sidebar a {
        text-align: center;
        padding: 16px 0;
      }
      .sidebar a i {
        margin: 0;
        font-size: 1.3rem;
      }
      .header, .content {
        margin-left: 80px;
      }
    }

    @media (max-width: 576px) {
      .header h5 { font-size: 1.15rem; }
      .content { padding: 20px; }
      .table-card .card-header {
        flex-direction: column;
        gap: 12px;
        text-align: center;
      }
      .stat-card h3 { font-size: 1.9rem; }
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <div class="logo">
      <i class="fas fa-user-shield"></i>
    </div>
    <h4>ADMIN</h4>
    <a href="#" class="active"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a>
    <a href="#"><i class="fas fa-users-cog"></i> <span>Quản lý tài khoản</span></a>
    <a href="#"><i class="fas fa-map-marked-alt"></i> <span>Quản lý Tour</span></a>
    <a href="#"><i class="fas fa-shopping-cart"></i> <span>Quản lý đơn đặt</span></a>
    <a href="#"><i class="fas fa-comments"></i> <span>Quản lý bình luận</span></a>
    <a href="#"><i class="fas fa-plane-departure"></i> <span>Lịch khởi hành</span></a>
    <a href="<?= BASE_URL ?>?act=logout"><i class="fas fa-sign-out-alt"></i> <span>Đăng xuất</span></a>
  </div>

  <!-- Header -->
  <div class="header">
    <h5><i class="fas fa-cogs"></i> Bảng điều khiển quản trị</h5>
    <div class="user- info">
      <i class="fas fa-user-circle"></i>
      <span>Admin Chủ</span>
    </div>
  </div>

  <!-- Content -->
  <div class="content">

    <!-- Stats Cards -->
    <div class="row g-4 mb-5">
      <div class="col-md-3 col-6">
        <div class="stat-card">
          <h6>Tổng người dùng</h6>
          <h3>1,248</h3>
        </div>
      </div>
      <div class="col-md-3 col-6">
        <div class="stat-card">
          <h6>Tổng Tour</h6>
          <h3>68</h3>
        </div>
      </div>
      <div class="col-md-3 col-6">
        <div class="stat-card">
          <h6>Đơn đặt hôm nay</h6>
          <h3>42</h3>
        </div>
      </div>
      <div class="col-md-3 col-6">
        <div class="stat-card">
          <h6>Doanh thu tháng</h6>
          <h3>875tr</h3>
        </div>
      </div>
    </div>

    <!-- Quản lý tài khoản -->
    <div class="table-card">
      <div class="card-header">
        <h5>Quản lý tài khoản</h5>
        <button class="btn-add"><i class="fas fa-plus"></i> Thêm tài khoản</button>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead>
              <tr>
                <th>ID</th>
                <th>Avatar</th>
                <th>Họ tên</th>
                <th>Email</th>
                <th>Vai trò</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td><img src="https://via.placeholder.com/42/00CED1/white?text=A" alt="" class="avatar"></td>
                <td><strong>Nguyễn Văn Admin</strong></td>
                <td>admin@loft.com</td>
                <td><span class="badge bg-danger">Admin</span></td>
                <td><span class="badge bg-success">Hoạt động</span></td>
                <td>
                  <button class="btn btn-primary btn-action" title="Sửa"><i class="fas fa-edit"></i></button>
                  <button class="btn btn-warning btn-action" title="Phân quyền"><i class="fas fa-user-shield"></i></button>
                </td>
              </tr>
              <tr>
                <td>2</td>
                <td><img src="https://via.placeholder.com/42/20B2AA/white?text=S" alt="" class="avatar"></td>
                <td><strong>Trần Thị Staff</strong></td>
                <td>staff@loft.com</td>
                <td><span class="badge bg-info text-white">Staff</span></td>
                <td><span class="badge bg-success">Hoạt động</span></td>
                <td>
                  <button class="btn btn-primary btn-action"><i class="fas fa-edit"></i></button>
                  <button class="btn btn-warning btn-action"><i class="fas fa-user-shield"></i></button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Quản lý Tour -->
    <div class="table-card">
      <div class="card-header">
        <h5>Quản lý Tour</h5>
        <button class="btn-add"><i class="fas fa-plus"></i> Thêm Tour</button>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead>
              <tr>
                <th>ID</th>
                <th>Ảnh</th>
                <th>Tên Tour</th>
                <th>Giá</th>
                <th>Địa điểm</th>
                <th>Lượt đặt</th>
                <th>Hành động</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td><img src="https://via.placeholder.com/58/00CED1/white?text=DL" alt="" class="tour-img"></td>
                <td><strong>Đà Lạt 3N2Đ</strong></td>
                <td><strong style="color: var(--primary);">2.890.000đ</strong></td>
                <td>Đà Lạt</td>
                <td>142</td>
                <td>
                  <button class="btn btn-primary btn-action"><i class="fas fa-edit"></i></button>
                  <button class="btn btn-danger btn-action"><i class="fas fa-trash"></i></button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Lịch khởi hành -->
    <div class="table-card">
      <div class="card-header">
        <h5>Lịch khởi hành</h5>
        <button class="btn-add"><i class="fas fa-plus"></i> Thêm lịch</button>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead>
              <tr>
                <th>ID</th>
                <th>Tour</th>
                <th>Ngày đi</th>
                <th>Điểm đón</th>
                <th>Số chỗ</th>
                <th>Ghi chú</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>Đà Lạt 3N2Đ</td>
                <td>05/12/2025</td>
                <td>Bến xe Mỹ Đình</td>
                <td><span class="badge bg-info">25</span></td>
                <td>Chuẩn bị xe 45 chỗ</td>
                <td><span class="badge bg-warning">Planned</span></td>
                <td>
                  <button class="btn btn-primary btn-action"><i class="fas fa-edit"></i></button>
                  <button class="btn btn-danger btn-action"><i class="fas fa-trash"></i></button>
                </td>
              </tr>
              <tr>
                <td>2</td>
                <td>Phú Quốc 4N3Đ</td>
                <td>10/12/2025</td>
                <td>Sân bay Đà Nẵng</td>
                <td><span class="badge bg-info">20</span></td>
                <td>Check-in lúc 6h sáng</td>
                <td><span class="badge bg-success">Ready</span></td>
                <td>
                  <button class="btn btn-primary btn-action"><i class="fas fa-edit"></i></button>
                  <button class="btn btn-danger btn-action"><i class="fas fa-trash"></i></button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>