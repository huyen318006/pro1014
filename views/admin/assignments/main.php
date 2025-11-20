<h2>Danh sách phân công hướng dẫn viên</h2>
<a href="?act=createAssignment">+ Thêm phân công</a><br><br>

<table border="1" cellpadding="8" cellspacing="0">
<tr>
    <th>ID</th>
    <th>Hướng dẫn viên</th>
    <th>Tour</th>
    <th>Ngày khởi hành</th>
    <th>Điểm tập trung</th>
    <th>Số lượng tối đa</th>
    <th>Ghi chú</th>
    <th>Trạng thái</th>
    <th>Thời gian phân công</th>
    <th>Hành động</th>
</tr>

<?php foreach($assignList as $a): ?>
<tr>
    <td><?= $a['id'] ?></td>
    <td><?= $a['guide_name'] ?></td>
    <td><?= $a['tour_id'] ?></td>
    <td><?= $a['departure_date'] ?></td>
    <td><?= $a['meeting_point'] ?></td>
    <td><?= $a['max_participants'] ?></td>
    <td><?= $a['note'] ?></td>
    <td>
        <?= $a['departure_status'] ?>
        <!-- Form đổi trạng thái -->
        <form method="POST" action="?act=updateStatus" style="display:inline">
            <input type="hidden" name="departure_id" value="<?= $a['departure_id'] ?>">
            <select name="status" onchange="this.form.submit()">
                <option value="planned" <?= $a['departure_status']=='planned'?'selected':'' ?>>planned</option>
                <option value="ready" <?= $a['departure_status']=='ready'?'selected':'' ?>>ready</option>
            </select>
        </form>
    </td>
    <td><?= $a['assigned_at'] ?></td>
    <td>
        <a href="?act=editAssignment&id=<?= $a['id'] ?>">Sửa</a> |
        <a href="?act=deleteAssignment&id=<?= $a['id'] ?>" onclick="return confirm('Xóa phân công này?')">Xóa</a>
        <a href="index.php?act=showChecklistForAdmin&departure_id=<?= $a['departure_id'] ?>">
            <i class="fas fa-clipboard-check"></i> Xem checklist
        </a>
    </td>
</tr>
<?php endforeach; ?>
</table>
