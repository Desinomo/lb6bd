<html>
<head>
    <meta charset="utf-8">
    <meta name="keywords" content="Лабораторна робота, MySQL, робота з базою даних">
    <meta name="description" content="Лабораторна робота. Робота з базою даних">
    <title>Інформація про замовлення та продукти</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    line-height: 1.6;
    margin: 0;
    padding: 0;
    background-color: #f4f4f9;
    color: #333;
}

h1 {
    text-align: center;
    color: #4CAF50;
    margin-top: 20px;
}

table {
    margin: 20px auto;
    border-collapse: collapse;
    width: 90%;
    max-width: 1200px;
    background: #fff;
    border: 1px solid #ddd;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

th, td {
    padding: 12px 15px;
    text-align: left;
    border: 1px solid #ddd;
}

th {
    background-color: #4CAF50;
    color: white;
}

tr:nth-child(even) {
    background-color: #f9f9f9;
}

tr:hover {
    background-color: #f1f1f1;
}

ul {
    list-style: none;
    padding: 0;
    text-align: center;
    margin: 20px 0;
}

li {
    display: inline-block;
    margin: 0 10px;
}

a {
    text-decoration: none;
    color: #4CAF50;
    font-weight: bold;
    border: 1px solid #4CAF50;
    padding: 8px 12px;
    border-radius: 4px;
    transition: all 0.3s ease;
    display: inline-block;
    width: 200px;
    text-align: center;
}

a:hover {
    background-color: #4CAF50;
    color: #fff;
}

.message {
    padding: 10px;
    margin: 15px;
    border-radius: 5px;
}

.success-message {
    background-color: #d4edda;
    color: #155724;
}

.error-message {
    background-color: #f8d7da;
    color: #721c24;
}

form {
    width: 80%;
    max-width: 600px;
    margin: 20px auto;
    padding: 20px;
    background-color: #fff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 5px;
}

form input[type="text"],
form input[type="date"] {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 16px;
}

form input[type="submit"] {
    width: 100%;
    padding: 12px;
    background-color: #4CAF50;
    border: none;
    color: white;
    font-size: 16px;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

form input[type="submit"]:hover {
    background-color: #45a049;
}

ul {
    list-style: none;
    padding: 0;
    text-align: center;
    margin: 20px 0;
}

ul li {
    display: inline-block;
    margin: 0 10px;
}

    </style>
</head>
<body>

    <h1>Інформація про замовлення та продукти</h1>

    <?php
    include "databaseConnect.php";

    try {
        // Запит для отримання інформації про клієнтів, замовлені продукти та їх кількість
        $stmt = $pdo->query("
        SELECT 
            CONCAT(c.first_name, ' ', c.last_name) AS customer_name, 
            o.order_id, 
            p.name AS product_name, 
            od.quantity 
        FROM order_details od
        LEFT JOIN orders o ON od.order_id = o.order_id
        LEFT JOIN customers c ON o.customer_id = c.customer_id
        LEFT JOIN products p ON od.product_id = p.product_id
        ORDER BY customer_name, o.order_id
        ");

        // Виведення заголовку таблиці
        echo "<table>
                <tr><th>Клієнт</th><th>Номер замовлення</th><th>Продукт</th><th>Кількість</th></tr>";

        // Виведення даних клієнтів і замовлень
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['customer_name']) . "</td>
                    <td>" . htmlspecialchars($row['order_id']) . "</td>
                    <td>" . htmlspecialchars($row['product_name']) . "</td>
                    <td>" . htmlspecialchars($row['quantity']) . "</td>
                  </tr>";
        }

        echo "</table>";
    } catch (PDOException $e) {
        die("Помилка запиту: " . $e->getMessage());
    }
    ?>

    <ul>
        <li><a href="showOrders.php">Таблиця Замовлень</a></li>
        <li><a href="showCustomers.php">Таблиця Клієнтів</a></li>
        <li><a href="index.html">На головну</a></li>
    </ul>

</body>
</html>
