<?php
include "databaseConnect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_id = $_POST['update_id'];
    $first_name = $_POST['update_first_name'];
    $last_name = $_POST['update_last_name'];
    $email = $_POST['update_email'];
    
    // Перевіряємо чи існує клієнт з таким ID
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM customers WHERE customer_id = :customer_id");
    $stmt->bindParam(':customer_id', $customer_id);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        // Оновлення даних клієнта в базі
        $stmt = $pdo->prepare("UPDATE customers SET first_name=:first_name, last_name=:last_name, email=:email WHERE customer_id=:customer_id");
        $stmt->bindParam(':customer_id', $customer_id);
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':email', $email);

        if ($stmt->execute()) {
            echo "<div class='message success'>Клієнт оновлений успішно!</div>";
        } else {
            echo "<div class='message error'>Помилка оновлення клієнта.</div>";
        }
    } else {
        echo "<div class='message error'>Клієнт з таким ID не знайдений.</div>";
    }
}
?>


<html>
<head>
    <meta charset="utf-8">
    <meta name="keywords" content="Лабораторна робота, MySQL, робота з базою даних">
    <meta name="description" content="Лабораторна робота. Робота з базою даних">
    <title>Оновлення даних клієнта</title>
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

        form {
            text-align: center;
            margin: 20px auto;
            width: 60%;
            max-width: 500px;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        input[type="submit"] {
            display: inline-block; /* Кнопка в рядку, а не як блочний елемент */
            margin-top: 20px; /* Додає відступ зверху */
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            font-size: 16px;
            width: auto; /* Визначає ширину кнопки, щоб вона не займала всю ширину форми */
            text-align: center; /* Центрує текст кнопки */
            margin-left: auto; /* Центрує кнопку зліва */
            margin-right: auto; /* Центрує кнопку справа */
        }   

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .message {
            text-align: center;
            margin: 20px;
            padding: 10px;
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

        th {
            background-color: #4CAF50;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        h3 {
            text-align: center;
            color: #555;
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

    <h1>Оновлення даних клієнта</h1>

    <form method="POST" action="updateCustomer.php">
        <input type="text" name="update_id" placeholder="ID клієнта" required>
        <input type="text" name="update_first_name" placeholder="Ім'я клієнта" required>
        <input type="text" name="update_last_name" placeholder="Прізвище клієнта" required>
        <input type="email" name="update_email" placeholder="Email клієнта" required>
        <input type="submit" value="Оновити клієнта">
    </form>

    <h3>Список клієнтів</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Ім'я</th>
            <th>Прізвище</th>
            <th>Email</th>
        </tr>

        <?php
        // Виведення списку клієнтів
        $stmt = $pdo->query("SELECT customer_id, first_name, last_name, email FROM customers");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['customer_id']) . "</td>
                    <td>" . htmlspecialchars($row['first_name']) . "</td>
                    <td>" . htmlspecialchars($row['last_name']) . "</td>
                    <td>" . htmlspecialchars($row['email']) . "</td>
                  </tr>";
        }
        ?>
    </table>

    <ul>
        <li><a href="showCustomers.php">Таблиця Customers</a></li>
        <li><a href="index.html">На головну</a></li>
    </ul>

</body>
</html>
