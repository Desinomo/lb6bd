<html>
<head>
    <meta charset="utf-8">
    <meta name="keywords" content="Лабораторна робота, MySQL, робота з базою даних">
    <meta name="description" content="Лабораторна робота. Робота з базою даних">
    <title>Таблиця Categories</title>
    <link rel="stylesheet" href="style.css">
    <?php include 'styles.php'; ?>
</head>
<body>
    <h1>Таблиця Categories</h1>

    <?php
    include "databaseConnect.php";

    try {
        $stmt = $pdo->query("SELECT * FROM categories");
        printf("<h3>Список категорій:</h3>");
        printf("<table><tr><th>ID</th><th>Назва категорії</th></tr>");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            printf("<tr><td>%s</td><td>%s</td></tr>", $row['category_id'], $row['category_name']);
        }
        printf("</table>");
    } catch (PDOException $e) {
        die("Помилка запиту: " . $e->getMessage());
    }
    ?>

    <ul>
        <li><a href="searchCatrgories.php">Пошук рядка</a></li>
        <li><a href="inviteCategories.php">Вставити рядок</a></li>
        <li><a href="updateCategories.php">Змінити рядок</a></li>
        <li><a href="deleteCategories.php">Видалити рядок</a></li>
        <li><a href="index.html">На головну</a></li>
    </ul>
</body>
</html>
