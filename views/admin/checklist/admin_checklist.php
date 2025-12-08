<h2>Danh sách checklist của HDV</h2>

<!-- THÔNG TIN TOUR + HDV -->
<div style="margin-top: 15px; margin-bottom: 20px; padding: 15px; border-left: 4px solid #006978; background: #f1fafa;">
    <p style="margin: 0; font-size: 16px;">
        <strong>Tour:</strong> <span style="color:#006978;"><?= $checklistItems[0]['tour_name'] ?? 'Không có dữ liệu' ?></span>
    </p>

    <p style="margin: 5px 0 0 0; font-size: 16px;">
        <strong>Ngày khởi hành:</strong> <?= $checklistItems[0]['departure_date'] ?? '-' ?>
    </p>

    <p style="margin: 5px 0 0 0; font-size: 16px;">
        <strong>HDV:</strong> <?= $checklistItems[0]['guide_name'] ?? '<i>HDV vẫn chưa hoàn thiện checklist</i>' ?>
    </p>
</div>


<table class="table table-bordered">
    <tr>
        <th>Tên mục</th>
        <th>Trạng thái</th>
        <th>Hướng dẫn viên thực hiện</th>
    </tr>

    <?php foreach ($checklistItems as $item): ?>
        <tr>
            <td><?= $item['item_name'] ?></td>

            <td>
                <?= $item['is_checked']
                    ? '<span style="color: green; font-weight: 600;">Đã tick</span>'
                    : '<span style="color: gray;">Chưa tick</span>' ?>
            </td>

            <td><?= $item['guide_name'] ?: '-' ?></td>
        </tr>
    <?php endforeach; ?>
</table>



<h3 class="mt-4" style="color:#006978;">Điểm danh Khách hàng</h3>

<table class="table table-bordered mt-3">
    <thead class="table-success">
        <tr>
            <th>Nhân viên</th>
            <th>Chức vụ</th>
            <th>Trạng thái điểm danh</th>
            <th>Thời gian điểm danh</th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td>Nguyễn Văn A</td>
            <td>Lái xe</td>
            <td>
                <span class="badge bg-success">Đã điểm danh</span>
            </td>
            <td>08:15 - 12/03/2025</td>
        </tr>

        <tr>
            <td>Trần Thị B</td>
            <td>Phụ xe</td>
            <td>
                <span class="badge bg-secondary">Chưa điểm danh</span>
            </td>
            <td>-</td>
        </tr>

        <!-- Bạn thêm các dòng khác ở đây -->
    </tbody>
</table>


<a href="?act=listAssignments" class="btn btn-primary">Quay lại trang phân công HDV</a>


<style>
    /* Bảng */
    .table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        font-family: Arial, sans-serif;
    }

    .table th,
    .table td {
        padding: 10px 15px;
        text-align: left;
        border: 1px solid #ccc;
    }

    .table th {
        background-color: #006978;
        color: #fff;
        font-weight: 600;
    }

    .table tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    /* Tiêu đề */
    h2 {
        color: #006978;
        font-family: Arial, sans-serif;
        margin-bottom: 15px;
    }

    /* Nút quay lại */
    .btn-primary {
        display: inline-block;
        padding: 8px 15px;
        font-size: 0.95rem;
        font-weight: 600;
        color: #fff;
        background-color: #006978;
        border: none;
        border-radius: 6px;
        text-decoration: none;
        margin-top: 15px;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0097A7;
        transform: translateY(-2px);
    }
</style>