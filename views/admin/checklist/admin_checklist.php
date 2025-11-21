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
<style>
    /* Bảng */
.table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    font-family: Arial, sans-serif;
}

.table th, .table td {
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