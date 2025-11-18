<?php $active = "schedule"; include "layout_guide.php"; ?>

<h3 class="mb-4">Lịch Khởi Hành</h3>

<div class="table-card">
    <div class="card-header">
        <h5>Lịch trình đã được phân công</h5>
    </div>

    <div class="table-responsive p-0">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tour</th>
                    <th>Ngày đi</th>
                    <th>Điểm đón</th>
                    <th>Số khách</th>
                    <th>Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>12</td>
                    <td>Đà Lạt 3N2Đ</td>
                    <td>05/12/2025</td>
                    <td>Bến xe Mỹ Đình</td>
                    <td><span class="badge bg-info">25</span></td>
                    <td><span class="badge bg-success">Ready</span></td>
                </tr>

                <tr>
                    <td>15</td>
                    <td>Phú Quốc 4N3Đ</td>
                    <td>10/12/2025</td>
                    <td>Sân bay Nội Bài</td>
                    <td><span class="badge bg-info">18</span></td>
                    <td><span class="badge bg-warning">Chuẩn bị</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<?php include "layout_guide_end.php"; ?>
