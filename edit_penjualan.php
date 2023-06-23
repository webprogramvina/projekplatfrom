<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "SPRJJerukBoyolali";

$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Memeriksa apakah tombol Simpan diklik
if (isset($_POST['simpan'])) {
    // Memeriksa apakah ada data yang dipilih
    if (isset($_POST['data_terpilih'])) {
        // Mendapatkan data yang dipilih dari checkbox
        $data_terpilih = $_POST['data_terpilih'];

        // Melakukan pembaruan status pada data yang dipilih
        $ids = implode("','", $data_terpilih); // Menggabungkan ID dengan tanda koma
        $query = "UPDATE penjualan SET Status = 'Selesai' WHERE Status = 'Proses' AND ID_Nota_Jual IN ('$ids')";

        if ($conn->query($query) === TRUE) {
            echo "Pembaruan berhasil.";
        } else {
            echo "Error: " . $query . "<br>" . $conn->error;
        }
    } else {
        echo "Tidak ada data yang dipilih.";
    }
}

// Mendapatkan data dengan status 'Proses'
$query = "SELECT * FROM penjualan WHERE Status = 'Proses'";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Penjualan</title>
    <style>
        body {
            background-image: url("img/j4.jpeg");
            background-color: rgb(0, 0, 0);
            background-repeat: no-repeat;
            background-size: 10% auto;
            font-family: "Times New Roman", Times, serif;
            color: #ffffff;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #9980FA;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        tr:hover {
            background-color: rgba(107, 113, 113, 0.511);
        }

        .btn {
            display: inline-block;
            padding: 12px 12px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h2>Data Penjualan yang Masih Dalam Proses</h2>
    <form method="post" action="">
        <table>
            <tr>
                <th>#</th>
                <th>ID Nota Jual</th>
                <th>ID Jeruk</th>
                <th>Quantity Jual</th>
                <th>Nama Pembeli</th>
                <th>No. HP</th>
                <th>Alamat</th>
                <th>Tanggal Pesan</th>
                <th>Tanggal Ambil</th>
                <th>Harga</th>
                <th>Status</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                $index = 1;
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td><input type='checkbox' name='data_terpilih[]' value='" . $row['ID_Nota_Jual'] . "'></td>";
                    echo "<td>" . $row['ID_Nota_Jual'] . "</td>";
                    echo "<td>" . $row['ID_Jeruk'] . "</td>";
                    echo "<td>" . $row['Quantity_Jual'] . "</td>";
                    echo "<td>" . $row['Nama_Pembeli'] . "</td>";
                    echo "<td>" . $row['No_HP'] . "</td>";
                    echo "<td>" . $row['Alamat'] . "</td>";
                    echo "<td>" . $row['Tanggal_pesan'] . "</td>";
                    echo "<td>" . $row['Tanggal_Ambil'] . "</td>";
                    echo "<td>" . $row['Harga'] . "</td>";
                    echo "<td>" . $row['Status'] . "</td>";
                    echo "</tr>";
                    $index++;
                }
            } else {
                echo "<tr><td colspan='11'>Tidak ada data yang masih dalam proses.</td></tr>";
            }
            ?>
        </table>
        <br>
        <input type="submit" name="simpan" value="Simpan" class="btn">
    </form>
    <br>
    <a href="tampilan_luar.php" class="btn">Kembali</a>
</body>
</html>

<?php
// Menutup koneksi ke database
$conn->close();
?>

