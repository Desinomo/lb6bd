<html>
<head>
    <meta charset="utf-8">
    <meta name="keywords" content="Лабораторна робота, MySQL, робота з базою даних">
    <meta name="description" content="Лабораторна робота. Робота з базою даних">
    <title>Таблиця Orders</title>
    <?php include 'stylessearch.php'; ?>
</head>
<body>
    <h1>Пошук замовлення</h1>

    <form method="POST" action="">
        <input type="text" name="search_order" placeholder="Частина ID замовлення чи клієнта">
        <input type="submit" value="Пошук замовлення">
    </form>

    <div class="result">
        <?php
        include "databaseConnect.php";

        if (isset($_POST['search_order']) && !empty($_POST['search_order'])) {
            $search = "%" . $_POST['search_order'] . "%";
            $stmt = $pdo->prepare("SELECT order_id, customer_id, date, total_price FROM orders WHERE order_id LIKE :search OR customer_id LIKE :search");
            $stmt->bindParam(':search', $search);
            $stmt->execute();
        
            $count = $stmt->rowCount();
        
            if ($count > 0) {
                echo "<h3>Результати пошуку:</h3>";
                echo "<table>";
                echo "<tr><th>ID замовлення</th><th>ID клієнта</th><th>Дата</th><th>Сума</th></tr>";
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['order_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['customer_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['date']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['total_price']) . "</td>";
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
        <li><a href="showOrders.php">Таблиця Orders</a></li>
        <li><a href="index.html">На головну</a></li>
    </ul>
</body>

</body>
</html>
