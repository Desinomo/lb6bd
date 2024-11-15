<html>
<head>
    <meta charset="utf-8">
    <meta name="keywords" content="Лабораторна робота, MySQL, робота з базою даних">
    <meta name="description" content="Лабораторна робота. Робота з базою даних">
    <title>Таблиця Orders</title>
    <link rel="stylesheet" href="style.css">
    <?php include 'styles.php'; ?>
</head>
<body>
    <h1>Таблиця Orders</h1>

    <?php
    include "databaseConnect.php";

    try {
        $stmt = $pdo->query("SELECT * FROM orders");
        printf("<h3>Список замовлень:</h3>");
        printf("<table><tr><th>ID замовлення</th><th>ID клієнта</th><th>Дата</th><th>Сума</th></tr>");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            printf("<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>", $row['order_id'], $row['customer_id'], $row['date'], $row['total_price']);
        }
        printf("</table>");
    } catch (PDOException $e) {
        die("Помилка запиту: " . $e->getMessage());
    }
    ?>

    <ul>
        <li><a href="searchOrders.php">Пошук рядка</a></li>
        <li><a href="inviteOrders.php">Вставити рядок</a></li>
        <li><a href="updateOrders.php">Змінити рядок</a></li>
        <li><a href="deleteOrders.php">Видалити рядок</a></li>
        <li><a href="zapit.php">К-ість замовлень</a></li>
        <li><a href="index.html">На головну</a></li>
    </ul>
</body>
</html>
