<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Jika tidak login, redirect ke login
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KK-Home</title>
    <link rel="icon"href="images/logo.png"
    type="image/jpg">
    <link rel="stylesheet" href="css/styles.css"> <!-- Link ke file CSS -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        header {
            background-color: #007bff;
            color: white;
            padding: 10px 0;
            text-align: center;
        }
        .logo {
            width: 150px; /* Ukuran logo */
            height: auto;
            margin-bottom: 10px;
        }
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 80vh; /* Tinggi minimal konten */
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .profile-box {
            width: 100px; /* Ukuran kotak profil */
            height: 100px; /* Ukuran kotak profil */
            border-radius: 50%; /* Membuat kotak menjadi lingkaran */
            overflow: hidden; /* Menghilangkan bagian gambar yang keluar dari kotak */
            margin-bottom: 20px; /* Jarak antara foto dan teks */
            display: flex; /* Menggunakan flexbox untuk pemusatan */
            align-items: center; /* Memusatkan secara vertikal */
            justify-content: center; /* Memusatkan secara horizontal */
            border: 2px solid #007bff; /* Garis batas kotak */
        }
        .profile-image {
            width: 100%; /* Lebar gambar mengikuti kotak */
            height: 100%; /* Tinggi gambar mengikuti kotak */
            object-fit: cover; /* Memastikan gambar menutupi kotak tanpa merusak rasio */
        }
        .welcome {
            margin-bottom: 20px;
            font-size: 24px;
            text-align: center; /* Rata tengah teks */
        }
        .menu {
            margin: 10px 0;
            text-align: center; /* Mengatur teks dalam menu agar rata tengah */
        }
        .menu a {
            display: inline-block; /* Mengubah display menjadi inline-block untuk mengatur lebar dan tinggi */
            margin: 10px 0;
            padding: 15px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .menu a:hover {
            background-color: #0056b3;
        }
        footer {
            margin-top: 20px;
            text-align: center;
            padding: 10px 0;
            background-color: #007bff;
            color: white;
            position: relative;
            width: 100%;
        }
    </style>
</head>
<body>
    <header>
        <img src="images/logo.png" alt="KadoKabogoh Logo" class="logo">
     
    </header>
    <div class="container">
        <div class="profile-box"> <!-- Kotak pembungkus untuk foto profil -->
            <img src="images/ppp.jpg" alt="Foto Profil" class="profile-image"> <!-- Gambar default -->
        </div>
        <div class="welcome">Selamat datang, <?php echo htmlspecialchars($_SESSION['username']); ?>!</div>
        <div class="menu">
            <a href="transaksi.php">Tambah Data</a>
            <a href="lihat_data.php">Lihat Data Semua</a>
        </div>
        <div class="logout">
            <a href="logout.php">Logout</a>
        </div>
    </div>
    <footer>
    <p>&copy; 2024 Kadokabogoh™. All rights reserved. Created by Revian.</p>
    </footer>
</body>
</html>
