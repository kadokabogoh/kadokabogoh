<?php
$password = 'admin'; // Ganti dengan password yang Anda inginkan
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
echo $hashed_password;
?>
