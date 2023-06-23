<!DOCTYPE html>
<html>
<head>
    <title>Input Pembelian</title>
    <link rel="stylesheet" type="text/css" href="style1.css">
</head>
<body>
    <?php
    // Fungsi untuk menyimpan data ke database
    function simpanDataPembelian($data) {
        // Koneksi ke database SPRJJerukBoyolali
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "SPRJJerukBoyolali";

        // Membuat koneksi
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Memeriksa koneksi
        if ($conn->connect_error) {
            die("Koneksi ke database gagal: " . $conn->connect_error);
        }

        // Mendapatkan jumlah data pembelian saat ini
        $sql_count = "SELECT COUNT(*) AS count FROM Pembelian";
        $result_count = $conn->query($sql_count);
        $row_count = $result_count->fetch_assoc();
        $entry_count = $row_count['count'] + 1;

        // Mendapatkan awalan ID_Nota_Beli
        $id_nota_beli_prefix = "NB";

        // Membentuk ID_Nota_Beli dengan awalan dan entry count
        $id_nota_beli = $id_nota_beli_prefix . $entry_count;

        // Menyimpan data ke tabel Pembelian
        $sql = "INSERT INTO Pembelian (ID_Nota_Beli, ID_Jeruk, Quantity, Nama_Supplier, Tanggal_Pesan, Tanggal_Diantar, Harga, Status)
                VALUES ('" . $id_nota_beli . "', '" . $data['id_jeruk'] . "', " . $data['quantity'] . ", '" . $data['nama_supplier'] . "', '" . $data['tanggal_beli'] . "', '" . $data['tanggal_diantar'] . "', " . $data['harga'] . ",  'Proses')";

        if ($conn->query($sql) === TRUE) {
            // Menampilkan notifikasi data tersimpan
            echo "<script>alert('Data pembelian berhasil disimpan.');</script>";
        } else {
            echo "Terjadi kesalahan: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }

    // Koneksi ke database SPRJJerukBoyolali
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "SPRJJerukBoyolali";

    // Membuat koneksi
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Memeriksa koneksi
    if ($conn->connect_error) {
        die("Koneksi ke database gagal: " . $conn->connect_error);
    }

    // Mendapatkan data jeruk dari tabel Jeruk
    $sql_jeruk = "SELECT ID_Jeruk, Nama_Jeruk FROM Jeruk";
    $result_jeruk = $conn->query($sql_jeruk);

    // Menyimpan data jeruk dalam array untuk digunakan di dropdown
    $jeruk_options = array();
    while ($row_jeruk = $result_jeruk->fetch_assoc()) {
        $jeruk_options[$row_jeruk['ID_Jeruk']] = $row_jeruk['Nama_Jeruk'];
    }

    $conn->close();
    ?>

    <h2>Input Pembelian</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label>Nama Jeruk:</label>
        <select name="id_jeruk" required>
            <option value="">Pilih Jeruk</option>
            <?php
            foreach ($jeruk_options as $id => $nama) {
                echo "<option value='" . $id . "'>" . $nama . "</option>";
            }
            ?>
        </select><br>

        <label>Quantity:</label>
        <input type="number" name="quantity" required><br>

        <label>Nama Supplier:</label>
        <input type="text" name="nama_supplier" required><br>

        <label>Tanggal Pesan:</label>
        <input type="date" name="tanggal_beli" required><br>

        <label>Tanggal Diantar:</label>
        <input type="date" name="tanggal_diantar" min="<?php echo date('Y-m-d'); ?>" required><br>

        <label>Harga:</label>
        <input type="number" name="harga" required><br>

        <input type="submit" name="submit" value="Preview">
    </form>

    <?php
    // Memeriksa apakah form telah dikirim
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
        // Mendapatkan nilai dari form
        $id_jeruk = $_POST["id_jeruk"];
        $quantity = $_POST["quantity"];
        $nama_supplier = $_POST["nama_supplier"];
        $tanggal_beli = $_POST["tanggal_beli"];
        $tanggal_diantar = $_POST["tanggal_diantar"];
        $harga = $_POST["harga"];

        // Menampilkan data yang akan disimpan
        echo "<h3>Preview Data Pembelian:</h3>";
        echo "ID Jeruk: " . $id_jeruk . "<br>";
        echo "Nama Jeruk: " . $jeruk_options[$id_jeruk] . "<br>";
        echo "Quantity: " . $quantity . "<br>";
        echo "Nama Supplier: " . $nama_supplier . "<br>";
        echo "Tanggal Pesan: " . $tanggal_beli . "<br>";
        echo "Tanggal Diantar: " . $tanggal_diantar . "<br>";
        echo "Harga: " . $harga . "<br>";
        echo "Status: Proses<br>";

        // Tombol kembali ke halaman utama
        echo "<form action='tampilan_luar.php' method='post'>";
        echo "<input type='submit' name='submit' value='Kembali'>";
        echo "</form>";

        // Tombol simpan
        echo "<form action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='post'>";
        echo "<input type='hidden' name='id_jeruk' value='" . $id_jeruk . "'>";
        echo "<input type='hidden' name='quantity' value='" . $quantity . "'>";
        echo "<input type='hidden' name='nama_supplier' value='" . $nama_supplier . "'>";
        echo "<input type='hidden' name='tanggal_beli' value='" . $tanggal_beli . "'>";
        echo "<input type='hidden' name='tanggal_diantar' value='" . $tanggal_diantar . "'>";
        echo "<input type='hidden' name='harga' value='" . $harga . "'>";
        echo "<input type='submit' name='submit' value='Simpan'>";
        echo "</form>";
    }

    // Memeriksa apakah form telah dikirim dan tombol Simpan diklik
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit']) && $_POST['submit'] == 'Simpan') {
        // Menyimpan data ke database
        $data_pembelian = array(
            'id_jeruk' => $_POST['id_jeruk'],
            'quantity' => $_POST['quantity'],
            'nama_supplier' => $_POST['nama_supplier'],
            'tanggal_beli' => $_POST['tanggal_beli'],
            'tanggal_diantar' => $_POST['tanggal_diantar'],
            'harga' => $_POST['harga']
        );

        simpanDataPembelian($data_pembelian);
    }
    ?>
</body>
</html>