<h2>Thêm phân công hướng dẫn viên</h2>
<?php if(isset($_SESSION['error'])) { echo "<p style='color:red'>".$_SESSION['error']."</p>"; unset($_SESSION['error']); } ?>

<form method="POST" action="?act=storeAssignment">
<label>Hướng dẫn viên:</label>
<select name="guide_id" required>
    <?php foreach($guides as $g): ?>
        <option value="<?= $g['id'] ?>"><?= $g['fullname'] ?></option>
    <?php endforeach; ?>
</select><br><br>

<label>Tour:</label>
<select name="departure_id" required>
    <?php foreach($departures as $d): ?>
        <option value="<?= $d['id'] ?>">
            <?= $d['tour_id'] ?> - <?= $d['departure_date'] ?> (<?= $d['status'] ?>)
        </option>
    <?php endforeach; ?>
</select><br><br>

<button type="submit">Phân công</button>
</form>
