<?php
require_once 'config.php';
require_once 'functions.php';
requireAdmin();

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
$conn = getDBConnection();

if ($method === 'POST') {
    // Create or Update
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $title = $_POST['title'] ?? '';
    $thumbnail = trim($_POST['thumbnail'] ?? '');
    $mood = $_POST['mood'] ?? '';
    $energy_level = intval($_POST['energy_level'] ?? 3);
    $platform = $_POST['platform'] ?? '';
    $platform_url = $_POST['platform_url'] ?? '';
    $description = $_POST['description'] ?? '';
    $genre = $_POST['genre'] ?? '';
    $year = !empty($_POST['year']) ? intval($_POST['year']) : null;

    if (empty($title) || empty($mood) || empty($platform) || empty($platform_url)) {
        echo json_encode(['success' => false, 'message' => 'Judul, Mood, Platform, dan URL Platform wajib diisi!']);
        exit();
    }
    
    // Auto-generate thumbnail if empty
    if (empty($thumbnail)) {
        $thumbnail = generateMoodThumbnail($title, $mood);
    }

    if ($id > 0) {
        // Update
        $stmt = $conn->prepare("UPDATE films SET title=?, thumbnail=?, mood=?, energy_level=?, platform=?, platform_url=?, description=?, genre=?, year=? WHERE id=?");
        $stmt->bind_param("sssissssii", $title, $thumbnail, $mood, $energy_level, $platform, $platform_url, $description, $genre, $year, $id);
    } else {
        // Create
        $stmt = $conn->prepare("INSERT INTO films (title, thumbnail, mood, energy_level, platform, platform_url, description, genre, year) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssisssss", $title, $thumbnail, $mood, $energy_level, $platform, $platform_url, $description, $genre, $year);
    }

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => $id > 0 ? 'Film berhasil diperbarui!' : 'Film berhasil ditambahkan!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Terjadi kesalahan: ' . $stmt->error]);
    }

    $stmt->close();
} elseif ($method === 'DELETE') {
    // Delete
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    if ($id > 0) {
        $stmt = $conn->prepare("DELETE FROM films WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Film berhasil dihapus!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Terjadi kesalahan: ' . $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'ID tidak valid!']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Method tidak diizinkan!']);
}

$conn->close();
?>

