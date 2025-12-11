<?php
/**
 * Setup Admin Password
 * Run this file once to set up or reset admin password
 * Access: http://localhost/mood-based-film-recommendation/setup_admin.php
 */

require_once 'config.php';

// Only allow this to run if not in production (for security)
$password = 'admin123'; // Default password

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_password = $_POST['password'] ?? $password;
    
    if (!empty($new_password)) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        
        $conn = getDBConnection();
        
        // Check if admin exists
        $check = $conn->query("SELECT id FROM admin_users WHERE username = 'admin'");
        
        if ($check->num_rows > 0) {
            // Update existing admin
            $stmt = $conn->prepare("UPDATE admin_users SET password = ? WHERE username = 'admin'");
            $stmt->bind_param("s", $hashed_password);
            $message = $stmt->execute() ? 'Password admin berhasil diperbarui!' : 'Gagal memperbarui password!';
        } else {
            // Create new admin
            $stmt = $conn->prepare("INSERT INTO admin_users (username, password) VALUES ('admin', ?)");
            $stmt->bind_param("s", $hashed_password);
            $message = $stmt->execute() ? 'Admin berhasil dibuat!' : 'Gagal membuat admin!';
        }
        
        $stmt->close();
        $conn->close();
        
        echo "<div style='padding: 20px; background: #d4edda; color: #155724; border-radius: 5px; margin: 20px;'>";
        echo "<strong>Berhasil!</strong> " . $message;
        echo "<br><br>Username: <strong>admin</strong><br>Password: <strong>" . htmlspecialchars($new_password) . "</strong>";
        echo "<br><br><a href='admin_login.php'>Login ke Admin Panel</a>";
        echo "</div>";
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup Admin - Mood-Based Film Recommendation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow">
                    <div class="card-body p-4">
                        <h3 class="mb-4">Setup Admin Password</h3>
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Password Baru</label>
                                <input type="password" class="form-control" name="password" value="admin123" required>
                                <small class="text-muted">Default: admin123</small>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Set Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

