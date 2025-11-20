<h2>Danh sách checklist của HDV</h2>

<table class="table table-bordered">
<tr>
    <th>Tên mục</th>
    <th>Trạng thái</th>
    <th>Hướng dẫn viên thực hiện</th>
</tr>

<?php foreach($checklistItems as $item): ?>
<tr>
    <td><?= $item['item_name'] ?></td>
    <td><?= $item['is_checked'] ? 'Đã tick' : 'Chưa tick' ?></td>
    <td><?= $item['checked_by_name'] ?? '-' ?></td>
</tr>
<?php endforeach; ?>
</table>

<a href="?act=listAssignments" class="btn btn-primary">Quay lại trang phân công HDV</a>
