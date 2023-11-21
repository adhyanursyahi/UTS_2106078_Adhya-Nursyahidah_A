<?php
// Fungsi untuk membersihkan input dan menghapus karakter yang tidak diinginkan
function cleanInput($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

// Inisialisasi variabel untuk menyimpan nilai default atau hasil validasi
$namaErr = $emailErr = $passwordErr = $tanggalErr = "";
$nama = $email = $password = $tanggal = "";

// Cek apakah formulir sudah dikirimkan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validasi Nama
    if (empty($_POST["nama"])) {
        $namaErr = "Nama diperlukan";
    } else {
        $nama = cleanInput($_POST["nama"]);
    }

    // Validasi Email
    if (empty($_POST["email"])) {
        $emailErr = "Email diperlukan";
    } else {
        $email = cleanInput($_POST["email"]);
        // Validasi format email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Format email tidak valid";
        }
    }

    // Validasi Password
    if (empty($_POST["password"])) {
        $passwordErr = "Password diperlukan";
    } else {
        $password = cleanInput($_POST["password"]);
        // Validasi panjang password
        if (strlen($password) < 8) {
            $passwordErr = "Password minimal 8 karakter";
        }
    }

    // Validasi Tanggal
    if (empty($_POST["tanggal"])) {
        $tanggalErr = "Tanggal diperlukan";
    } else {
        $tanggal = cleanInput($_POST["tanggal"]);
    }

    // Jika tidak ada kesalahan validasi, simpan data ke dalam database
    if (empty($namaErr) && empty($emailErr) && empty($passwordErr) && empty($tanggalErr)) {
        // Konfigurasi koneksi ke database
        $servername = "localhost"; // Ganti sesuai dengan nama server database Anda
        $username = "username"; // Ganti sesuai dengan username database Anda
        $password = "password"; // Ganti sesuai dengan password database Anda
        $dbname = "nama_database"; // Ganti sesuai dengan nama database Anda

        // Buat koneksi
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Cek koneksi
        if ($conn->connect_error) {
            die("Koneksi gagal: " . $conn->connect_error);
        }

        // Query untuk menyimpan data ke dalam tabel
        $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Enkripsi password menggunakan bcrypt
        $sql = "INSERT INTO pendaftaran_workshop (nama, email, password, tanggal_daftar) VALUES ('$nama', '$email', '$hashed_password', '$tanggal')";

        // Eksekusi query
        if ($conn->query($sql) === TRUE) {
            echo "<h2>Terima kasih, Anda telah terdaftar!</h2>";
            echo "<p><strong>Data Anda:</strong></p>";
            echo "Nama: " . $nama . "<br>";
            echo "Email: " . $email . "<br>";
            echo "Password: " . $password . "<br>";
            echo "Tanggal: " . $tanggal . "<br>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Tutup koneksi
        $conn->close();
    }
}
?>
