<html>
<head>
    <meta charset="utf-8">
    <meta name="keywords" content="Лабораторна робота, MySQL, робота з базою даних">
    <meta name="description" content="Лабораторна робота. Робота з базою даних">
    <title>Вставка даних у таблицю Products</title>
    <?php include 'stylesinvite.php'; ?>
</head>
<body>

    <h1>Вставка даних у таблицю Products</h1>

    <form method="POST" action="">
        <input type="text" name="insert_name" placeholder="Product Name" required>
        <input type="text" name="insert_price" placeholder="Price" required>
        <input type="text" name="insert_category_id" placeholder="Category ID" required>
        <input type="text" name="insert_brand_id" placeholder="Brand ID" required>
        <input type="submit" name="insert" value="Вставити продукт">
    </form>

    <?php
    if (isset($_POST['insert'])) {
        include "databaseConnect.php";

        $name = $_POST['insert_name'];
        $price = $_POST['insert_price'];
        $category_id = $_POST['insert_category_id'];
        $brand_id = $_POST['insert_brand_id'];

        $stmt = $pdo->prepare("INSERT INTO products (name, price, category_id, brand_id) VALUES (:name, :price, :category_id, :brand_id)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':brand_id', $brand_id);

        if ($stmt->execute()) {
            echo "<div class='message success-message'><p>Продукт доданий успішно!</p></div>";
        } else {
            echo "<div class='message error-message'><p>Помилка додавання продукту.</p></div>";
        }
    }
    ?>

    <ul>
        <li><a href="showProducts.php">Показати таблицю продуктів</a></li>
        <li><a href="index.html">На головну</a></li>
    </ul>

</body>
</html>
