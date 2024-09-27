<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "transaksi_pacar"); // Sesuaikan dengan konfigurasi database Anda

// Cek apakah user sudah login
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php"); // Arahkan ke halaman login
    exit;
}

// Cek apakah username sudah diset
if (!isset($_SESSION['username'])) {
    echo "Error: User tidak dikenali.";
    exit;
}

// Variabel untuk menampilkan alert
$alert_message = "";
$alert_class = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_pacar = $_POST['nama_pacar'];
    $nama_barang = $_POST['nama_barang'];
    $harga = str_replace('.', '', $_POST['harga']); // Hapus titik untuk memformat harga
    $status = $_POST['status'];
    $kategori_barang = $_POST['kategori_barang'];
    $tanggal_transaksi = date('Y-m-d H:i:s'); // Tambahkan tanggal transaksi saat ini

    // Siapkan query untuk menyimpan data
    $insert_query = "INSERT INTO transaksi (username, nama_pacar, nama_barang, harga, status, kategori_barang, tanggal_transaksi) VALUES ('" . $_SESSION['username'] . "', '$nama_pacar', '$nama_barang', '$harga', '$status', '$kategori_barang', '$tanggal_transaksi')";
    
    // Eksekusi query
    if (mysqli_query($conn, $insert_query)) {
        $alert_message = "Data transaksi berhasil disimpan.";
        $alert_class = "success"; // Class untuk styling alert sukses
    } else {
        $alert_message = "Error: " . mysqli_error($conn);
        $alert_class = "error"; // Class untuk styling alert error
    }
}

// Ambil 5 data transaksi terbaru untuk pengguna yang sedang login
$query = "SELECT * FROM transaksi WHERE username = '" . $_SESSION['username'] . "' ORDER BY tanggal_transaksi DESC LIMIT 5";
$result = mysqli_query($conn, $query);

// Hitung total memberi dan diberi untuk user yang sedang login
$total_memberi_query = "SELECT COUNT(*) FROM transaksi WHERE username = '" . $_SESSION['username'] . "' AND status = 'memberi'";
$total_memberi = mysqli_fetch_array(mysqli_query($conn, $total_memberi_query))[0];

$total_diberi_query = "SELECT COUNT(*) FROM transaksi WHERE username = '" . $_SESSION['username'] . "' AND status = 'diberi'";
$total_diberi = mysqli_fetch_array(mysqli_query($conn, $total_diberi_query))[0];

// Total Memberi
$query_memberi = "SELECT SUM(harga) AS total_memberi FROM transaksi WHERE username = '" . $_SESSION['username'] . "' AND status = 'memberi'";
$result_memberi = mysqli_query($conn, $query_memberi);
$row_memberi = mysqli_fetch_assoc($result_memberi);
$total_memberi_harga = $row_memberi['total_memberi'] ? $row_memberi['total_memberi'] : 0; // Jika tidak ada transaksi, set 0

// Total Diberi
$query_diberi = "SELECT SUM(harga) AS total_diberi FROM transaksi WHERE username = '" . $_SESSION['username'] . "' AND status = 'diberi'";
$result_diberi = mysqli_query($conn, $query_diberi);
$row_diberi = mysqli_fetch_assoc($result_diberi);
$total_diberi_harga = $row_diberi['total_diberi'] ? $row_diberi['total_diberi'] : 0; // Jika tidak ada transaksi, set 0
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KK-Transaksi</title>
    <link rel="icon"href="images/logo.png"
    type="image/jpg">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> <!-- Tambahkan link Bootstrap -->
    <style>
        .alert {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            border-radius: 5px;
            z-index: 1000;
            display: none;
        }

        .alert.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .transaction-detail {
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tampilkan alert jika ada pesan
            const alertMessage = "<?php echo $alert_message; ?>";
            if (alertMessage) {
                const alertBox = document.createElement("div");
                alertBox.classList.add("alert", "<?php echo $alert_class; ?>");
                alertBox.innerText = alertMessage;
                document.body.appendChild(alertBox);
                alertBox.style.display = "block";

                // Sembunyikan alert setelah 3 detik
                setTimeout(() => {
                    alertBox.style.display = "none";
                }, 3000);
            }

            // Format uang Rupiah
            var hargaInput = document.getElementById('harga');
            hargaInput.addEventListener('keyup', function(e) {
                this.value = formatRupiah(this.value);
            });

            function formatRupiah(angka) {
                var number_string = angka.replace(/[^,\d]/g, '').toString();
                var split = number_string.split(',');
                var sisa = split[0].length % 3;
                var rupiah = split[0].substr(0, sisa);
                var ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
                return rupiah;
            }
        });
    </script>
