<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Lịch Trình Tour | LOFT CITY</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <!-- CSS Guide -->
    <link rel="stylesheet" href="<?= BASE_URL ?>asset/css/guide.css">
</head>

<body>
    <!-- SIDEBAR -->
    <div class="sidebar">
        <div class="logo"><i class="fas fa-hiking"></i></div>
        <h4>HƯỚNG DẪN VIÊN</h4>
        <a href="<?= BASE_URL . '?act=guideDashboard' ?>"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a>
        <a href="<?= BASE_URL . '?act=guideDepartures' ?>"><i class="fas fa-calendar-alt"></i> <span>Lịch khởi hành</span></a>
        <a href="<?= BASE_URL . '?act=MyTour' ?>"><i class="fas fa-map-marked-alt"></i> <span>Tour được giao</span></a>
        <a href="<?= BASE_URL . '?act=guideJournals' ?>"><i class="fas fa-book"></i> <span>Nhật ký tour</span></a>
        <a href="<?= BASE_URL . '?act=incident' ?>"><i class="fas fa-exclamation-triangle"></i> <span>Báo cáo sự cố</span></a>
        <a href="<?= BASE_URL . '?act=logout' ?>"><i class="fas fa-sign-out-alt"></i> <span>Đăng xuất</span></a>
    </div>

    <!-- HEADER -->
    <div class="header">
        <h5><i class="fas fa-route"></i> Lịch Trình Tour</h5>
        <div class="user-info">
            <i class="fas fa-user-circle"></i>
            <span><?= $_SESSION['user']['fullname'] ?? '' ?></span>
        </div>
    </div>

    <!-- CONTENT -->
    <div class="content">
        <!-- Back Button -->
        <div class="mb-3">
            <a href="<?= BASE_URL . '?act=MyTour' ?>" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>

        <!-- Tour Info & Progress -->
        <div class="card-header mb-4">
            <h4 class="mb-3"><i class="fas fa-map-marked-alt"></i> <?= htmlspecialchars($departureInfo['tour_name'] ?? 'Tour') ?></h4>
            <div class="mb-3">
                <span class="badge bg-light text-dark me-2">
                    <i class="fas fa-calendar"></i>
                    Khởi hành: <?= date('d/m/Y', strtotime($departureInfo['departure_date'])) ?>
                </span>
                <span class="badge bg-light text-dark me-2">
                    <i class="fas fa-map-pin"></i>
                    <?= htmlspecialchars($departureInfo['meeting_point'] ?? 'N/A') ?>
                </span>
                <?php if ($currentDayNumber > 0 && isset($itineraries[0]['tour_duration'])): ?>
                    <span class="badge bg-warning text-dark">
                        <i class="fas fa-calendar-day"></i>
                        Ngày <?= $currentDayNumber ?>/<?= $itineraries[0]['tour_duration'] ?>
                    </span>
                <?php endif; ?>
            </div>
            <div>
                <div class="d-flex justify-content-between mb-2">
                    <span><i class="fas fa-tasks"></i> Tiến độ hoàn thành</span>
                    <span><strong id="progress-count"><?= $completedCheckpoints ?>/<?= $totalCheckpoints ?></strong> hoạt động</span>
                </div>
                <div class="progress" style="height: 25px;">
                    <div class="progress-bar bg-success" id="main-progress-bar" role="progressbar" style="width: <?= $progressPercent ?>%;"
                        aria-valuenow="<?= $progressPercent ?>" aria-valuemin="0" aria-valuemax="100">
                        <?= $progressPercent ?>%
                    </div>
                </div>
            </div>
        </div>

        <!-- Itinerary List -->
        <?php if (!empty($itineraries)): ?>
            <div class="row">
                <?php foreach ($itineraries as $index => $itinerary):
                    $dayNumber = $itinerary['day_number'];
                    $isCurrent = ($dayNumber == $currentDayNumber);

                    // Parse activities
                    $activities = array_filter(array_map('trim', explode("\n", $itinerary['activities'] ?? '')));

                    // Count checked activities for this day
                    $checkedCount = 0;
                    $activityCheckpoints = $itinerary['activity_checkpoints'] ?? [];
                    foreach ($activityCheckpoints as $idx => $checkpoint) {
                        if ($idx > 0) $checkedCount++; // Skip index 0 (whole day)
                    }

                    $isCompleted = ($checkedCount == count($activities) && count($activities) > 0);
                    $cardClass = 'border-start border-2 ';
                    $cardClass .= $isCompleted ? 'border-success' : ($isCurrent ? 'border-warning' : 'border-secondary');
                    $badgeClass = $isCompleted ? 'bg-success' : ($isCurrent ? 'bg-warning text-dark' : 'bg-secondary');
                ?>
                    <div class="col-12 mb-3">
                        <div class="card <?= $cardClass ?> shadow-sm" data-day="<?= $dayNumber ?>">
                            <div class="card-body">
                                <!-- Day Header -->
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <span class="badge <?= $badgeClass ?> mb-2">
                                            <?php if ($isCurrent): ?>
                                                <i class="fas fa-star"></i> Hôm nay - Ngày <?= $dayNumber ?>
                                            <?php else: ?>
                                                Ngày <?= $dayNumber ?>
                                            <?php endif; ?>
                                        </span>
                                        <h5 class="card-title"><?= htmlspecialchars($itinerary['title']) ?></h5>
                                        <?php if (count($activities) > 0): ?>
                                            <small class="text-muted">
                                                <i class="fas fa-check-circle text-success"></i>
                                                <span class="day-progress"><?= $checkedCount ?>/<?= count($activities) ?></span> hoạt động hoàn thành
                                            </small>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- Activities with individual checkboxes -->
                                <?php if (!empty($activities)): ?>
                                    <div class="mb-3">
                                        <h6 class="text-muted"><i class="fas fa-list-ul"></i> Hoạt động:</h6>
                                        <div class="list-group list-group-flush">
                                            <?php foreach ($activities as $activityIndex => $activity):
                                                $realIndex = $activityIndex + 1; // Start from 1, 0 is reserved for whole day
                                                $isChecked = isset($activityCheckpoints[$realIndex]);
                                                $checkedAt = $isChecked ? $activityCheckpoints[$realIndex]['checked_at'] : null;
                                            ?>
                                                <div class="list-group-item px-0 py-2 border-0">
                                                    <div class="form-check d-flex align-items-start">
                                                        <input class="form-check-input me-3 mt-1 activity-checkbox"
                                                            type="checkbox"
                                                            id="activity_<?= $itinerary['id'] ?>_<?= $realIndex ?>"
                                                            data-itinerary-id="<?= $itinerary['id'] ?>"
                                                            data-departure-id="<?= $departure_id ?>"
                                                            data-activity-index="<?= $realIndex ?>"
                                                            <?= $isChecked ? 'checked' : '' ?>
                                                            style="width: 1.25rem; height: 1.25rem; cursor: pointer;">
                                                        <label class="form-check-label flex-grow-1" for="activity_<?= $itinerary['id'] ?>_<?= $realIndex ?>" style="cursor: pointer;">
                                                            <span class="<?= $isChecked ? 'text-decoration-line-through text-muted' : '' ?>">
                                                                <i class="fas fa-chevron-right text-primary me-2"></i><?= htmlspecialchars($activity) ?>
                                                            </span>
                                                            <?php if ($isChecked && $checkedAt): ?>
                                                                <br><small class="text-success">
                                                                    <i class="fas fa-check-circle"></i>
                                                                    Hoàn thành: <?= date('d/m/Y H:i', strtotime($checkedAt)) ?>
                                                                </small>
                                                            <?php endif; ?>
                                                        </label>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <!-- Notes -->
                                <?php if (!empty($itinerary['notes'])): ?>
                                    <div class="alert alert-info mb-0">
                                        <i class="fas fa-info-circle"></i> <strong>Ghi chú:</strong>
                                        <p class="mb-0 mt-1"><?= nl2br(htmlspecialchars($itinerary['notes'])) ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle"></i> Chưa có lịch trình cho tour này.
            </div>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Checkpoint AJAX Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.activity-checkbox');

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const itineraryId = this.dataset.itineraryId;
                    const departureId = this.dataset.departureId;
                    const activityIndex = parseInt(this.dataset.activityIndex);
                    const isChecked = this.checked;
                    const checkboxElement = this;
                    const label = checkboxElement.nextElementSibling;

                    checkboxElement.disabled = true;

                    const data = {
                        departure_id: parseInt(departureId),
                        itinerary_id: parseInt(itineraryId),
                        activity_index: activityIndex,
                        action: isChecked ? 'check' : 'uncheck'
                    };

                    fetch('<?= BASE_URL ?>?act=updateCheckpoint', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(data)
                        })
                        .then(response => response.json())
                        .then(result => {
                            if (result.success) {
                                const textSpan = label.querySelector('span');

                                if (isChecked) {
                                    textSpan.classList.add('text-decoration-line-through', 'text-muted');

                                    if (result.checked_at) {
                                        const timeText = document.createElement('br');
                                        const timeSmall = document.createElement('small');
                                        timeSmall.className = 'text-success';
                                        timeSmall.innerHTML = `<i class="fas fa-check-circle"></i> Hoàn thành: ${formatDateTime(result.checked_at)}`;
                                        label.appendChild(timeText);
                                        label.appendChild(timeSmall);
                                    }

                                    showAlert('Đã đánh dấu hoàn thành!', 'success');
                                } else {
                                    textSpan.classList.remove('text-decoration-line-through', 'text-muted');

                                    const existingTime = label.querySelectorAll('br, small');
                                    existingTime.forEach(el => el.remove());

                                    showAlert('Đã bỏ đánh dấu!', 'info');
                                }

                                updateDayProgress(checkboxElement.closest('.card'));
                                updateGlobalProgress();
                            } else {
                                checkboxElement.checked = !isChecked;
                                showAlert(result.message || 'Có lỗi xảy ra!', 'danger');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            checkboxElement.checked = !isChecked;
                            showAlert('Không thể kết nối đến server!', 'danger');
                        })
                        .finally(() => {
                            checkboxElement.disabled = false;
                        });
                });
            });

            function updateDayProgress(card) {
                const dayCheckboxes = card.querySelectorAll('.activity-checkbox');
                const checked = card.querySelectorAll('.activity-checkbox:checked').length;
                const total = dayCheckboxes.length;

                const progressSpan = card.querySelector('.day-progress');
                if (progressSpan) {
                    progressSpan.textContent = `${checked}/${total}`;
                }

                // Update card border
                card.classList.remove('border-success', 'border-warning', 'border-secondary');
                if (checked === total && total > 0) {
                    card.classList.add('border-success');
                    const badge = card.querySelector('.badge');
                    if (badge) {
                        badge.classList.remove('bg-warning', 'bg-secondary', 'text-dark');
                        badge.classList.add('bg-success');
                    }
                } else {
                    const isCurrent = card.dataset.day == '<?= $currentDayNumber ?>';
                    card.classList.add(isCurrent ? 'border-warning' : 'border-secondary');
                }
            }

            function updateGlobalProgress() {
                const total = checkboxes.length;
                const checked = document.querySelectorAll('.activity-checkbox:checked').length;
                const percent = total > 0 ? Math.round((checked / total) * 100) : 0;

                const progressBar = document.getElementById('main-progress-bar');
                if (progressBar) {
                    progressBar.style.width = percent + '%';
                    progressBar.setAttribute('aria-valuenow', percent);
                    progressBar.textContent = percent + '%';
                }

                const progressCount = document.getElementById('progress-count');
                if (progressCount) {
                    progressCount.textContent = checked + '/' + total;
                }
            }

            function formatDateTime(datetime) {
                const date = new Date(datetime);
                const day = String(date.getDate()).padStart(2, '0');
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const year = date.getFullYear();
                const hours = String(date.getHours()).padStart(2, '0');
                const minutes = String(date.getMinutes()).padStart(2, '0');
                return `${day}/${month}/${year} ${hours}:${minutes}`;
            }

            function showAlert(message, type) {
                const alertDiv = document.createElement('div');
                alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3`;
                alertDiv.style.zIndex = '9999';
                alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
                document.body.appendChild(alertDiv);

                setTimeout(() => {
                    alertDiv.remove();
                }, 3000);
            }
        });
    </script>
</body>

</html>