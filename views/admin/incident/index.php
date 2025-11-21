<h2>Danh sách báo cáo sự cố</h2>
<table border="1" cellpadding="5">
    <thead>
        <tr>
            <th>ID</th>
            <th>HDV</th>
            <th>Ngày sự cố</th>
            <th>Mô tả</th>
            <th>Mức độ</th>
            <th>Cách xử lý</th>
            <th>Thời gian báo cáo</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($reports as $r): ?>
        <tr>
            <td><?= $r['id'] ?></td>
            <td><?= $r['guide_name'] ?? 'Chưa gán' ?></td>
            <td><?= $r['incident_date'] ?></td>
            <td><?= $r['description'] ?></td>
            <td><?= $r['severity'] ?></td>
            <td><?= $r['resolution'] ?></td>
            <td><?= $r['reported_at'] ?></td>
            <td>
                <a href="?act=incidentReportsDelete&id=<?= $r['id'] ?>" onclick="return confirm('Bạn có chắc muốn xóa không?')">Xóa</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<style>
    /* ===== Bảng danh sách báo cáo ===== */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    font-family: Arial, sans-serif;
    background: #fff;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    border-radius: 8px;
    overflow: hidden;
}

/* Header bảng */
table thead th {
    background-color: #006978;
    color: #fff;
    font-weight: 600;
    padding: 12px 10px;
    text-align: left;
}

/* Dòng dữ liệu */
table tbody td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
    vertical-align: top;
}

/* Xen kẽ màu dòng chẵn */
table tbody tr:nth-child(even) {
    background-color: #f9f9f9;
}

/* Hover dòng */
table tbody tr:hover {
    background-color: #e0f7fa;
}

/* Link xóa */
table a {
    color: #d9534f;
    text-decoration: none;
    font-weight: 600;
}

table a:hover {
    text-decoration: underline;
    color: #c9302c;
}

/* Tiêu đề trang */
h2 {
    color: #006978;
    font-family: Arial, sans-serif;
    margin-bottom: 15px;
}
</style>