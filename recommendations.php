<?php
require_once 'config.php';
require_once 'functions.php';

// Get form data
$mood = isset($_POST['mood']) ? $_POST['mood'] : '';
$energy_level = isset($_POST['energy_level']) ? intval($_POST['energy_level']) : 3;
$platform = isset($_POST['platform']) ? $_POST['platform'] : 'all';

// Validate inputs
if (empty($mood)) {
    header('Location: index.php');
    exit();
}

$conn = getDBConnection();

// Rule-based filtering
// Match films based on mood and energy level (with tolerance)
$energy_min = max(1, $energy_level - 1);
$energy_max = min(5, $energy_level + 1);

$query = "SELECT * FROM films WHERE mood = ? AND energy_level BETWEEN ? AND ?";
$params = [$mood, $energy_min, $energy_max];
$types = "sii";

// Filter by platform if not "all"
if ($platform !== 'all') {
    $query .= " AND platform = ?";
    $params[] = $platform;
    $types .= "s";
}

$query .= " ORDER BY ABS(energy_level - ?) ASC, RAND() LIMIT 12";
$params[] = $energy_level;
$types .= "i";

$stmt = $conn->prepare($query);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
$films = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$conn->close();

// Mood labels
$moodLabels = [
    'energi' => 'Energi',
    'tenang' => 'Tenang',
    'galau' => 'Galau',
    'bahagia' => 'Bahagia',
    'romantis' => 'Romantis',
    'semangat' => 'Semangat'
];

// Platform labels
$platformLabels = [
    'netflix' => 'Netflix',
    'primevideo' => 'Prime Video',
    'vidio' => 'Vidio',
    'disney' => 'Disney+',
    'hbo' => 'HBO Max'
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekomendasi Film - Mood-Based Recommendation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/modern-layout.css">
</head>
<body>
    <!-- Decorative Animated Elements -->
    <div class="decorative-left">
        <div class="floating-element element-1"></div>
        <div class="floating-element element-2"></div>
        <div class="floating-element element-3"></div>
    </div>
    <div class="decorative-right">
        <div class="floating-element element-4"></div>
        <div class="floating-element element-5"></div>
        <div class="floating-element element-6"></div>
    </div>

    <div class="results-header">
        <div class="container py-4">
            <a href="index.php" class="back-btn">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            <div class="results-title-section">
                <h1 class="results-title">
                    <i class="bi bi-stars"></i> Rekomendasi Film
                </h1>
                <p class="results-subtitle">Film yang cocok dengan mood dan preferensi Anda</p>
            </div>
            <div class="filter-badges">
                <div class="filter-badge badge-mood">
                    <i class="bi bi-emoji-smile"></i>
                    <span class="badge-label">Mood</span>
                    <span class="badge-value"><?php echo htmlspecialchars($moodLabels[$mood]); ?></span>
                </div>
                <div class="filter-badge badge-energy">
                    <i class="bi bi-speedometer2"></i>
                    <span class="badge-label">Energi</span>
                    <span class="badge-value"><?php echo $energy_level; ?>/5</span>
                </div>
                <div class="filter-badge badge-platform">
                    <i class="bi bi-tv"></i>
                    <span class="badge-label">Platform</span>
                    <span class="badge-value"><?php echo $platform === 'all' ? 'Semua' : htmlspecialchars($platformLabels[$platform] ?? $platform); ?></span>
                </div>
                <div class="filter-badge badge-count">
                    <i class="bi bi-collection"></i>
                    <span class="badge-value"><?php echo count($films); ?> Film</span>
                </div>
            </div>
        </div>
    </div>

    <div class="container py-4">

        <?php if (count($films) > 0): ?>
            <div class="films-grid">
                <?php foreach ($films as $film): ?>
                    <div class="film-item">
                        <div class="film-card-new">
                            <div class="film-poster">
                                <?php 
                                $thumbnailUrl = getThumbnailUrl($film['thumbnail'], $film['title']);
                                if (strpos($thumbnailUrl, 'placeholder') !== false) {
                                    $thumbnailUrl = generateMoodThumbnail($film['title'], $film['mood']);
                                }
                                ?>
                                <img src="<?php echo htmlspecialchars($thumbnailUrl); ?>" 
                                     alt="<?php echo htmlspecialchars($film['title']); ?>"
                                     loading="lazy"
                                     onerror="this.src='<?php echo generateMoodThumbnail($film['title'], $film['mood']); ?>'">
                                <div class="film-overlay">
                                    <div class="film-energy">
                                        <i class="bi bi-star-fill"></i> <?php echo $film['energy_level']; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="film-info">
                                <h3 class="film-title"><?php echo htmlspecialchars($film['title']); ?></h3>
                                <p class="film-description">
                                    <?php echo htmlspecialchars($film['description'] ?? 'Film menarik untuk ditonton'); ?>
                                </p>
                                <div class="film-meta">
                                    <span class="film-genre">
                                        <i class="bi bi-tag"></i> <?php echo htmlspecialchars($film['genre'] ?? 'Drama'); ?>
                                    </span>
                                    <?php if ($film['year']): ?>
                                        <span class="film-year">
                                            <i class="bi bi-calendar"></i> <?php echo $film['year']; ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <div class="film-actions">
                                    <a href="<?php echo htmlspecialchars($film['platform_url']); ?>" 
                                       target="_blank" 
                                       class="btn-watch"
                                       title="Buka <?php echo htmlspecialchars($platformLabels[$film['platform']] ?? $film['platform']); ?>">
                                        <i class="bi bi-play-circle"></i>
                                        <span>Cari di <?php echo htmlspecialchars($platformLabels[$film['platform']] ?? $film['platform']); ?></span>
                                    </a>
                                    <button class="btn-share share-btn" 
                                            data-title="<?php echo htmlspecialchars($film['title']); ?>"
                                            data-url="<?php echo htmlspecialchars($film['platform_url']); ?>">
                                        <i class="bi bi-share"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="no-results">
                <div class="no-results-content">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <h3>Maaf, tidak ada film yang ditemukan</h3>
                    <p>Silakan coba dengan kombinasi mood, energi, atau platform yang berbeda.</p>
                    <a href="index.php" class="btn-back">
                        <i class="bi bi-arrow-left me-2"></i> Coba Lagi
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Toast Notification -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="toastNotification" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <i class="bi bi-check-circle-fill text-success me-2"></i>
                <strong class="me-auto">Berhasil</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body" id="toastMessage">
                Link film berhasil disalin!
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>

