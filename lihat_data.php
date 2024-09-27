<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "transaksi_pacar"); // Sesuaikan dengan konfigurasi database Anda
include 'header.php';

// Cek apakah user sudah login
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php"); // Arahkan ke halaman login
    exit;
}

// Cek apakah ada permintaan hapus data
if (isset($_POST['delete'])) {
    if (!empty($_POST['transaksi_ids'])) {
        $idsToDelete = implode(',', array_map('intval', $_POST['transaksi_ids']));
        $deleteQuery = "DELETE FROM transaksi WHERE id IN ($idsToDelete) AND username = '" . $_SESSION['username'] . "'";
        mysqli_query($conn, $deleteQuery);
        header("Location: lihat_data.php"); // Refresh halaman setelah penghapusan
        exit;
    }
}

// Inisialisasi variabel pencarian
$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';
$tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : '';
$search = isset($_GET['search']) ? $_GET['search'] : ''; // Pencarian manual

// Buat query dengan kondisi pencarian
$query = "SELECT * FROM transaksi WHERE username = '" . $_SESSION['username'] . "'";

// Tambahkan filter pencarian jika ada
if ($kategori !== '') {
    $query .= " AND kategori_barang LIKE '%" . mysqli_real_escape_string($conn, $kategori) . "%'";
}
if ($status !== '') {
    $query .= " AND status = '" . mysqli_real_escape_string($conn, $status) . "'";
}
if ($tanggal !== '') {
    $query .= " AND tanggal_transaksi = '" . mysqli_real_escape_string($conn, $tanggal) . "'";
}

// Tambahkan pencarian manual
if ($search !== '') {
    $query .= " AND (nama_pacar LIKE '%" . mysqli_real_escape_string($conn, $search) . "%' 
                  OR nama_barang LIKE '%" . mysqli_real_escape_string($conn, $search) . "%')";
}

// Tambahkan urutan berdasarkan status dan tanggal
$query .= " ORDER BY FIELD(status, 'memberi', 'diberi'), tanggal_transaksi DESC";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KK-Lihat Semua Data</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> <!-- Tambahkan link Bootstrap -->
</head>
<body>

<div class="container mt-4">
    <h1>Data Transaksi pacarnya <?php echo htmlspecialchars($_SESSION['username']); ?></h1>
    <link rel="icon" href="images/logo.png" type="image/jpg">
    
    <form method="GET" class="mb-3">
        <div class="row">
            <div class="col-md-4">
                <select name="kategori" class="form-control">
                    <option value="">Pilih Kategori</option>
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
            <div class="col-md-4">
                <select name="status" class="form-control">
                    <option value="">Pilih Status</option>
                    <option value="memberi">Memberi</option>
                    <option value="diberi">Diberi</option>
                </select>
            </div>
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Cari semua data">
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Cari</button>
<a href="lihat_data.php" class="btn btn-secondary mt-3">Refresh</a> <!-- Tombol Refresh -->
<a href="export_pdf.php" class="btn btn-success mt-3">Export PDF</a> <!-- Tombol Export PDF -->

    </form>

    <form method="POST" action="lihat_data.php">
        <?php if (mysqli_num_rows($result) > 0) { ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Pilih</th>
                        <th>Nama Pacar</th>
                        <th>Nama Barang</th>
                        <th>Harga (Rp)</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Kategori Barang</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td>
                                <input type="checkbox" name="transaksi_ids[]" value="<?php echo $row['id']; ?>">
                            </td>
                            <td><?php echo htmlspecialchars($row['nama_pacar']); ?></td>
                            <td><?php echo htmlspecialchars($row['nama_barang']); ?></td>
                            <td><?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                            <td><?php echo htmlspecialchars($row['status']); ?></td>
                            <td><?php echo $row['tanggal_transaksi']; ?></td>
                            <td><?php echo htmlspecialchars($row['kategori_barang']); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <button type="submit" name="delete" class="btn btn-danger">Hapus Data Terpilih</button>
        <?php } else { ?>
            <p>Tidak ada data transaksi yang ditemukan.</p>
        <?php } ?>
    </form>

    <!-- Tombol di bawah tabel -->
    <div class="d-flex justify-content-center mt-4">
        <a href="transaksi.php" class="btn btn-secondary mx-2">Kembali ke Tambah Data</a>
        <a href="logout.php" class="btn btn-danger mx-2">Logout</a>
    </div>
</div>

</body>
</html>

<?php
// Include the footer
include 'footer.php';
?>
