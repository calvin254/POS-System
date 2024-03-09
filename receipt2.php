<?php 
include 'admin_class.php';
include 'db_connect.php';
$order = $conn->query("SELECT * FROM orders where id = {$_GET['id']}");
foreach($order->fetch_array() as $k => $v){
	$$k= $v;
}
$items = $conn->query("SELECT o.*, p.name, p.price AS product_price, c.name AS category_name, r.ref_no
                       FROM order_items o 
                       INNER JOIN products p ON p.id = o.product_id 
                       INNER JOIN categories c ON c.id = p.category_id
                       INNER JOIN orders r ON r.id = o.order_id
                       WHERE o.order_id = $id 
                       ORDER BY o.order_id = $id");
$newitems = $conn->query("SELECT * FROM orders where id = {$_GET['id']}");
$fetchitems = $newitems->fetch_assoc();

?>


<style>
     body {
        font-family: 'Arial', sans-serif;
        background-color: #f7f7f7;
        padding: 20px;
        text-align: center;
    }

    .receipt-container {
        max-width: 600px;
        margin: 0 auto;
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        page-break-before: auto; /* For the first container */
    }

    .receipt-container + .receipt-container {
        page-break-before: always; /* For subsequent containers */
    }

    .receipt-header {
        margin-bottom: 20px;
    }

    .receipt-header hr {
        border: 1px solid #333;
        margin: 5px 0;
    }

    .receipt-title {
        font-size: 24px;
        font-weight: bold;
    }

    .receipt-info {
        font-size: 14px;
        margin-bottom: 10px;
    }

    .order-list {
        margin-top: 20px;
    }

    table.order-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    table.order-table th, table.order-table td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: left;
    }

    .total-section {
        margin-top: 20px;
    }

    .total-table {
        width: 100%;
        margin-top: 10px;
    }

    .total-table td {
        padding: 10px;
        text-align: left;
    }

    .receipt-footer {
        margin-top: 20px;
    }

    .order-no {
        font-size: 18px;
        font-weight: bold;
    }

	.totals-section {
        margin-top: 20px;
        padding: 20px;
        background-color: #f5f5f5;
        border-radius: 10px;
    }

    .totals-table {
        width: 100%;
        margin-top: 10px;
    }

    .totals-table td {
        padding: 10px;
        text-align: left;
    }

    .totals-label {
        font-weight: bold;
    }
</style>

<div class="receipt-container">
    
    <div class="receipt-body">
        
            <?php
$categoryItems = array();

while ($row = $items->fetch_assoc()) {
    $category = $row['category_name'];
    if (!isset($categoryItems[$category])) {
        $categoryItems[$category] = array();
    }

    $categoryItems[$category][] = $row;
}

foreach ($categoryItems as $category => $items) {
    // Print the header for each category ticket
    echo "<div class='receipt-container'>";
    echo "<div class='receipt-header'>";
    echo "<h1>Oldies Lounge</h1>";
    echo "<h2 style='font-size: 20px;'>MUTHURE</h2>";
    echo "<h2 style='font-size: 10px;'>Ticket</h2>";
	
    echo "<p class='order-no'>Served By: {$_SESSION['login_name']}</p>";
    echo "<p>Order Number: {$fetchitems['ref_no']}</p>";
    echo "</div>";

    // Print the category header
    echo "<div class='category-ticket'>";
    echo "<h3>{$category}</h3>";

    // Print the order items for the current category
    echo "<table class='order-table'>";
    echo "<thead><tr><th>QTY</th><th>Order</th><th class='text-right'>Amount</th></tr></thead>";
    echo "<tbody>";
    foreach ($items as $item) {
        echo "<tr>";
        echo "<td>{$item['qty']}</td>";
        echo "<td><p>{$item['name']}</p>";
        if ($item['qty'] > 0) {
            echo "<small>(" . number_format($item['product_price'], 2) . ")</small>";
        }
        echo "</td>";
        echo "<td class='text-right'>" . number_format($item['amount'], 2) . "</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";

    // Print the category total
    $categoryTotal = array_sum(array_column($items, 'amount'));
    echo "<p>Total Amount for {$category}: <b>" . number_format($categoryTotal, 2) . "</b></p>";

    echo "</div>";

    // Print the footer for each category ticket
    echo "<div class='receipt-footer'>";
    echo "<p class='order-no'>We value You</p>";
    echo "</div>";

    echo "</div>"; // Close the receipt-container for each category ticket
}
?>
               
        </div>

   
</div>