<?php
require_once 'config.php';
require_once 'functions.php';
requireAdmin();

$conn = getDBConnection();
$films = [];
$result = $conn->query("SELECT * FROM films ORDER BY id DESC");
if ($result) {
    $films = $result->fetch_all(MYSQLI_ASSOC);
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Mood-Based Film Recommendation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4 shadow-lg">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#" style="font-size: 1.3rem;">
                <i class="bi bi-film me-2"></i> Admin Dashboard
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="index.php">
                    <i class="bi bi-house"></i> Beranda
                </a>
                <a class="nav-link" href="admin_logout.php">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4 pt-3">
            <div class="bg-white p-3 rounded shadow-sm" style="border-left: 4px solid #0f4c75;">
                <h2 class="mb-2 fw-bold" style="font-size: 2.2rem; color: #0f4c75 !important; text-shadow: 0 1px 2px rgba(0,0,0,0.1);">
                    <i class="bi bi-collection me-2"></i> Manajemen Film
                </h2>
                <p class="mb-0 fw-medium" style="color: #495057; font-size: 1rem;">Kelola data film untuk sistem rekomendasi</p>
            </div>
            <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#filmModal" onclick="openAddModal()">
                <i class="bi bi-plus-circle me-2"></i> Tambah Film
            </button>
        </div>

        <div class="card shadow-sm border-0" style="border: 1px solid rgba(50, 130, 184, 0.1) !important;">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th>ID</th>
                                <th>Thumbnail</th>
                                <th>Judul</th>
                                <th>Mood</th>
                                <th>Energi</th>
                                <th>Platform</th>
                                <th>Genre</th>
                                <th>Tahun</th>
                                <th width="120">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($films) > 0): ?>
                                <?php foreach ($films as $film): ?>
                                    <tr class="align-middle">
                                        <td><?php echo $film['id']; ?></td>
                                        <td>
                                            <?php 
                                            $thumbUrl = getThumbnailUrl($film['thumbnail'], $film['title']);
                                            if (strpos($thumbUrl, 'placeholder') !== false) {
                                                $thumbUrl = generateMoodThumbnail($film['title'], $film['mood']);
                                            }
                                            ?>
                                            <img src="<?php echo htmlspecialchars($thumbUrl); ?>" 
                                                 alt="Thumbnail" 
                                                 class="img-thumbnail" 
                                                 style="width: 60px; height: 90px; object-fit: cover;"
                                                 loading="lazy"
                                                 onerror="this.src='<?php echo generateMoodThumbnail($film['title'], $film['mood']); ?>'">
                                        </td>
                                        <td><?php echo htmlspecialchars($film['title']); ?></td>
                                        <td>
                                            <span class="badge bg-info"><?php echo htmlspecialchars($film['mood']); ?></span>
                                        </td>
                                        <td><?php echo $film['energy_level']; ?></td>
                                        <td>
                                            <span class="badge bg-success"><?php echo htmlspecialchars($film['platform']); ?></span>
                                        </td>
                                        <td><?php echo htmlspecialchars($film['genre'] ?? '-'); ?></td>
                                        <td><?php echo $film['year'] ?? '-'; ?></td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-sm btn-warning" 
                                                        onclick="openEditModal(<?php echo htmlspecialchars(json_encode($film)); ?>)"
                                                        title="Edit Film">
                                                    <i class="bi bi-pencil me-1"></i> Edit
                                                </button>
                                                <button class="btn btn-sm btn-danger" 
                                                        onclick="deleteFilm(<?php echo $film['id']; ?>)"
                                                        title="Hapus Film">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" class="text-center text-muted">Tidak ada data film</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Film Modal (Add/Edit) -->
    <div class="modal fade" id="filmModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">
                        <i class="bi bi-plus-circle"></i> <span id="modalTitleText">Tambah Film</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="filmForm">
                    <div class="modal-body">
                        <input type="hidden" id="filmId" name="id">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Judul Film *</label>
                                <input type="text" class="form-control" id="filmTitle" name="title" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">URL Thumbnail <span class="text-muted">(Opsional)</span></label>
                                <input type="url" class="form-control" id="filmThumbnail" name="thumbnail" 
                                       placeholder="https://example.com/poster.jpg">
                                <small class="text-muted">Masukkan URL gambar poster film. Jika kosong, akan di-generate otomatis berdasarkan judul dan mood dengan warna sesuai mood.</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Mood *</label>
                                <select class="form-select" id="filmMood" name="mood" required>
                                    <option value="">Pilih Mood...</option>
                                    <option value="energi">Energi</option>
                                    <option value="tenang">Tenang</option>
                                    <option value="galau">Galau</option>
                                    <option value="bahagia">Bahagia</option>
                                    <option value="romantis">Romantis</option>
                                    <option value="semangat">Semangat</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tingkat Energi (1-5) *</label>
                                <input type="number" class="form-control" id="filmEnergy" name="energy_level" min="1" max="5" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Platform *</label>
                                <select class="form-select" id="filmPlatform" name="platform" required>
                                    <option value="">Pilih Platform...</option>
                                    <option value="netflix">Netflix</option>
                                    <option value="primevideo">Prime Video</option>
                                    <option value="vidio">Vidio</option>
                                    <option value="disney">Disney+</option>
                                    <option value="hbo">HBO Max</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">URL Platform *</label>
                                <input type="url" class="form-control" id="filmPlatformUrl" name="platform_url" 
                                       placeholder="https://www.netflix.com" required>
                                <small class="text-muted">Link akan mengarah ke beranda platform (tidak bisa langsung ke film spesifik tanpa API)</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Genre</label>
                                <input type="text" class="form-control" id="filmGenre" name="genre">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tahun</label>
                                <input type="number" class="form-control" id="filmYear" name="year" min="1900" max="2099">
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea class="form-control" id="filmDescription" name="description" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="mb-3" id="thumbnailPreview" style="display: none;">
                            <label class="form-label">Preview Thumbnail:</label>
                            <div class="border rounded p-2 bg-light">
                                <img id="thumbnailPreviewImg" src="" alt="Preview" class="img-thumbnail" style="max-width: 200px; height: auto;">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-1"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Simpan Film
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="toastNotification" class="toast" role="alert">
            <div class="toast-header">
                <i class="bi bi-check-circle-fill text-success me-2"></i>
                <strong class="me-auto">Berhasil</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body" id="toastMessage"></div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/admin.js"></script>
</body>
</html>

