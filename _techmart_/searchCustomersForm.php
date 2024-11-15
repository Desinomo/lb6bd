<html>

<head>
    <meta charset="utf-8">
    <meta name="keywords" content="Лабораторна робота, MySQL, робота з базою даних">
    <meta name="description" content="Лабораторна робота. Робота з базою даних">
    <title>Пошук клієнта</title>
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
            margin: 20px 0;
        }

        input[type="text"] {
            width: 60%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .result {
            text-align: center;
            margin-top: 20px;
            font-size: 18px;
        }

        .result p {
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

    p {
        text-align: center;
        color: #555;
    }
    </style>
</head>

<body>
    <h1>Пошук клієнта</h1>

    <form method="POST" action="">
        <input type="text" name="search_customer" placeholder="Частина імені клієнта">
        <input type="submit" value="Пошук клієнта">
    </form>

    <div class="result">
        <?php
        include "databaseConnect.php";

        if (isset($_POST['search_customer']) && !empty($_POST['search_customer'])) {
            $search = "%" . $_POST['search_customer'] . "%";
            $stmt = $pdo->prepare("SELECT customer_id, first_name, last_name, email FROM customers WHERE first_name LIKE :search OR last_name LIKE :search OR email LIKE :search");
            $stmt->bindParam(':search', $search);
            $stmt->execute();
        
            $count = $stmt->rowCount();
        
            if ($count > 0) {
                // Виводимо результати запиту
                echo "<h3>Результати пошуку:</h3>";
                echo "<table>";
                echo "<tr><th>ID</th><th>Ім'я</th><th>Прізвище</th><th>Email</th></tr>";
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['customer_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['first_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['last_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>Немає результатів для вашого запиту.</p>";
            }
        }
        
        ?>
    </div>

    <ul>
        <li><a href="showCustomers.php">Таблиця Customers</a></li>
        <li><a href="showGroups.php">Таблиця Groups</a></li>
        <li><a href="showCurators.php">Таблиця Curators</a></li>
        <li><a href="index.html">На головну</a></li>
    </ul>
</body>

</html>
