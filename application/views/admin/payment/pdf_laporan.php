<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .report-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .report-header h2 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }
        .report-header p {
            margin: 5px 0;
            font-size: 14px;
            color: #666;
        }
        .report-header hr {
            border: 1px solid #333;
            margin: 20px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="report-header">
        <h2>HAIR POMADE PKU</h2>
        <h2>Laporan Penjualan</h2>
        <p><?= isset($start_date) ? $start_date : '' ?> sampai <?= isset($end_date) ? $end_date : '' ?></p>
        <hr>
    </div>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Name</th>
                <th>Alamat</th>
                <th>City</th>
                <th>Mobile Phone</th>
                <th>Email</th>
                <th>Transaction Time</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($invoice)) : ?>
                <?php foreach ($invoice as $inv) : ?>
                    <tr>
                        <td><?= $inv->order_id ?></td>
                        <td><?= $inv->name ?></td>
                        <td><?= $inv->alamat ?></td>
                        <td><?= $inv->city ?></td>
                        <td><?= $inv->mobile_phone ?></td>
                        <td><?= $inv->email ?></td>
                        <td><?= $inv->transaction_time ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="7" class="text-center">No data available in table</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
