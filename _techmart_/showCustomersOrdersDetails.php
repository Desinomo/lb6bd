<html>

<head>
    <meta charset="utf-8">
    <meta name="keywords" content="Лабораторна робота, MySQL, з'єднання з базою даних">
    <meta name="description" content="Лабораторна робота. З'єднання з базою даних">
    <title>Список клієнтів і замовлень</title>
    <link rel="stylesheet" href="style.css">
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
            text-align: center; /* Додано для вирівнювання тексту всередині */
        }

        a:hover {
            background-color: #4CAF50;
            color: #fff;
        }

        /* Спеціальний стиль для кнопки "Таблиця Деталей Замовлень" */
        .order-details-button {
            width: 250px; /* Збільшена ширина */
        }

        /* Відступи для таблиць */
        table {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <?php

    include "databaseConnect.php";

    try {
        // Запит для отримання імені клієнта (об'єднуємо first_name і last_name), замовлень, деталей замовлень та назви продукту
        $stmt = $pdo->query("
        SELECT 
            CONCAT(c.first_name, ' ', c.last_name) AS customer_name, 
            o.order_id, 
            o.date AS order_date, 
            o.total_price,
            p.name, 
            od.quantity
        FROM customers c
        LEFT JOIN orders o ON c.customer_id = o.customer_id
        LEFT JOIN order_details od ON o.order_id = od.order_id
        LEFT JOIN products p ON od.product_id = p.product_id
        ORDER BY customer_name, o.date
        ");

        // Виведення заголовку таблиці
        echo "<h1>Список клієнтів, їх замовлень і деталей замовлень</h1><br>";
        echo "<table>
                <tr><th>Клієнт</th><th>Номер замовлення</th><th>Дата замовлення</th><th>Ціна</th><th>Продукт</th><th>Кількість</th></tr>";

        // Виведення даних клієнтів і замовлень
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['customer_name']) . "</td>
                    <td>" . htmlspecialchars($row['order_id']) . "</td>
                    <td>" . htmlspecialchars($row['order_date']) . "</td>
                    <td>" . htmlspecialchars($row['total_price']) . "</td>
                    <td>" . htmlspecialchars($row['name']) . "</td>
                    <td>" . htmlspecialchars($row['quantity']) . "</td>
                  </tr>";
        }

        echo "</table>";
    } catch (PDOException $e) {
        die("Помилка запиту: " . $e->getMessage());
    }

    ?>

    <br><br><br>

    <ul>
        <li><a href="showCustomers.php">Таблиця Клієнтів</a><br></li>
        <li><a href="showOrders.php">Таблиця Замовлень</a><br></li>
        <li><a href="showOrderDetails.php" class="order-details-button">Таблиця Деталей Замовлень</a><br></li>
        <li><a href="index.html">На головну</a><br></li>
    </ul>

</body>

</html>