</head>
<body>

<?php include 'header.php'; ?>

<div class="container mt-4">
    <h1>Form Transaksi pacar nya <?php echo htmlspecialchars($_SESSION['username']); ?></h1>

    <form method="POST" action="">
        <div class="form-group">
            <label for="nama_pacar">Nama Pacar:</label>
            <input type="text" id="nama_pacar" name="nama_pacar" required class="form-control">
        </div>

        <div class="form-group">
            <label for="nama_barang">Nama Barang:</label>
            <input type="text" id="nama_barang" name="nama_barang" required class="form-control">
        </div>

        <div class="form-group">
            <label for="harga">Harga (Rp):</label><br>
            <div style="display: flex; align-items: center;">
                <span>Rp</span>
                <input type="text" id="harga" name="harga" required class="form-control" style="margin-left: 5px; width: 200px;">
            </div>
        </div>

        <div class="form-group">
            <label for="status">Status:</label>
            <select id="status" name="status" required class="form-control">
                <option value="">Pilih Status</option>
                <option value="memberi">Memberi</option>
                <option value="diberi">Diberi</option>
            </select>
        </div>

        <div class="form-group">
            <label for="kategori_barang">Kategori Barang:</label>
            <select id="kategori_barang" name="kategori_barang" required class="form-control">
                <option value="Aksesori">Aksesori</option>
                <option value="Pakaian">Pakaian</option>
                <option value="Barang Kecantikan/Kesehatan">Barang Kecantikan/Kesehatan</option>
                <option value="Elektronik">Elektronik</option>
                <option value="Hobi dan Minat">Hobi dan Minat</option>
                <option value="Hadiah Pribadi">Hadiah Pribadi</option>
                <option value="Makanan/Minuman">Makanan/Minuman</option>
                <option value="Pengalaman">Pengalaman</option>
                <option value="lainnya">Lainnya (ketik manual)</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    
    <button onclick="window.location.href='lihat_data.php';" class="btn btn-secondary mt-3">Lihat Data Transaksi</button>

    <h2 class="mt-4">Total Transaksi</h2>
    <p>Total Memberi: Rp <?php echo number_format($total_memberi_harga, 0, ',', '.'); ?></p>
    <p>Total Diberi: Rp <?php echo number_format($total_diberi_harga, 0, ',', '.'); ?></p>

    <h2 class="mt-4">Transaksi Terbaru</h2>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <div class="transaction-detail">
            <p><strong>Nama Pacar:</strong> <?php echo htmlspecialchars($row['nama_pacar']); ?></p>
            <p><strong>Nama Barang:</strong> <?php echo htmlspecialchars($row['nama_barang']); ?></p>
            <p><strong>Harga:</strong> Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></p>
            <p><strong>Status:</strong> <?php echo htmlspecialchars($row['status']); ?></p>
            <p><strong>Kategori Barang:</strong> <?php echo htmlspecialchars($row['kategori_barang']); ?></p>
            <p><strong>Tanggal Transaksi:</strong> <?php echo htmlspecialchars($row['tanggal_transaksi']); ?></p>
        </div>
    <?php } ?>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
