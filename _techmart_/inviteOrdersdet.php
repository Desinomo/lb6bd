<html>
<head>
    <meta charset="utf-8">
    <meta name="keywords" content="Лабораторна робота, MySQL, робота з базою даних">
    <meta name="description" content="Лабораторна робота. Робота з базою даних">
    <title>Вставка даних у таблицю Order Details</title>
    <?php include 'stylesinvite.php'; ?>
</head>
<body>

    <h1>Вставка даних у таблицю Order Details</h1>

    <form method="POST" action="">
        <input type="text" name="insert_order_id" placeholder="Order ID" required>
        <input type="text" name="insert_product_id" placeholder="Product ID" required>
        <input type="text" name="insert_quantity" placeholder="Quantity" required>
        <input type="submit" name="insert" value="Вставити деталі замовлення">
    </form>

    <?php
    if (isset($_POST['insert'])) {
        include "databaseConnect.php";

        $order_id = $_POST['insert_order_id'];
        $product_id = $_POST['insert_product_id'];
        $quantity = $_POST['insert_quantity'];

        // SQL запит для вставки даних у таблицю order_details
        $stmt = $pdo->prepare("INSERT INTO order_details (order_id, product_id, quantity) VALUES (:order_id, :product_id, :quantity)");
        $stmt->bindParam(':order_id', $order_id);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->bindParam(':quantity', $quantity);

        if ($stmt->execute()) {
            echo "<div class='message success-message'><p>Деталі замовлення додано успішно!</p></div>";
        } else {
            echo "<div class='message error-message'><p>Помилка додавання деталей замовлення.</p></div>";
        }
    }
    ?>

    <ul>
        <li><a href="showOrderDetails.php">Показати таблицю деталей замовлення</a></li>
        <li><a href="index.html">На головну</a></li>
    </ul>

</body>
</html>
