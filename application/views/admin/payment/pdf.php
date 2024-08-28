<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan</title>
</head>
<body>
    
    <center><h2>Invoice Penjualan</h2><h2>Hair Pomade Pekanbaru</h2><p>Jl. Letjend.S.Parman, Suka Maju, Kec. Sail, Kota Pekanbaru, Riau 28131</p></center>
    <hr/>
    <p><b>Tanggal: <?= date('d-m-Y') ?></b></p>
    <table border="1" width="100%" style="text-align:center;">
        <tr>
            <th>No</th>
            <th>Nama Produk</th>
            <th>Harga</th>
            <th>Quantity</th>
            <th>Total Harga</th>
        </tr>
        <?php 
        $no = 1; 
        $total = 0;
        foreach ($pesanan as $row) :
            $subtotal = $row->jumlah * $row->harga; 
            $total += $subtotal; 
            ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?= $row->nama_brg ?></td>
                <td>Rp. <?= number_format($row->harga, 0, ',', '.') ?></td>
                <td><?= number_format($row->jumlah, 0, ',', '.') ?></td>
                <td>Rp. <?= number_format($subtotal, 0, ',', '.') ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
