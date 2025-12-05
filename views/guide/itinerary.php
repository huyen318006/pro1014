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
    <style>
        /* ===== ITINERARY STYLES ===== */
        .progress-card {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 8px 20px rgba(0, 151, 167, 0.3);
        }

        .progress-card .progress {
            height: 25px;
            border-radius: 12px;
            background-color: rgba(255, 255, 255, 0.2);
        }

        .progress-card .progress-bar {
            background: linear-gradient(90deg, #56ab2f 0%, #a8e063 100%);
            font-weight: 600;
            font-size: 0.9rem;
        }

        /* Timeline Styles */
        .itinerary-timeline {
            position: relative;
            padding-left: 2rem;
        }

        .itinerary-timeline::before {
            content: '';
            position: absolute;
            left: 20px;
            top: 0;
            bottom: 0;
            width: 3px;
            background: linear-gradient(180deg, #7cd7e1ff 0%, #dedfe0ff 100%);
        }

        .itinerary-item {
            position: relative;
            margin-bottom: 2rem;
            padding-left: 2rem;
        }

        .itinerary-item::before {
            content: '';
            position: absolute;
            left: -2rem;
            top: 10px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: white;
            border: 4px solid #7cd7e1ff;
            box-shadow: 0 4px 12px rgba(124, 215, 225, 0.4);
            z-index: 2;
        }

        .itinerary-item.current::before {
            background: linear-gradient(135deg, #f7b456ff 0%, #f39c12 100%);
            border-color: #f7b456ff;
            animation: pulse 2s infinite;
        }

        .itinerary-item.completed::before {
            background: linear-gradient(135deg, #56ab2f 0%, #a8e063 100%);
            border-color: #56ab2f;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
                box-shadow: 0 4px 12px rgba(247, 180, 86, 0.4);
            }

            50% {
                transform: scale(1.1);
                box-shadow: 0 6px 20px rgba(247, 180, 86, 0.6);
            }
        }

        .itinerary-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .itinerary-card:hover {
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            transform: translateY(-2px);
        }

        .itinerary-card.current {
            border: 2px solid #f7b456ff;
            background: linear-gradient(135deg, #fff9f0 0%, #ffffff 100%);
        }

        .itinerary-card.completed {
            border-left: 4px solid #56ab2f;
        }

        .day-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 700;
            font-size: 0.85rem;
            margin-bottom: 0.5rem;
        }

        .day-badge.current {
            background: linear-gradient(135deg, #f7b456ff 0%, #f39c12 100%);
            color: white;
        }

        .day-badge.completed {
            background: linear-gradient(135deg, #56ab2f 0%, #a8e063 100%);
            color: white;
        }

        .day-badge.upcoming {
            background: #dedfe0ff;
            color: #666;
        }

        /* Checkbox Styles */
        .checkpoint-checkbox {
            width: 24px;
            height: 24px;
            cursor: pointer;
            accent-color: #56ab2f;
        }

        .checkpoint-checkbox:disabled {
            cursor: not-allowed;
            opacity: 0.5;
        }

        .checkpoint-label {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem;
            border-radius: 8px;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .checkpoint-label:hover {
            background-color: #f8f9fa;
        }

        .checkpoint-label.checked {
            background-color: #f0f9f4;
        }

        .checkpoint-label.checked .checkpoint-text {
            text-decoration: line-through;
            color: #6c757d;
        }

        .checkpoint-time {
            font-size: 0.8rem;
            color: #28a745;
            font-weight: 600;
            margin-left: auto;
        }

        .activities-list {
            list-style: none;
            padding-left: 0;
        }

        .activities-list li {
            padding: 0.5rem 0;
            padding-left: 1.5rem;
            position: relative;
        }

        .activities-list li::before {
            content: '▸';
            position: absolute;
            left: 0;
            color: #7cd7e1ff;
            font-weight: bold;
        }

        /* Loading Spinner */
        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
            border-width: 0.15em;
        }

        /* Toast Notification */
        .toast-container {
            position: fixed;
            top: 80px;
            right: 20px;
            z-index: 9999;
        }

        .tour-info-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            margin-right: 1rem;
        }
    </style>
</head>

<body>
    <!-- SIDEBAR -->
    <div class="sidebar">
        <div class="logo"><i class="fas fa-hiking"></i></div>
        <h4>HƯỚNG DẪN VIÊN</h4>
        <a href="<?= BASE_URL . '?act=guideDashboard' ?>"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a>
        <a href="<?= BASE_URL . '?act=guideDepartures' ?>"><i class="fas fa-calendar-alt"></i> <span>Lịch khởi hành</span></a>
        <a href="<?= BASE_URL . '?act=MyTour' ?>"><i class="fas fa-map-marked-alt"></i> <span>Tour được giao</span></a>
        <a href="guideDiary.php"><i class="fas fa-book"></i> <span>Nhật ký tour</span></a>
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
        <div class="progress-card">
            <h4 class="mb-3"><i class="fas fa-map-marked-alt"></i> <?= htmlspecialchars($departureInfo['tour_name'] ?? 'Tour') ?></h4>
            <div class="mb-3">
                <span class="tour-info-badge">
                    <i class="fas fa-calendar"></i>
                    <span>Khởi hành: <?= date('d/m/Y', strtotime($departureInfo['departure_date'])) ?></span>
                </span>
                <span class="tour-info-badge">
                    <i class="fas fa-map-pin"></i>
                    <span><?= htmlspecialchars($departureInfo['meeting_point'] ?? 'N/A') ?></span>
                </span>
                <?php if ($currentDayNumber > 0 && isset($itineraries[0]['tour_duration'])): ?>
                    <span class="tour-info-badge">
                        <i class="fas fa-calendar-day"></i>
                        <span>Ngày <?= $currentDayNumber ?>/<?= $itineraries[0]['tour_duration'] ?></span>
                    </span>
                <?php endif; ?>
            </div>
            <div>
                <div class="d-flex justify-content-between mb-2">
                    <span><i class="fas fa-tasks"></i> Tiến độ hoàn thành</span>
                    <span><strong><?= $completedCheckpoints ?>/<?= $totalCheckpoints ?></strong> checkpoint</span>
                </div>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: <?= $progressPercent ?>%;"
                        aria-valuenow="<?= $progressPercent ?>" aria-valuemin="0" aria-valuemax="100">
                        <?= $progressPercent ?>%
                    </div>
                </div>
            </div>
        </div>

        <!-- Itinerary Timeline -->
        <?php if (!empty($itineraries)): ?>
            <div class="itinerary-timeline">
                <?php foreach ($itineraries as $index => $itinerary):
                    $dayNumber = $itinerary['day_number'];
                    $isCurrent = ($dayNumber == $currentDayNumber);
                    $isCompleted = !empty($itinerary['is_checked']);
                    $isUpcoming = ($dayNumber > $currentDayNumber);
                    $itemClass = $isCompleted ? 'completed' : ($isCurrent ? 'current' : '');
                ?>
                    <div class="itinerary-item <?= $itemClass ?>" data-day="<?= $dayNumber ?>">
                        <div class="itinerary-card <?= $itemClass ?>">
                            <!-- Day Header -->
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <span class="day-badge <?= $isCompleted ? 'completed' : ($isCurrent ? 'current' : 'upcoming') ?>">
                                        <?php if ($isCurrent): ?>
                                            <i class="fas fa-star"></i> Hôm nay
                                        <?php else: ?>
                                            Ngày <?= $dayNumber ?>
                                        <?php endif; ?>
                                    </span>
                                    <h5 class="mt-2 mb-0"><?= htmlspecialchars($itinerary['title']) ?></h5>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input checkpoint-checkbox"
                                        type="checkbox"
                                        id="checkpoint_<?= $itinerary['id'] ?>"
                                        data-itinerary-id="<?= $itinerary['id'] ?>"
                                        data-departure-id="<?= $departure_id ?>"
                                        <?= $isCompleted ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="checkpoint_<?= $itinerary['id'] ?>">
                                        <small class="text-muted">Hoàn thành</small>
                                    </label>
                                </div>
                            </div>

                            <!-- Activities -->
                            <?php if (!empty($itinerary['activities'])): ?>
                                <div class="mb-3">
                                    <h6><i class="fas fa-list-ul"></i> Hoạt động:</h6>
                                    <ul class="activities-list">
                                        <?php
                                        $activities = explode("\n", $itinerary['activities']);
                                        foreach ($activities as $activity):
                                            $activity = trim($activity);
                                            if (!empty($activity)):
                                        ?>
                                                <li><?= htmlspecialchars($activity) ?></li>
                                        <?php
                                            endif;
                                        endforeach;
                                        ?>
                                    </ul>
                                </div>
                            <?php endif; ?>

                            <!-- Notes -->
                            <?php if (!empty($itinerary['notes'])): ?>
                                <div class="alert alert-info mb-0">
                                    <i class="fas fa-info-circle"></i> <strong>Ghi chú:</strong>
                                    <p class="mb-0 mt-1"><?= nl2br(htmlspecialchars($itinerary['notes'])) ?></p>
                                </div>
                            <?php endif; ?>

                            <!-- Checkpoint Time -->
                            <?php if ($isCompleted && !empty($itinerary['checked_at'])): ?>
                                <div class="mt-3 text-end">
                                    <small class="text-success">
                                        <i class="fas fa-check-circle"></i>
                                        Hoàn thành lúc: <?= date('d/m/Y H:i', strtotime($itinerary['checked_at'])) ?>
                                    </small>
                                </div>
                            <?php endif; ?>
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

    <!-- Toast Container -->
    <div class="toast-container"></div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Checkpoint AJAX Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.checkpoint-checkbox');

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const itineraryId = this.dataset.itineraryId;
                    const departureId = this.dataset.departureId;
                    const isChecked = this.checked;
                    const checkboxElement = this;

                    // Disable checkbox during request
                    checkboxElement.disabled = true;

                    // Prepare data
                    const data = {
                        departure_id: parseInt(departureId),
                        itinerary_id: parseInt(itineraryId),
                        action: isChecked ? 'check' : 'uncheck'
                    };

                    // Send AJAX request
                    fetch('<?= BASE_URL ?>?act=updateCheckpoint', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify(data)
                        })
                        .then(response => response.json())
                        .then(result => {
                            if (result.success) {
                                // Update UI
                                const itineraryItem = checkboxElement.closest('.itinerary-item');
                                const itineraryCard = checkboxElement.closest('.itinerary-card');

                                if (isChecked) {
                                    itineraryItem.classList.add('completed');
                                    itineraryCard.classList.add('completed');

                                    // Add timestamp if provided
                                    if (result.checked_at) {
                                        const timeDiv = document.createElement('div');
                                        timeDiv.className = 'mt-3 text-end checkpoint-time-display';
                                        timeDiv.innerHTML = `<small class="text-success"><i class="fas fa-check-circle"></i> Hoàn thành lúc: ${formatDateTime(result.checked_at)}</small>`;

                                        // Remove old timestamp if exists
                                        const oldTime = itineraryCard.querySelector('.checkpoint-time-display');
                                        if (oldTime) oldTime.remove();

                                        itineraryCard.appendChild(timeDiv);
                                    }

                                    showToast('Đã đánh dấu hoàn thành!', 'success');
                                } else {
                                    itineraryItem.classList.remove('completed');
                                    itineraryCard.classList.remove('completed');

                                    // Remove timestamp
                                    const timeDisplay = itineraryCard.querySelector('.checkpoint-time-display');
                                    if (timeDisplay) timeDisplay.remove();

                                    showToast('Đã bỏ đánh dấu!', 'info');
                                }

                                // Update progress bar
                                updateProgress();
                            } else {
                                // Revert checkbox on error
                                checkboxElement.checked = !isChecked;
                                showToast(result.message || 'Có lỗi xảy ra!', 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            checkboxElement.checked = !isChecked;
                            showToast('Không thể kết nối đến server!', 'error');
                        })
                        .finally(() => {
                            checkboxElement.disabled = false;
                        });
                });
            });

            function updateProgress() {
                const total = checkboxes.length;
                const checked = document.querySelectorAll('.checkpoint-checkbox:checked').length;
                const percent = total > 0 ? Math.round((checked / total) * 100) : 0;

                const progressBar = document.querySelector('.progress-bar');
                if (progressBar) {
                    progressBar.style.width = percent + '%';
                    progressBar.setAttribute('aria-valuenow', percent);
                    progressBar.textContent = percent + '%';
                }

                const checkpointCount = document.querySelector('.progress-card strong');
                if (checkpointCount) {
                    checkpointCount.textContent = checked + '/' + total;
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

            function showToast(message, type = 'info') {
                const toastContainer = document.querySelector('.toast-container');
                const toastId = 'toast_' + Date.now();

                const bgClass = type === 'success' ? 'bg-success' : (type === 'error' ? 'bg-danger' : 'bg-info');

                const toastHTML = `
            <div id="${toastId}" class="toast align-items-center text-white ${bgClass} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        `;

                toastContainer.insertAdjacentHTML('beforeend', toastHTML);

                const toastElement = document.getElementById(toastId);
                const toast = new bootstrap.Toast(toastElement, {
                    delay: 3000
                });
                toast.show();

                toastElement.addEventListener('hidden.bs.toast', function() {
                    toastElement.remove();
                });
            }
        });
    </script>
</body>

</html>