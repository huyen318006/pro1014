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
    <a href="#"><i class="fas fa-sign-out-alt"></i> <span>Đăng xuất</span></a>
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