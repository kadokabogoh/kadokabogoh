<?php
// Koneksi ke database
$host = 'localhost';
$db = 'transaksi_pacar';
$user = 'root'; // Ganti dengan username database Anda
$pass = ''; // Ganti dengan password database Anda

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password

    // Query untuk menyimpan data pengguna baru
    $sql = "INSERT INTO pengguna (username, password) VALUES ('$username', '$password')";

    if ($conn->query($sql) === TRUE) {
        $message = "Registrasi berhasil! Silakan <a href='login.php'>login</a>.";
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KK-Registrasi Pengguna</title>
    <link rel="icon"href="images/logo.png"
    type="image/jpg">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container mt-5">
    <img src="images/logo.png" alt="KadoKabogoh Logo" style="width: 150px; height: auto; display: block; margin: 0 auto;">
        <h1 class="text-center">Registrasi Pengguna</h1>
        <?php if ($message): ?>
            <div class="alert alert-success text-center"><?php echo $message; ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Daftar</button>
        </form>
        <div class="mt-3 text-center">
            <p>Sudah punya akun? <a href="login.php" class="btn btn-link">Login di sini</a>.</p>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
