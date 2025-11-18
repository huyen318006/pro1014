<h2>Danh sách phân công hướng dẫn viên</h2>

<a href="?act=createAssignment">+ Thêm phân công</a>

<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Hướng dẫn viên</th>
        <th>Tour</th>
        <th>Ngày khởi hành</th>
        <th>Thời gian phân công</th>
        <th>Hành động</th>
    </tr>
    <?php foreach ($assignList as $a): ?>
        <tr>
            <td><?= $a['id'] ?></td>
            <td><?= $a['guide_name'] ?></td>
            <td><?= $a['tour_id'] ?></td>
            <td><?= $a['departure_date'] ?></td>
            <td><?= $a['assigned_at'] ?></td>
            <td>
                <a href="?act=editAssignment&id=<?= $a['id'] ?>">Sửa</a> |
                <a href="?act=deleteAssignment&id=<?= $a['id'] ?>" onclick="return confirm('Xóa phân công này?')">Xóa</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>