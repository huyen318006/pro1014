<h2>Tạo báo cáo sự cố</h2>
<form action="?act=incident" method="POST">
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
<style>
  /* ===== Form container ===== */
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

/* Hover form nâng lên nhẹ */
form:hover {
    transform: translateY(-2px);
    box-shadow: 0 14px 36px rgba(0,0,0,0.15);
}

/* Tiêu đề */
form h2 {
    color: #006978;
    margin-bottom: 25px;
    font-size: 1.9rem;
    text-align: center;
}

/* Label */
form label {
    display: block;
    font-weight: 600;
    margin-bottom: 8px;
    color: #333;
}

/* Input, select, textarea */
form input[type="date"],
form select,
form textarea {
    width: 100%;
    padding: 12px 14px;
    margin-bottom: 20px;
    border: 1.5px solid #ccc;
    border-radius: 12px;
    font-size: 1rem;
    box-sizing: border-box;
    transition: border-color 0.3s, box-shadow 0.3s;
}

/* Focus input/select/textarea */
form input[type="date"]:focus,
form select:focus,
form textarea:focus {
    border-color: #0097A7;
    box-shadow: 0 0 10px rgba(0,151,167,0.2);
    outline: none;
}

/* Textarea cao hơn */
form textarea {
    min-height: 120px;
    resize: vertical;
}

/* Button gửi báo cáo */
form button {
    display: block;
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

/* Hover button */
form button:hover {
    background: linear-gradient(135deg, #00bcd4, #006978);
    transform: translateY(-2px) scale(1.03);
    box-shadow: 0 8px 28px rgba(0,151,167,0.35);
}

/* Option select đẹp hơn */
form select option {
    padding: 5px 10px;
}

/* Responsive */
@media (max-width: 640px) {
    form {
        padding: 20px 15px;
    }
}

/* ===== Bảng danh sách báo cáo ===== */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 25px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #fff;
    box-shadow: 0 6px 18px rgba(0,0,0,0.1);
    border-radius: 10px;
    overflow: hidden;
}

/* Header bảng */
table thead th {
    background-color: #006978;
    color: #fff;
    font-weight: 600;
    padding: 12px 10px;
    text-align: left;
}

/* Dòng dữ liệu */
table tbody td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
    vertical-align: top;
}

/* Xen kẽ màu dòng chẵn */
table tbody tr:nth-child(even) {
    background-color: #f9f9f9;
}

/* Hover dòng */
table tbody tr:hover {
    background-color: #e0f7fa;
}

/* Link xóa */
table a {
    color: #d9534f;
    text-decoration: none;
    font-weight: 600;
}

table a:hover {
    text-decoration: underline;
    color: #c9302c;
}

/* Severity trực quan */
td.severity-low {
    color: #006400; /* xanh lá nhạt */
    font-weight: 600;
}
td.severity-medium {
    color: #ff8c00; /* vàng cam */
    font-weight: 600;
}
td.severity-high {
    color: #c00; /* đỏ */
    font-weight: 600;
}

</style>