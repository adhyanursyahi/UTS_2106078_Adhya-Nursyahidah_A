<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pendaftaran Workshop</title>
    <style>
        .error {
            color: red;
        }
    </style>
</head>
<link rel="stylesheet" type="text/css" href="style.css">

<body>
    <?php
    // Inisialisasi variabel untuk menyimpan nilai default atau hasil validasi
    $namaErr = $emailErr = $passwordErr = $tanggalErr = "";
    $nama = $email = $password = $tanggal = "";

    // Fungsi untuk membersihkan input dan menghapus karakter yang tidak diinginkan
    function cleanInput($input) {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
    }

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
    }
    ?>

    <h2>Form Pendaftaran Workshop</h2>
    <p><span class="error">* Harus diisi</span></p>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        Nama: <input type="text" name="nama" value="<?php echo $nama; ?>">
        <span class="error">* <?php echo $namaErr; ?></span>
        <br><br>

        Email: <input type="text" name="email" value="<?php echo $email; ?>">
        <span class="error">* <?php echo $emailErr; ?></span>
        <br><br>

        Password: <input type="password" name="password">
        <span class="error">* <?php echo $passwordErr; ?></span>
        <br><br>

        Tanggal: <input type="datetime-local" name="tanggal" value="<?php echo $tanggal; ?>">
        <span class="error">* <?php echo $tanggalErr; ?></span>
        <br><br>

        <input type="submit" name="submit" value="Daftar">
    </form>

    <?php
    // Menampilkan hasil pendaftaran setelah formulir dikirimkan
    if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($namaErr) && empty($emailErr) && empty($passwordErr) && empty($tanggalErr)) {
        echo "<h2>Terima kasih, Anda telah terdaftar!</h2>";
        echo "<p><strong>Data Anda:</strong></p>";
        echo "Nama: " . $nama . "<br>";
        echo "Email: " . $email . "<br>";
        echo "Password: " . $password . "<br>";
        echo "Tanggal: " . $tanggal . "<br>";
    }
    ?>
</body>
</html>