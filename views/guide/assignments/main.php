<h2>Phân công của bạn</h2>

<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>Tour</th>
        <th>Ngày khởi hành</th>
        <th>Thời gian phân công</th>
    </tr>
    <?php if (!empty($assignList)): ?>
        <?php foreach ($assignList as $a): ?>
            <tr>
                <td><?= htmlspecialchars($a['tour_name'] ?? $a['tour_id']) ?></td>
                <td><?= htmlspecialchars($a['departure_date'] ?? '') ?></td>
                <td><?= htmlspecialchars($a['assigned_at'] ?? '') ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="3" style="text-align: center;">Bạn chưa có phân công nào.</td>
        </tr>
    <?php endif; ?>
</table>