<html>
<head>
    <meta charset="utf-8">
    <meta name="keywords" content="Лабораторна робота, MySQL, робота з базою даних">
    <meta name="description" content="Лабораторна робота. Робота з базою даних">
    <title>Таблиця Order Details</title>
    <?php include 'stylessearch.php'; ?>
</head>
<body>
    <h1>Пошук деталей замовлення</h1>

    <form method="POST" action="">
        <input type="text" name="search_order_details" placeholder="Частина інформації про деталі замовлення">
        <input type="submit" value="Пошук деталей">
    </form>

    <div class="result">
        <?php
        include "databaseConnect.php";

        if (isset($_POST['search_order_details']) && !empty($_POST['search_order_details'])) {
            $search = "%" . $_POST['search_order_details'] . "%";
            $stmt = $pdo->prepare("SELECT order_detail_id, order_id, product_id, quantity FROM order_details WHERE order_detail_id LIKE :search OR order_id LIKE :search");
            $stmt->bindParam(':search', $search);
            $stmt->execute();
        
            $count = $stmt->rowCount();
        
            if ($count > 0) {
                echo "<h3>Результати пошуку:</h3>";
                echo "<table>";
                echo "<tr><th>ID</th><th>ID замовлення</th><th>ID продукту</th><th>Кількість</th></tr>";
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['order_detail_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['order_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['product_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['quantity']) . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>Немає результатів для вашого запиту.</p>";
            }
        }
        ?>
    </div>

    <ul>
        <li><a href="showOrderDetails.php">Таблиця Order Details</a></li>
        <li><a href="index.html">На головну</a></li>
    </ul>
</body>

</html>
