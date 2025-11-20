<h2>Checklist Tour</h2>

<?php if(isset($_GET['success'])): ?>
    <p style="color: green;">Đã lưu checklist thành công!</p>
<?php endif; ?>

<form method="POST" action="?act=saveChecklistForGuide">
    <input type="hidden" name="departure_id" value="<?= $_GET['departure_id'] ?>">

    <?php foreach($checklistItems as $item): ?>
        <label>
            <input type="checkbox" name="checked[]" value="<?= $item['item_name'] ?>"
            <?= ($item['is_checked'] && $item['checked_by_name'] == $_SESSION['user']['fullname']) ? 'checked' : '' ?>>
            <?= $item['item_name'] ?>
        </label><br>
    <?php endforeach; ?>

    <button type="submit" class="btn btn-success">Lưu checklist</button>
</form>
