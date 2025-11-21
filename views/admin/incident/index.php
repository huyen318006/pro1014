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
