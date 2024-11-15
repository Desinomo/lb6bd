<?php
include "databaseConnect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $brand_id = $_POST['update_id'];
    $name = $_POST['update_name'];
    $description = $_POST['update_description'];
    $founded_date = $_POST['update_founded_date'];

    // Перевіряємо, чи існує бренд із таким ID
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM brands WHERE brand_id = :brand_id");
    $stmt->bindParam(':brand_id', $brand_id, PDO::PARAM_INT);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        // Оновлення даних бренду
        $stmt = $pdo->prepare(
            "UPDATE brands 
            SET name = :name, description = :description, founded_date = :founded_date 
            WHERE brand_id = :brand_id"
        );
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':founded_date', $founded_date);
        $stmt->bindParam(':brand_id', $brand_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "<div class='message success'>Бренд успішно оновлено!</div>";
        } else {
            echo "<div class='message error'>Помилка оновлення бренду.</div>";
        }
    } else {
        echo "<div class='message error'>Бренд із таким ID не знайдено.</div>";
    }
}
?>

<html>
<head>
    <meta charset="utf-8">
    <title>Оновлення брендів</title>
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
        input[type="text"], input[type="date"] {
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
    <h1>Оновлення брендів</h1>
    <form method="POST" action="updateBrands.php">
        <input type="text" name="update_id" placeholder="ID бренду" required>
        <input type="text" name="update_name" placeholder="Назва бренду" required>
        <input type="text" name="update_description" placeholder="Опис бренду" required>
        <input type="date" name="update_founded_date" placeholder="Дата заснування" required>
        <input type="submit" value="Оновити бренд">
    </form>
    <h2 style="text-align: center;">Список брендів</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Назва</th>
            <th>Опис</th>
            <th>Дата заснування</th>
        </tr>
        <?php
        $stmt = $pdo->query("SELECT brand_id, name, description, founded_date FROM brands");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['brand_id']) . "</td>
                    <td>" . htmlspecialchars($row['name']) . "</td>
                    <td>" . htmlspecialchars($row['description']) . "</td>
                    <td>" . htmlspecialchars($row['founded_date']) . "</td>
                  </tr>";
        }
        ?>
    </table>
    <ul>
        <li><a href="showBrands.php">Показати таблицю брендів</a></li>
        <li><a href="index.html">На головну</a></li>
    </ul>
</body>
</html>
