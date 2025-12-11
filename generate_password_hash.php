<?php
/**
 * Quick script to generate password hash for admin
 * Run this once: php generate_password_hash.php
 */

$password = 'admin123';
$hash = password_hash($password, PASSWORD_DEFAULT);

echo "Password: " . $password . "\n";
echo "Hash: " . $hash . "\n";
echo "\nSQL INSERT statement:\n";
echo "INSERT INTO admin_users (username, password) VALUES ('admin', '" . $hash . "');\n";

