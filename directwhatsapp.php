<?php
// Nomor WhatsApp Anda
$whatsapp_number = '6285824573446';

// Pesan yang akan dikirim
$message = urlencode("Hallo, mimin ganteng :), saya mau daftar Kadokabogoh™! nih, tolong di bantu ya");

// URL WhatsApp untuk mengirim pesan
$whatsapp_url = "https://wa.me/$whatsapp_number?text=$message";

// Redirect ke URL WhatsApp
header("Location: $whatsapp_url");
exit;
?>
