<h2>Tạo báo cáo sự cố</h2>

<form action="?act=incident" method="POST">

    <!-- Hiển thị tên HDV đang đăng nhập -->
    <label>Hướng dẫn viên:</label>
    <input 
        type="text" 
        value="<?= $_SESSION['user']['fullname'] ?>" 
        class="form-control"
        disabled
    >
    <input type="hidden" name="guide_id" value="<?= $_SESSION['user']['id'] ?>">
    <br><br>

    <!-- Lựa chọn assignment của đúng HDV -->
   <label>Chọn Tour báo cáo:</label>
    <select name="assignment_id" required>
    <option value="">-- Chọn --</option>
    <?php foreach($assignments as $a): ?>
        <option value="<?= $a['id'] ?>">
        <?= $a['tour_name']?>
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

<style>
form {
    max-width: 650px;
    margin: 30px auto;
    padding: 30px 35px;
    background: #fefefe;
    border-radius: 16px;
    box-shadow: 0 10px 28px rgba(0,0,0,0.1);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    transition: all 0.3s ease;
}
form:hover {
    transform: translateY(-2px);
    box-shadow: 0 14px 36px rgba(0,0,0,0.15);
}
form h2 {
    color: #006978;
    margin-bottom: 25px;
    font-size: 1.9rem;
    text-align: center;
}
form label {
    display: block;
    font-weight: 600;
    margin-bottom: 8px;
    color: #333;
}
form input[type="date"],
form select,
form textarea {
    width: 100%;
    padding: 12px 14px;
    margin-bottom: 20px;
    border: 1.5px solid #ccc;
    border-radius: 12px;
    font-size: 1rem;
    transition: border-color 0.3s, box-shadow 0.3s;
}
form input[type="date"]:focus,
form select:focus,
form textarea:focus {
    border-color: #0097A7;
    box-shadow: 0 0 10px rgba(0,151,167,0.2);
    outline: none;
}
form textarea {
    min-height: 120px;
    resize: vertical;
}
form button {
    width: 100%;
    padding: 14px 0;
    font-size: 1.1rem;
    font-weight: 600;
    color: #fff;
    background: linear-gradient(135deg, #0097A7, #006978);
    border: none;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 6px 20px rgba(0,151,167,0.25);
}
form button:hover {
    background: linear-gradient(135deg, #00bcd4, #006978);
    transform: translateY(-2px) scale(1.03);
    box-shadow: 0 8px 28px rgba(0,151,167,0.35);
}
form select option {
    padding: 5px 10px;
}
@media (max-width: 640px) {
    form { padding: 20px 15px; }
}

/* Bảng */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 25px;
    background: #fff;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    box-shadow: 0 6px 18px rgba(0,0,0,0.1);
    border-radius: 10px;
    overflow: hidden;
}
table thead th {
    background-color: #006978;
    color: #fff;
    padding: 12px 10px;
}
table tbody td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
}
table tbody tr:nth-child(even) {
    background-color: #f9f9f9;
}
table tbody tr:hover {
    background-color: #e0f7fa;
}
table a {
    color: #d9534f;
    font-weight: 600;
}
table a:hover {
    text-decoration: underline;
    color: #c9302c;
}
td.severity-low { color: #006400; font-weight: 600; }
td.severity-medium { color: #ff8c00; font-weight: 600; }
td.severity-high { color: #c00; font-weight: 600; }
</style>
