<h2>Tạo báo cáo sự cố</h2>
<form action="" method="POST">
    <label>Chọn Assignment / HDV:</label>
    <select name="assignment_id" required>
        <option value="">-- Chọn --</option>
        <?php foreach($assignments as $a): ?>
            <option value="<?= $a['id'] ?>">
                <?= $a['guide_name'] ?> | Tour ID: <?= $a['tour_id'] ?? '-' ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <label>Ngày sự cố:</label>
    <input type="date" name="incident_date" required>
    <br><br>

    <label>Mô tả:</label>
    <textarea name="description" required></textarea>
    <br><br>

    <label>Mức độ:</label>
    <select name="severity" required>
        <option value="low">Low</option>
        <option value="medium">Medium</option>
        <option value="high">High</option>
    </select>
    <br><br>

    <label>Cách xử lý:</label>
    <textarea name="resolution"></textarea>
    <br><br>

    <button type="submit">Gửi báo cáo</button>
</form>
