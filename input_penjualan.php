<!DOCTYPE html>
<html>
<head>
    <title>Input Penjualan</title>
    <link rel="stylesheet" type="text/css" href="stylepenjualan.css">
</head>
<body>
    
    <?php
    // Fungsi untuk menyimpan data ke database
    function simpanDataPenjualan($data) {
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

        // Mendapatkan jumlah data penjualan saat ini
        $sql_count = "SELECT COUNT(*) AS count FROM Penjualan";
        $result_count = $conn->query($sql_count);
        $row_count = $result_count->fetch_assoc();
        $entry_count = $row_count['count'] + 1;

        // Mendapatkan awalan ID_Nota_Jual
        $id_nota_jual_prefix = "NJ";

        // Membentuk ID_Nota_Jual dengan awalan dan entry count
        $id_nota_jual = $id_nota_jual_prefix . $entry_count;

        // Mendapatkan harga jeruk dari tabel Jeruk
        $sql_harga_jeruk = "SELECT Harga FROM Jeruk WHERE ID_Jeruk = '" . $data['id_jeruk'] . "'";
        $result_harga_jeruk = $conn->query($sql_harga_jeruk);
        $row_harga_jeruk = $result_harga_jeruk->fetch_assoc();
        $harga_jeruk = $row_harga_jeruk['Harga'];

        // Menyimpan data ke tabel Penjualan
        $sql = "INSERT INTO Penjualan (ID_Nota_Jual, ID_Jeruk, Quantity_Jual, Harga, Nama_Pembeli, No_HP, Alamat, Tanggal_Pesan, Tanggal_Ambil, Status)
                VALUES ('" . $id_nota_jual . "', '" . $data['id_jeruk'] . "', " . $data['quantity_jual'] . ", " . $harga_jeruk . ", '" . $data['nama_pembeli'] . "', '" . $data['no_hp'] . "', '" . $data['alamat'] . "', '" . $data['tanggal_pesan'] . "', '" . $data['tanggal_ambil'] . "', 'Proses')";

        if ($conn->query($sql) === TRUE) {
            // Menampilkan notifikasi data tersimpan
            echo "<script>alert('Data penjualan berhasil disimpan.');</script>";
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

    <h2>Input Penjualan</h2>
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

        <label>Quantity Jual:</label>
        <input type="number" name="quantity_jual" required><br>

        <label>Nama Pembeli:</label>
        <input type="text" name="nama_pembeli" required><br>

        <label>No. HP:</label>
        <input type="text" name="no_hp" required><br>

        <label>Alamat:</label>
        <input type="text" name="alamat" required><br>

        <label>Tanggal Pesan:</label>
        <input type="date" name="tanggal_pesan" required><br>

        <label>Tanggal Ambil:</label>
        <input type="date" name="tanggal_ambil" min="<?php echo date('Y-m-d'); ?>" required><br>

        <input type="submit" name="submit" value="Preview">
    </form>

    <?php
    // Memeriksa apakah form telah dikirim
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
        // Mendapatkan nilai dari form
        $id_jeruk = $_POST["id_jeruk"];
        $quantity_jual = $_POST["quantity_jual"];
        $nama_pembeli = $_POST["nama_pembeli"];
        $no_hp = $_POST["no_hp"];
        $alamat = $_POST["alamat"];
        $tanggal_pesan = $_POST["tanggal_pesan"];
        $tanggal_ambil = $_POST["tanggal_ambil"];

        // Menampilkan data yang akan disimpan
        echo "<h3>Preview Data Penjualan:</h3>";
        echo "ID Jeruk\t " . $id_jeruk . "<br>";
        echo "Nama Jeruk\t : " . $jeruk_options[$id_jeruk] . "<br>";
        echo "Quantity Jual\t: " . $quantity_jual . "<br>";
        echo "Nama Pembeli\t: " . $nama_pembeli . "<br>";
        echo "No. HP\t: " . $no_hp . "<br>";
        echo "Alamat: " . $alamat . "<br>";
        echo "Tanggal Pesan: " . $tanggal_pesan . "<br>";
        echo "Tanggal Ambil: " . $tanggal_ambil . "<br>";
        echo "Status: Proses<br>";

        // Tombol kembali ke halaman utama
        echo "<form action='index.php' method='post'>";
        echo "<input type='submit' name='submit' value='Kembali'>";
        echo "</form>";

        // Tombol simpan
        echo "<form action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='post'>";
        echo "<input type='hidden' name='id_jeruk' value='" . $id_jeruk . "'>";
        echo "<input type='hidden' name='quantity_jual' value='" . $quantity_jual . "'>";
        echo "<input type='hidden' name='nama_pembeli' value='" . $nama_pembeli . "'>";
        echo "<input type='hidden' name='no_hp' value='" . $no_hp . "'>";
        echo "<input type='hidden' name='alamat' value='" . $alamat . "'>";
        echo "<input type='hidden' name='tanggal_pesan' value='" . $tanggal_pesan . "'>";
        echo "<input type='hidden' name='tanggal_ambil' value='" . $tanggal_ambil . "'>";
        echo "<input type='submit' name='submit' value='Simpan'>";
        echo "</form>";
    }

    // Memeriksa apakah form telah dikirim dan tombol Simpan diklik
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit']) && $_POST['submit'] == 'Simpan') {
        // Menyimpan data ke database
        $data_penjualan = array(
            'id_jeruk' => $_POST['id_jeruk'],
            'quantity_jual' => $_POST['quantity_jual'],
            'nama_pembeli' => $_POST['nama_pembeli'],
            'no_hp' => $_POST['no_hp'],
            'alamat' => $_POST['alamat'],
            'tanggal_pesan' => $_POST['tanggal_pesan'],
            'tanggal_ambil' => $_POST['tanggal_ambil']
        );

        simpanDataPenjualan($data_penjualan);
    }
    ?>
</body>
</html>