<?php
include "databaseConnect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['update_id'];
    $name = $_POST['update_name'];
    $price = $_POST['update_price'];
    $category_id = $_POST['update_category_id'];
    $brand_id = $_POST['update_brand_id'];

    // Перевіряємо, чи існує продукт із таким ID
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM products WHERE product_id = :product_id");
    $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        $stmt = $pdo->prepare(
            "UPDATE products 
            SET name = :name, price = :price, category_id = :category_id, brand_id = :brand_id 
            WHERE product_id = :product_id"
        );
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':brand_id', $brand_id);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "<div class='message success'>Продукт успішно оновлено!</div>";
        } else {
            echo "<div class='message error'>Помилка оновлення продукту.</div>";
        }
    } else {
        echo "<div class='message error'>Продукт із таким ID не знайдено.</div>";
    }
}
?>

<html>
<head>
    <meta charset="utf-8">
    <title>Оновлення продуктів</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }
        h1 {
            text-align: center;
            color: #4CAF50;
            margin: 20px 0;
        }
        form {
            margin: 20px auto;
            padding: 20px;
            width: 90%;
            max-width: 500px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        input[type="text"],
        input[type="number"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .message {
            margin: 20px auto;
            padding: 10px;
            width: 90%;
            max-width: 500px;
            text-align: center;
            border-radius: 4px;
            font-weight: bold;
        }
        .success {
            background-color: #4CAF50;
            color: white;
        }
        .error {
            background-color: #f44336;
            color: white;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px 15px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
            text-align: center;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        td {
            text-align: center;
        }
        ul {
            list-style: none;
            text-align: center;
            padding: 0;
        }
        li {
            display: inline-block;
            margin: 0 10px;
        }
        a {
            text-decoration: none;
            color: #4CAF50;
            font-weight: bold;
            padding: 8px 12px;
            border: 1px solid #4CAF50;
            border-radius: 4px;
            transition: 0.3s;
        }
        a:hover {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>
    <h1>Оновлення продуктів</h1>
    <form method="POST" action="updateProducts.php">
        <input type="text" name="update_id" placeholder="ID продукту" required>
        <input type="text" name="update_name" placeholder="Назва продукту" required>
        <input type="number" name="update_price" placeholder="Ціна продукту" step="0.01" required>
        <input type="text" name="update_category_id" placeholder="ID категорії" required>
        <input type="text" name="update_brand_id" placeholder="ID бренду" required>
        <input type="submit" value="Оновити продукт">
    </form>
    <h2 style="text-align: center;">Список продуктів</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Назва</th>
            <th>Ціна</th>
            <th>ID Категорії</th>
            <th>ID Бренду</th>
        </tr>
        <?php
        $stmt = $pdo->query("SELECT product_id, name, price, category_id, brand_id FROM products");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['product_id']) . "</td>
                    <td>" . htmlspecialchars($row['name']) . "</td>
                    <td>" . htmlspecialchars($row['price']) . "</td>
                    <td>" . htmlspecialchars($row['category_id']) . "</td>
                    <td>" . htmlspecialchars($row['brand_id']) . "</td>
                  </tr>";
        }
        ?>
    </table>
    <ul>
        <li><a href="showProducts.php">Показати таблицю продуктів</a></li>
        <li><a href="index.html">На головну</a></li>
    </ul>
</body>
</html>