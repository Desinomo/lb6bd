<?php
include "databaseConnect.php";

// Check if 'delete_id' is provided in the POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id']) && !empty($_POST['delete_id'])) {
    $id = $_POST['delete_id'];

    // Check if the category exists in the database
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM categories WHERE category_id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        // If category exists, show confirmation prompt
        echo "
            <script>
                var confirmDelete = confirm('Ви дійсно хочете видалити категорію?');
                if (confirmDelete) {
                    window.location.href = 'deleteCategories.php?confirm=true&delete_id=" . $id . "';
                } else {
                    window.location.href = 'showCategories.php';
                }
            </script>
        ";
    } else {
        echo "<div class='message error'>Категорія не знайдена!</div>";
    }
}

if (isset($_GET['confirm']) && $_GET['confirm'] === 'true' && isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];

    try {
        $pdo->beginTransaction();

        $stmt = $pdo->prepare("DELETE FROM categories WHERE category_id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $pdo->commit();
        header("Location: deleteCategories.php?deleted=true");
        exit();
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo "<div class='message error'>Помилка видалення: " . $e->getMessage() . "</div>";
    }
} elseif (isset($_GET['deleted']) && $_GET['deleted'] === 'true') {
    echo "<div class='message success'>Категорія успішно видалена!</div>";
}
?>

<html>
<head>
    <meta charset="utf-8">
    <title>Видалення категорії</title>
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

    <h1>Видалення категорії</h1>

    <form method="POST" action="deleteCategories.php">
        <input type="text" name="delete_id" placeholder="ID категорії для видалення" required>
        <input type="submit" value="Видалити категорію">
    </form>

    <h3>Список категорій</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Назва</th>
        </tr>

        <?php
        // Output the list of categories
        $stmt = $pdo->query("SELECT category_id, category_name FROM categories");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['category_id']) . "</td>
                    <td>" . htmlspecialchars($row['category_name']) . "</td>
                  </tr>";
        }
        ?>
    </table>

    <ul>
        <li><a href="showCategories.php">Таблиця Категорій</a></li>
        <li><a href="index.html">На головну</a></li>
    </ul>

</body>
</html>
