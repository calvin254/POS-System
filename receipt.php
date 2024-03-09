<?php
include 'admin_class.php';
include 'db_connect.php';

$order = $conn->query("SELECT * FROM orders where id = {$_GET['id']}");
foreach ($order->fetch_array() as $k => $v) {
    $$k = $v;
}
$items = $conn->query("SELECT o.*,p.name FROM order_items o inner join products p on p.id = o.product_id where o.order_id = $id");
?>

<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f7f7f7;
        padding: 0; /* Remove padding */
        margin: 0; /* Remove margin */
        text-align: center;
    }

    .receipt-container {
        max-width: 320px; /* Adjusted for 80mm paper width */
        margin: 0 auto;
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .receipt-header {
        margin-bottom: 16px;
    }

    .receipt-title {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .totals-section {
        margin-top: 16px;
        padding: 10px;
        background-color: #f5f5f5;
        border-radius: 5px;
    }

    .totals-table {
        width: 100%;
        margin-top: 8px;
    }

    .totals-table td {
        padding: 8px;
        text-align: left;
    }

    .totals-label {
        font-weight: bold;
    }

    .order-list {
        margin-top: 16px;
    }

    table.order-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 8px;
    }

    table.order-table th,
    table.order-table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    .order-no {
        font-size: 14px;
        font-weight: bold;
        margin-top: 16px;
        margin-bottom: 0; /* Remove bottom margin */
    }
</style>

<div class="receipt-container">
    <div class="receipt-header">
        <h1>Oldies Lounge</h1>
        <h2 style="font-size: 14px;">MUTHURE</h2>
    </div>

    <div class="totals-section">
        <p>Date: <b><?php echo date("M d, Y", strtotime($date_created)) ?></b></p>
        <p>BUY GOODS</p>
        <p>TILL NO 8120020</p>
        <p>Served By <span><?php echo $_SESSION['login_name'] ?></span></p>
    </div>

    <div class="order-list">
        <p><b>Order List</b></p>
        <table class="order-table">
            <thead>
                <tr>
                    <th>QTY</th>
                    <th>Order</th>
                    <th class="text-right">Amount</th>
                </tr>
            </thead>

            <tbody>
                <?php while ($row = $items->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['qty'] ?></td>
                        <td>
                            <p><?php echo $row['name'] ?></p>
                            <?php if ($row['qty'] > 0): ?><small>(<?php echo number_format($row['price'], 2) ?>)</small> <?php endif; ?>
                        </td>
                        <td class="text-right"><?php echo number_format($row['amount'], 2) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <div class="totals-section">
        <table class="totals-table">
            <tbody>
                <tr>
                    <td class="totals-label">test2</td>
                    <td class="text-right"><?php echo number_format($total_amount, 2) ?></td>
                </tr>
                <tr>
                    <?php
                    $vat_percentage = 13.79;
                    ?>
                    <td class="totals-label">VAT (<?php echo $vat_percentage ?>%)</td>
                    <td class="text-right"><?php echo number_format($total_amount * ($vat_percentage / 100), 2) ?></td>
                </tr>
                <tr>
                    <td class="totals-label">Net Total</td>
                    <td class="text-right"><?php echo number_format($total_amount) ?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="receipt-footer">
        <p class="order-no">We value You</p>
    </div>
</div>
