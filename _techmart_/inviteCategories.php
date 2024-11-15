<html>
<head>
    <meta charset="utf-8">
    <meta name="keywords" content="Лабораторна робота, MySQL, робота з базою даних">
    <meta name="description" content="Лабораторна робота. Робота з базою даних">
    <title>Вставка даних у таблицю Categories</title>
    <?php include 'stylesinvite.php'; ?>
</head>
<body>

    <h1>Вставка даних у таблицю Categories</h1>

    <form method="POST" action="">
        <input type="text" name="insert_category_name" placeholder="Category Name" required>
        <input type="submit" name="insert" value="Вставити категорію">
    </form>

    <?php
    if (isset($_POST['insert'])) {
        include "databaseConnect.php";

        $category_name = $_POST['insert_category_name'];

        // SQL запит для вставки даних у таблицю categories
        $stmt = $pdo->prepare("INSERT INTO categories (category_name) VALUES (:category_name)");
        $stmt->bindParam(':category_name', $category_name);

        if ($stmt->execute()) {
            echo "<div class='message success-message'><p>Категорія додана успішно!</p></div>";
        } else {
            echo "<div class='message error-message'><p>Помилка додавання категорії.</p></div>";
        }
    }
    ?>

    <ul>
        <li><a href="showCategories.php">Показати таблицю категорій</a></li>
        <li><a href="index.html">На головну</a></li>
    </ul>

</body>
</html>
