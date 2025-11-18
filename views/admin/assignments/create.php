<h2>Phân công hướng dẫn viên</h2>

<?php if (isset($_SESSION['error'])): ?>
    <p style="color:red"><?= $_SESSION['error']; unset($_SESSION['error']); ?></p>
<?php endif; ?>

<form method="POST" action="?act=storeAssignment">
    <label>Hướng dẫn viên:</label>
    <select name="guide_id" required>
        <?php foreach ($guides as $g): ?>
            <option value="<?= $g['id'] ?>"><?= $g['fullname'] ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <label>Tour:</label>
    <select name="departure_id" required>
        <?php foreach ($departures as $d): ?>
            <option value="<?= $d['id'] ?>"><?= $d['tour_id'] ?> - <?= $d['departure_date'] ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <button type="submit">Phân công</button>
</form>