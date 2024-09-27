<!-- header.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KK - <?php echo isset($title) ? $title : 'Lihat Data'; ?></title>
    <link rel="stylesheet" href="css/styles.css"> <!-- Link ke file CSS -->
    <style>
        header {
            background-color: #007bff;
            color: white;
            padding: 15px; /* Tambah padding untuk ruang lebih */
            text-align: center;
        }
        .logo {
            width: 80px; /* Ukuran logo yang lebih besar */
            vertical-align: middle; /* Vertikal tengah logo */
        }
        nav {
            margin: 10px 0; /* Jarak navigasi */
        }
        nav a {
            color: white;
            margin: 0 15px;
            text-decoration: none;
            padding: 5px 10px; /* Tambah padding untuk area klik */
        }
        nav a:hover {
            text-decoration: underline; /* Garis bawah saat hover */
            background-color: rgba(255, 255, 255, 0.2); /* Tambah efek saat hover */
            border-radius: 5px; /* Sudut membulat pada hover */
        }
    </style>
</head>
<body>
    <header>
        <img src="images/logo.png" alt="Kadokabogoh™ Logo" class="logo">

        <nav>
            <a href="index.php">Home</a>
            <a href="transaksi.php">Tambah Data</a>
            <a href="lihat_data.php">Lihat Data Semua</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>
