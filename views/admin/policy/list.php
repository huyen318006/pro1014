
<div class="container mt-4">
    <h3 class="mb-3">Danh sách chính sách Tour</h3>

    <a href="index.php?controller=policy&action=create" class="btn btn-primary mb-3">+ Thêm chính sách</a>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Tour</th>
                <th>Loại chính sách</th>
                <th>Nội dung</th>
                <th width="150">Hành động</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($policies as $p): ?>
                <tr>
                    <td><?= $p['id'] ?></td>
                    <td><?= $p['tour_name'] ?></td>
                    <td><?= $p['policy_type'] ?></td>
                    <td><?= mb_substr($p['content'], 0, 80) ?>...</td>
                    <td>
                        <a href="index.php?controller=policy&action=edit&id=<?= $p['id'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                        <a onclick="return confirm('Xóa chính sách này?')" href="index.php?controller=policy&action=delete&id=<?= $p['id'] ?>" class="btn btn-danger btn-sm">Xóa</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>
