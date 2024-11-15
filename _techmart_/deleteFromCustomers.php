<?php
include "databaseConnect.php";

// Перевірка на наявність параметра 'delete_id'
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id']) && !empty($_POST['delete_id'])) {
    $id = $_POST['delete_id'];

    // Перевірка чи клієнт існує в базі
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM customers WHERE customer_id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        // Якщо клієнт є, то показуємо підтвердження видалення
        echo "
            <script>
                var confirmDelete = confirm('Ви дійсно хочете видалити клієнта і всі його замовлення?');
                if (confirmDelete) {
                    // Якщо користувач підтвердив, то видаляємо замовлення
                    window.location.href = 'deleteFromCustomers.php?confirm=true&delete_id=" . $id . "';
                } else {
                    window.location.href = 'showCustomers.php'; // Повертаємо на список клієнтів
                }
            </script>
        ";
    } else {
        echo "<div class='message error'>Клієнт не знайдений!</div>";
    }
}

if (isset($_GET['confirm']) && $_GET['confirm'] === 'true' && isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];

    try {
        // Починаємо транзакцію для забезпечення цілісності даних
        $pdo->beginTransaction();

        // Видалення деталей замовлення (order_details), пов'язаних з клієнтом
        $stmt = $pdo->prepare("DELETE FROM order_details WHERE order_id IN (SELECT order_id FROM orders WHERE customer_id = :id)");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // Видалення замовлень клієнта
        $stmt = $pdo->prepare("DELETE FROM orders WHERE customer_id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // Після видалення замовлень видаляємо самого клієнта
        $stmt = $pdo->prepare("DELETE FROM customers WHERE customer_id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // Фіксуємо транзакцію
        $pdo->commit();

        // Перенаправлення після успішного видалення
        header("Location: deleteFromCustomers.php?deleted=true");
        exit();
    } catch (PDOException $e) {
        // Якщо сталася помилка, скасовуємо транзакцію
        $pdo->rollBack();
        echo "<div class='message error'>Помилка видалення даних: " . $e->getMessage() . "</div>";
    }
} elseif (isset($_GET['deleted']) && $_GET['deleted'] === 'true') {
    // Повідомлення про успішне видалення
    echo "<div class='message success'>Клієнт і всі його замовлення були успішно видалені!</div>";
}

?>

<html>
<head>
    <meta charset="utf-8">
    <meta name="keywords" content="Лабораторна робота, MySQL, робота з базою даних">
    <meta name="description" content="Лабораторна робота. Робота з базою даних">
    <title>Видалення даних клієнта</title>
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

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            font-size: 16px;
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

    <h1>Видалення клієнта</h1>

    <form method="POST" action="deleteFromCustomers.php">
        <input type="text" name="delete_id" placeholder="ID клієнта для видалення" required>
        <input type="submit" value="Видалити клієнта">
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
        <li><a href="showCustomers.php">Таблиця Клієнтів</a></li>
        <li><a href="index.html">На головну</a></li>
    </ul>

</body>
</html>
