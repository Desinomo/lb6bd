<html>

<head>
    <meta charset="utf-8">
    <meta name="keywords" content="Лабораторна робота, MySQL, робота з базою даних">
    <meta name="description" content="Лабораторна робота. Робота з базою даних">
    <title>Таблиця Customers</title>
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

        h3 {
            text-align: center;
            color: #555;
        }

        table {
            margin: 20px auto;
            border-collapse: collapse;
            width: 80%;
            background: #fff;
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border: 1px solid #ddd;
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
            display: inline;
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
        }

        a:hover {
            background-color: #4CAF50;
            color: #fff;
        }
    </style>
</head>

<body>
    <h1>Таблиця Customers</h1>

    <?php
    include "databaseConnect.php";

    try {
        $stmt = $pdo->query("SELECT * FROM customers");
        printf("<h3>Список клієнтів:</h3>");
        printf("<table><tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Email</th></tr>");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            printf("<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>", $row['customer_id'], $row['first_name'], $row['last_name'], $row['email']);
        };
        printf("</table>");
    } catch (PDOException $e) {
        die("Помилка запиту: " . $e->getMessage());
    }
    ?>

    <ul>
        <li><a href="searchCustomersForm.php">Пошук клієнта</a></li>
        <li><a href="insertIntoCustomers.php">Вставити рядок</a></li>
        <li><a href="updateCustomer.php">Змінити рядок</a></li>
        <li><a href="deleteFromCustomers.php">Видалити рядок</a></li>
        <li><a href="showCustomersOrdersDetails.php">Клієнт - Замовлення - Деталі</a></li>
        <li><a href="index.html">На головну</a></li>
    </ul>
</body>

</html>
