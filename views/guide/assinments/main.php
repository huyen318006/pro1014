<h2>Phân công của bạn</h2>

<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>Tour</th>
        <th>Ngày khởi hành</th>
        <th>Thời gian phân công</th>
    </tr>
    <?php foreach ($assignList as $a): ?>
        <tr>
            <td><?= $a['tour_id'] ?></td>
            <td><?= $a['departure_date'] ?></td>
            <td><?= $a['assigned_at'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>