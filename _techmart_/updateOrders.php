<?php
include "databaseConnect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['update_id'];
    $customer_id = $_POST['update_customer_id'];
    $date = $_POST['update_date'];
    $total_price = $_POST['update_total_price'];

    // Перевіряємо, чи існує замовлення з таким ID
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM orders WHERE order_id = :order_id");
    $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        // Оновлення даних замовлення
        $stmt = $pdo->prepare(
            "UPDATE orders 
            SET customer_id = :customer_id, date = :date, total_price = :total_price 
            WHERE order_id = :order_id"
        );
        $stmt->bindParam(':customer_id', $customer_id, PDO::PARAM_INT);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':total_price', $total_price, PDO::PARAM_STR);
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "<div class='message success'>Замовлення успішно оновлено!</div>";
        } else {
            echo "<div class='message error'>Помилка оновлення замовлення.</div>";
        }
    } else {
        echo "<div class='message error'>Замовлення з таким ID не знайдено.</div>";
    }
}
?>

<html>
<head>
    <meta charset="utf-8">
    <title>Оновлення замовлень</title>
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
        input[type="text"], input[type="date"], input[type="number"] {
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
    <h1>Оновлення замовлень</h1>
    <form method="POST" action="updateOrders.php">
        <input type="text" name="update_id" placeholder="ID замовлення" required>
        <input type="text" name="update_customer_id" placeholder="ID клієнта" required>
        <input type="date" name="update_date" placeholder="Дата замовлення" required>
        <input type="number" step="0.01" name="update_total_price" placeholder="Загальна сума" required>
        <input type="submit" value="Оновити замовлення">
    </form>
    <h2 style="text-align: center;">Список замовлень</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>ID Клієнта</th>
            <th>Дата</th>
            <th>Сума</th>
        </tr>
        <?php
        $stmt = $pdo->query("SELECT order_id, customer_id, date, total_price FROM orders");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['order_id']) . "</td>
                    <td>" . htmlspecialchars($row['customer_id']) . "</td>
                    <td>" . htmlspecialchars($row['date']) . "</td>
                    <td>" . htmlspecialchars($row['total_price']) . "</td>
                  </tr>";
        }
        ?>
    </table>
    <ul>
        <li><a href="showOrders.php">Показати таблицю замовлень</a></li>
        <li><a href="index.html">На головну</a></li>
    </ul>
</body>
</html>
