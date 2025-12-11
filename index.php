<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mood-Based Film Recommendation</title>
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

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="hero-content">
                        <h1 class="hero-title mb-4">
                            <span class="hero-icon"><i class="bi bi-film"></i></span>
                            <span class="hero-text">Temukan Film<br>Sesuai Mood Anda</span>
                        </h1>
                        <p class="hero-subtitle lead mb-4">
                            Sistem rekomendasi film pintar yang memahami perasaan Anda. 
                            Pilih mood, atur energi, dan dapatkan rekomendasi film yang sempurna!
                        </p>
                        <div class="hero-features">
                            <div class="feature-item">
                                <i class="bi bi-check-circle-fill"></i>
                                <span>60+ Film Pilihan</span>
                            </div>
                            <div class="feature-item">
                                <i class="bi bi-check-circle-fill"></i>
                                <span>6 Kategori Mood</span>
                            </div>
                            <div class="feature-item">
                                <i class="bi bi-check-circle-fill"></i>
                                <span>Multi Platform</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="questionnaire-card">
                        <div class="card-header-custom">
                            <h3 class="mb-0">
                                <i class="bi bi-clipboard-data me-2"></i> Kuesioner Mood
                            </h3>
                        </div>
                        <div class="card-body-custom">
                            <form id="moodForm" method="POST" action="recommendations.php">
                                <!-- Mood Selection -->
                                <div class="section-mood mb-4">
                                    <label class="section-label">
                                        <i class="bi bi-emoji-smile me-2"></i> Pilih Mood Anda
                                    </label>
                                    <div class="mood-grid">
                                        <input type="radio" class="btn-check" name="mood" id="mood-energi" value="energi" required>
                                        <label class="mood-card mood-energi" for="mood-energi">
                                            <div class="mood-icon"><i class="bi bi-battery-charging"></i></div>
                                            <div class="mood-text">Energi</div>
                                        </label>
                                        
                                        <input type="radio" class="btn-check" name="mood" id="mood-tenang" value="tenang" required>
                                        <label class="mood-card mood-tenang" for="mood-tenang">
                                            <div class="mood-icon"><i class="bi bi-water"></i></div>
                                            <div class="mood-text">Tenang</div>
                                        </label>
                                        
                                        <input type="radio" class="btn-check" name="mood" id="mood-galau" value="galau" required>
                                        <label class="mood-card mood-galau" for="mood-galau">
                                            <div class="mood-icon"><i class="bi bi-moon-stars-fill"></i></div>
                                            <div class="mood-text">Galau</div>
                                        </label>
                                        
                                        <input type="radio" class="btn-check" name="mood" id="mood-bahagia" value="bahagia" required>
                                        <label class="mood-card mood-bahagia" for="mood-bahagia">
                                            <div class="mood-icon"><i class="bi bi-sun-fill"></i></div>
                                            <div class="mood-text">Bahagia</div>
                                        </label>
                                        
                                        <input type="radio" class="btn-check" name="mood" id="mood-romantis" value="romantis" required>
                                        <label class="mood-card mood-romantis" for="mood-romantis">
                                            <div class="mood-icon"><i class="bi bi-heart-pulse-fill"></i></div>
                                            <div class="mood-text">Romantis</div>
                                        </label>
                                        
                                        <input type="radio" class="btn-check" name="mood" id="mood-semangat" value="semangat" required>
                                        <label class="mood-card mood-semangat" for="mood-semangat">
                                            <div class="mood-icon"><i class="bi bi-rocket-takeoff-fill"></i></div>
                                            <div class="mood-text">Semangat</div>
                                        </label>
                                    </div>
                                </div>

                                <!-- Energy Level -->
                                <div class="section-energy mb-4">
                                    <label class="section-label">
                                        <i class="bi bi-speedometer2 me-2"></i> Tingkat Energi
                                    </label>
                                    <div class="energy-container">
                                        <div class="energy-display">
                                            <span class="energy-value" id="energyValue">3</span>
                                            <span class="energy-max">/ 5</span>
                                        </div>
                                        <input type="range" class="energy-slider" id="energyLevel" name="energy_level" min="1" max="5" value="3" required>
                                        <div class="energy-labels">
                                            <span>Rendah</span>
                                            <span>Tinggi</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Platform Selection -->
                                <div class="section-platform mb-4">
                                    <label class="section-label">
                                        <i class="bi bi-tv me-2"></i> Platform Preferensi
                                    </label>
                                    <select class="platform-select" name="platform" required>
                                        <option value="">Pilih Platform...</option>
                                        <option value="netflix">🎬 Netflix</option>
                                        <option value="primevideo">📺 Prime Video</option>
                                        <option value="vidio">🎥 Vidio</option>
                                        <option value="disney">🏰 Disney+</option>
                                        <option value="hbo">📡 HBO Max</option>
                                        <option value="all">🌐 Semua Platform</option>
                                    </select>
                                </div>

                                <button type="submit" class="submit-btn">
                                    <span class="btn-text">
                                        <i class="bi bi-search me-2"></i> Dapatkan Rekomendasi
                                    </span>
                                    <span class="btn-icon"><i class="bi bi-arrow-right"></i></span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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

