<html>
<head>
    <meta charset="utf-8">
    <meta name="keywords" content="Лабораторна робота, MySQL, робота з базою даних">
    <meta name="description" content="Лабораторна робота. Робота з базою даних">
    <title>Вставка даних у таблицю Orders</title>
    <?php include 'stylesinvite.php'; ?>
</head>
<body>

    <h1>Вставка даних у таблицю Orders</h1>

    <form method="POST" action="">
        <input type="text" name="insert_customer_id" placeholder="Customer ID" required>
        <input type="date" name="insert_date" placeholder="Order Date" required>
        <input type="text" name="insert_price" placeholder="Total Price" required>
        <input type="submit" name="insert" value="Вставити замовлення">
    </form>

    <?php
    if (isset($_POST['insert'])) {
        include "databaseConnect.php";

        // Отримуємо значення з форми
        $customer_id = $_POST['insert_customer_id'];
        $date = $_POST['insert_date'];
        $total_price = $_POST['insert_price'];  // виправлено на insert_price

        // Перевіряємо, чи не порожнє поле total_price
        if (empty($total_price) || !is_numeric($total_price)) {
            echo "<div class='message error-message'><p>Будь ласка, введіть коректну ціну.</p></div>";
        } else {
            // Підготовка запиту до бази даних
            $stmt = $pdo->prepare("INSERT INTO orders (customer_id, date, total_price) VALUES (:customer_id, :date, :total_price)");
            $stmt->bindParam(':customer_id', $customer_id);
            $stmt->bindParam(':date', $date);
            $stmt->bindParam(':total_price', $total_price);

            // Виконання запиту
            if ($stmt->execute()) {
                echo "<div class='message success-message'><p>Замовлення додано успішно!</p></div>";
            } else {
                echo "<div class='message error-message'><p>Помилка додавання замовлення.</p></div>";
            }
        }
    }
    ?>

    <ul>
        <li><a href="showOrders.php">Показати таблицю замовлень</a></li>
        <li><a href="index.html">На головну</a></li>
    </ul>

</body>
</html>
