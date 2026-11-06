
<?php
require 'koneksi.php';

$sql = 'SELECT p.id_produk, p.nama_produk, p.harga, p.stok,
               k.nama_kategori
        FROM produk AS p
        INNER JOIN kategori AS k ON k.id_kategori = p.id_kategori
        ORDER BY p.id_produk';

$hasil = mysqli_query($koneksi, $sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f5f6f0;
            color: #37443b;
            padding: 35px 20px;
        }

        .container {
            max-width: 1050px;
            margin: auto;
        }

        .topbar {
            background: #718b76;
            color: white;
            padding: 25px 30px;
            border-radius: 14px;
            margin-bottom: 25px;
        }

        .topbar h1 {
            font-size: 25px;
            margin-bottom: 8px;
        }

        .topbar p {
            font-size: 14px;
            color: #edf3ed;
        }

        .content {
            background: white;
            padding: 25px;
            border-radius: 14px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.04);
        }

        .content-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 22px;
        }

        .content-header h2 {
            font-size: 19px;
            color: #35483a;
        }

        .content-header p {
            font-size: 13px;
            color: #89938a;
            margin-top: 5px;
        }

        .btn-tambah {
            background: #718b76;
            color: white;
            text-decoration: none;
            padding: 11px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: bold;
        }

        .btn-tambah:hover {
            background: #536d59;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 650px;
        }

        th {
            background: #edf2eb;
            color: #536d59;
            padding: 15px 12px;
            text-align: left;
            font-size: 13px;
        }

        td {
            padding: 15px 12px;
            border-bottom: 1px solid #edf0eb;
            font-size: 13px;
        }

        tr:hover td {
            background: #fafbf8;
        }

        .nomor {
            color: #89938a;
        }

        .nama {
            font-weight: bold;
            color: #35483a;
        }

        .harga {
            color: #66836b;
            font-weight: bold;
        }

        .kategori {
            background: #edf2eb;
            color: #536d59;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 11px;
        }

        .stok {
            color: #536d59;
        }

        .aksi {
            display: flex;
            gap: 7px;
            align-items: center;
        }

        .btn-edit {
            background: #e9c98c;
            color: #604c27;
            text-decoration: none;
            padding: 7px 11px;
            border-radius: 6px;
            font-size: 12px;
        }

        .btn-hapus {
            background: #f1d9d5;
            color: #a34f43;
            border: none;
            padding: 8px 11px;
            border-radius: 6px;
            font-size: 12px;
            cursor: pointer;
        }

        .btn-edit:hover {
            background: #dfbd7e;
        }

        .btn-hapus:hover {
            background: #e9c3bc;
        }

        .kosong {
            text-align: center;
            padding: 30px;
            color: #89938a;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            color: #9aa49a;
            font-size: 12px;
        }

        @media (max-width: 600px) {
            .content-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .topbar h1 {
                font-size: 21px;
            }

            .content {
                padding: 18px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="topbar">
        <h1>Product Management</h1>
        <p>Selamat datang! Kelola data produk dengan mudah.</p>
    </div>

    <div class="content">

        <div class="content-header">
            <div>
                <h2>Daftar Produk</h2>
                <p>Informasi produk yang tersimpan di database.</p>
            </div>

            <a href="tambah.php" class="btn-tambah">
                + Tambah Produk
            </a>
        </div>

        <div class="table-wrapper">
            <table>
                <tr>
                    <th>No.</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>

                <?php if (mysqli_num_rows($hasil) > 0): ?>
                    <?php $no = 1; ?>

                    <?php while ($baris = mysqli_fetch_assoc($hasil)): ?>
                    <tr>
                        <td class="nomor"><?= $no++ ?></td>

                        <td class="nama">
                            <?= e($baris['nama_produk']) ?>
                        </td>

                        <td>
                            <span class="kategori">
                                <?= e($baris['nama_kategori']) ?>
                            </span>
                        </td>

                        <td class="harga">
                            Rp <?= e(number_format((float) $baris['harga'], 0, ',', '.')) ?>
                        </td>

                        <td class="stok">
                            <?= e($baris['stok']) ?> unit
                        </td>

                        <td>
                            <div class="aksi">
                                <a class="btn-edit"
                                   href="edit.php?id=<?= e($baris['id_produk']) ?>">
                                    Edit
                                </a>

                                <form method="post" action="hapus.php"
                                      onsubmit="return confirm('Yakin ingin menghapus produk ini?')">

                                    <input type="hidden" name="id"
                                           value="<?= e($baris['id_produk']) ?>">

                                    <button type="submit" class="btn-hapus">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>

                <?php else: ?>
                    <tr>
                        <td colspan="6" class="kosong">
                            Belum ada produk yang tersedia.
                        </td>
                    </tr>
                <?php endif; ?>

            </table>
        </div>

    </div>

    <div class="footer">
        © 2026 Product Management | Pemrograman Web I
    </div>

</div>

</body>
</html>
