<!DOCTYPE html>
<html>
<head>
    <title>Rekap Data</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Rekap Data</h1>

    <form method="POST" action="rekap.php">
        <label for="tanggal_batas_atas">Tanggal Batas Atas:</label>
        <input type="date" id="tanggal_batas_atas" name="tanggal_batas_atas">
        <br>
        <label for="tanggal_batas_bawah">Tanggal Batas Bawah:</label>
        <input type="date" id="tanggal_batas_bawah" name="tanggal_batas_bawah">
        <br>
        <input type="submit" name="rekap_proses" value="Rekap Proses">
        <input type="submit" name="rekap_selesai" value="Rekap Selesai">
    </form>

    <?php
    function connectToDatabase() {
        $host = "localhost"; 
        $username = "root"; 
        $password = ""; 
        $database = "SPRJJerukBoyolali"; 

        // Membuat koneksi
        $conn = new mysqli($host, $username, $password, $database);

        // Memeriksa koneksi
        if ($conn->connect_error) {
            die("Koneksi database gagal: " . $conn->connect_error);
        }

        return $conn;
    }

    // Fungsi untuk mengambil data pembelian dengan status "Proses"
    function rekapProses() {
        $conn = connectToDatabase();

        // Query untuk mengambil data pembelian dengan status "Proses"
        $queryPembelian = "SELECT * FROM Pembelian WHERE Status = 'Proses'";
        $resultPembelian = $conn->query($queryPembelian);

        // Query untuk mengambil data penjualan dengan status "Proses"
        $queryPenjualan = "SELECT * FROM Penjualan WHERE Status = 'Proses'";
        $resultPenjualan = $conn->query($queryPenjualan);

        if ($resultPembelian->num_rows > 0) {
            echo "<h2>Data Pembelian dengan Status 'Proses':</h2>";
            echo "<table>";
            echo "<caption>Tabel Pembelian</caption>";
            echo "<tr><th>ID_Nota_Beli</th><th>ID_Jeruk</th><th>Quantity</th><th>Nama_Supplier</th><th>Tanggal_Pesan</th><th>Tanggal_Diantar</th><th>Harga</th><th>Status</th></tr>";

            while ($row = $resultPembelian->fetch_assoc()) {
                echo "<tr><td>".$row["ID_Nota_Beli"]."</td><td>".$row["ID_Jeruk"]."</td><td>".$row["Quantity"]."</td><td>".$row["Nama_Supplier"]."</td><td>".$row["Tanggal_Pesan"]."</td><td>".$row["Tanggal_Diantar"]."</td><td>".$row["Harga"]."</td><td>".$row["Status"]."</td></tr>";
            }

            echo "</table>";
        } else {
            echo "<p>Tidak ada data pembelian dengan status 'Proses'.</p>";
        }

        if ($resultPenjualan->num_rows > 0) {
            echo "<h2>Data Penjualan dengan Status 'Proses':</h2>";
            echo "<table>";
            echo "<caption>Tabel Penjualan</caption>";
            echo "<tr><th>ID_Nota_Jual</th><th>ID_Jeruk</th><th>Quantity_Jual</th><th>Nama_Pembeli</th><th>No_HP</th><th>Alamat</th><th>Tanggal_pesan</th><th>Tanggal_Ambil</th><th>Harga</th><th>Status</th></tr>";

            while ($row = $resultPenjualan->fetch_assoc()) {
                echo "<tr><td>".$row["ID_Nota_Jual"]."</td><td>".$row["ID_Jeruk"]."</td><td>".$row["Quantity_Jual"]."</td><td>".$row["Nama_Pembeli"]."</td><td>".$row["No_HP"]."</td><td>".$row["Alamat"]."</td><td>".$row["Tanggal_pesan"]."</td><td>".$row["Tanggal_Ambil"]."</td><td>".$row["Harga"]."</td><td>".$row["Status"]."</td></tr>";
            }

            echo "</table>";
        } else {
            echo "<p>Tidak ada data penjualan dengan status 'Proses'.</p>";
        }

        $conn->close();
    }

    // Fungsi untuk mengambil data pembelian dan penjualan dengan status "Selesai"
    function rekapSelesai($tanggal_batas_atas, $tanggal_batas_bawah) {
        $conn = connectToDatabase();

        // Query untuk mengambil data pembelian dengan status "Selesai" dan tanggal di antara batas atas dan batas bawah
        $queryPembelian = "SELECT * FROM Pembelian WHERE Status = 'Selesai' AND Tanggal_Diantar BETWEEN '$tanggal_batas_atas' AND '$tanggal_batas_bawah'";
        $resultPembelian = $conn->query($queryPembelian);

        // Query untuk mengambil data penjualan dengan status "Selesai" dan tanggal di antara batas atas dan batas bawah
        $queryPenjualan = "SELECT * FROM Penjualan WHERE Status = 'Selesai' AND Tanggal_Ambil BETWEEN '$tanggal_batas_atas' AND '$tanggal_batas_bawah'";
        $resultPenjualan = $conn->query($queryPenjualan);

        if ($resultPembelian->num_rows > 0) {
            echo "<h2>Data Pembelian dengan Status 'Selesai' antara tanggal $tanggal_batas_atas dan $tanggal_batas_bawah:</h2>";
            echo "<table>";
            echo "<caption>Tabel Pembelian</caption>";
            echo "<tr><th>ID_Nota_Beli</th><th>ID_Jeruk</th><th>Quantity</th><th>Nama_Supplier</th><th>Tanggal_Pesan</th><th>Tanggal_Diantar</th><th>Harga</th><th>Status</th></tr>";

            while ($row = $resultPembelian->fetch_assoc()) {
                echo "<tr><td>".$row["ID_Nota_Beli"]."</td><td>".$row["ID_Jeruk"]."</td><td>".$row["Quantity"]."</td><td>".$row["Nama_Supplier"]."</td><td>".$row["Tanggal_Pesan"]."</td><td>".$row["Tanggal_Diantar"]."</td><td>".$row["Harga"]."</td><td>".$row["Status"]."</td></tr>";
            }

            echo "</table>";
        } else {
            echo "<p>Tidak ada data pembelian dengan status 'Selesai' antara tanggal $tanggal_batas_atas dan $tanggal_batas_bawah.</p>";
        }

        if ($resultPenjualan->num_rows > 0) {
            echo "<h2>Data Penjualan dengan Status 'Selesai' antara tanggal $tanggal_batas_atas dan $tanggal_batas_bawah:</h2>";
            echo "<table>";
            echo "<caption>Tabel Penjualan</caption>";
            echo "<tr><th>ID_Nota_Jual</th><th>ID_Jeruk</th><th>Quantity_Jual</th><th>Nama_Pembeli</th><th>No_HP</th><th>Alamat</th><th>Tanggal_pesan</th><th>Tanggal_Ambil</th><th>Harga</th><th>Status</th></tr>";

            while ($row = $resultPenjualan->fetch_assoc()) {
                echo "<tr><td>".$row["ID_Nota_Jual"]."</td><td>".$row["ID_Jeruk"]."</td><td>".$row["Quantity_Jual"]."</td><td>".$row["Nama_Pembeli"]."</td><td>".$row["No_HP"]."</td><td>".$row["Alamat"]."</td><td>".$row["Tanggal_pesan"]."</td><td>".$row["Tanggal_Ambil"]."</td><td>".$row["Harga"]."</td><td>".$row["Status"]."</td></tr>";
            }

            echo "</table>";
        } else {
            echo "<p>Tidak ada data penjualan dengan status 'Selesai' antara tanggal $tanggal_batas_atas dan $tanggal_batas_bawah.</p>";
        }

        $conn->close();
    }

    // Memeriksa apakah tombol "Rekap Proses" atau "Rekap Selesai" ditekan
    if (isset($_POST["rekap_proses"])) {
        rekapProses();
    }

    if (isset($_POST["rekap_selesai"])) {
        $tanggal_batas_atas = $_POST["tanggal_batas_atas"];
        $tanggal_batas_bawah = $_POST["tanggal_batas_bawah"];
        rekapSelesai($tanggal_batas_atas, $tanggal_batas_bawah);
    }
    ?>
    <br>
    <button onclick="window.location.href = 'tampilan_luar.php';">Kembali</button>
</body>
</html>