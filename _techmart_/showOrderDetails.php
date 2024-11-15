<html>
<head>
    <meta charset="utf-8">
    <meta name="keywords" content="Лабораторна робота, MySQL, робота з базою даних">
    <meta name="description" content="Лабораторна робота. Робота з базою даних">
    <title>Таблиця Order Details</title>
    <link rel="stylesheet" href="style.css">
    <?php include 'styles.php'; ?>
</head>
<body>
    <h1>Таблиця Order Details</h1>

    <?php
    include "databaseConnect.php";

    try {
        $stmt = $pdo->query("SELECT * FROM order_details");
        printf("<h3>Деталі замовлень:</h3>");
        printf("<table><tr><th>ID замовлення</th><th>ID продукту</th><th>Кількість</th></tr>");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            printf("<tr><td>%s</td><td>%s</td><td>%s</td></tr>", $row['order_id'], $row['product_id'], $row['quantity']);
        }
        printf("</table>");
    } catch (PDOException $e) {
        die("Помилка запиту: " . $e->getMessage());
    }
    ?>

    <ul>
        <li><a href="searchOrder_details.php">Пошук рядка</a></li>
        <li><a href="inviteOrdersdet.php">Вставити рядок</a></li>
        <li><a href="updateOrderDetails.php">Змінити рядок</a></li>
        <li><a href="deleteOrdersDetails.php">Видалити рядок</a></li>
        <li><a href="zapit2.php">Інфа про замовлення</a></li>
        <li><a href="index.html">На головну</a></li>
    </ul>
</body>
</html>
