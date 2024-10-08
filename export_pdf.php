<?php
session_start();
require 'vendor/autoload.php'; // Autoload dompdf jika menggunakan Composer
use Dompdf\Dompdf;

// Cek apakah user sudah login
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php"); // Arahkan ke halaman login
    exit;
}

// Koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "transaksi_pacar");

// Ambil data dari database sesuai dengan user yang login
$query = "SELECT * FROM transaksi WHERE username = '" . $_SESSION['username'] . "'";
$result = mysqli_query($conn, $query);

// Mendapatkan nama user dari session
$username = $_SESSION['username'];

// Mendapatkan tanggal hari ini
$tanggal_export = date('d-m-Y H:i:s');

// Buat HTML untuk di-export ke PDF
$html = '<h2>Laporan Transaksi ' . htmlspecialchars($username) . '</h2>';
$html .= '<p style="text-align: center;">Generated by Kadokabogoh™ <br>"Catat Takut Putus"</p>';

$html .= '<p>Export Date: ' . $tanggal_export . '</p>'; // Tampilkan tanggal export
$html .= '<table border="1" cellpadding="10" cellspacing="0">';
$html .= '<thead>
            <tr>
                <th>Nama Pacar</th>
                <th>Nama Barang</th>
                <th>Harga (Rp)</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th>Kategori Barang</th>
            </tr>
          </thead>';
$html .= '<tbody>';

while ($row = mysqli_fetch_assoc($result)) {
    $html .= '<tr>
                <td>' . htmlspecialchars($row['nama_pacar']) . '</td>
                <td>' . htmlspecialchars($row['nama_barang']) . '</td>
                <td>' . number_format($row['harga'], 0, ',', '.') . '</td>
                <td>' . htmlspecialchars($row['status']) . '</td>
                <td>' . htmlspecialchars($row['tanggal_transaksi']) . '</td>
                <td>' . htmlspecialchars($row['kategori_barang']) . '</td>
              </tr>';
}

$html .= '</tbody></table>';

// Tambahkan lisensi atau watermark di bawah halaman
$html .= '<br><hr>';
$html .= '<p style="text-align: center; font-size: 12px;">Laporan ini dihasilkan oleh aplikasi Kadokabogoh™. Hak cipta &copy; 2024 Kadokabogoh. Semua hak dilindungi.</p>';

// Inisialisasi DOMPDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);

// (Opsional) Mengatur ukuran kertas dan orientasi
$dompdf->setPaper('A4', 'landscape');

// Render HTML menjadi PDF
$dompdf->render();

// Gunakan nama user sebagai nama file PDF
$nama_file = 'Laporan_Transaksi_' . htmlspecialchars($username) . '.pdf';

// Output file PDF ke browser
$dompdf->stream($nama_file, array("Attachment" => false)); // Jika ingin otomatis download, ganti 'false' menjadi 'true'
?>
