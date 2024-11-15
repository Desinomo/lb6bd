<html>
<head>
    <meta charset="utf-8">
    <meta name="keywords" content="Лабораторна робота, MySQL, робота з базою даних">
    <meta name="description" content="Лабораторна робота. Робота з базою даних">
    <title>Таблиця Products</title>
    <link rel="stylesheet" href="style.css">
    <?php include 'styles.php'; ?>
</head>
<body>
    <h1>Таблиця Products</h1>

    <?php
    include "databaseConnect.php";

    try {
        $stmt = $pdo->query("SELECT * FROM products");
        printf("<h3>Список продуктів:</h3>");
        printf("<table><tr><th>ID продукту</th><th>Назва продукту</th><th>Ціна</th><th>Категорія</th><th>Бренд</th></tr>");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            printf("<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>", $row['product_id'], $row['name'], $row['price'], $row['category_id'], $row['brand_id']);
        }
        printf("</table>");
    } catch (PDOException $e) {
        die("Помилка запиту: " . $e->getMessage());
    }
    ?>

    <ul>
        <li><a href="searchProducts.php">Пошук рядка</a></li>
        <li><a href="inviteProducts.php">Вставити рядок</a></li>
        <li><a href="updateProducts.php">Змінити рядок</a></li>
        <li><a href="deleteProducts.php">Видалити рядок</a></li>
        <li><a href="index.html">На головну</a></li>
    </ul>
</body>
</html>
