<html>
<head>
    <meta charset="utf-8">
    <meta name="keywords" content="Лабораторна робота, MySQL, робота з базою даних">
    <meta name="description" content="Лабораторна робота. Робота з базою даних">
    <title>Таблиця Brands</title>
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
            word-wrap: break-word;
            max-width: 200px;
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

        /* Опис брендів з вирівнюванням */
        .description {
            max-width: 300px; /* Максимальна ширина опису */
            overflow: hidden;
            text-overflow: ellipsis; /* Обрізає довгий текст */
            white-space: nowrap;
        }

    </style>
</head>
<body>
    <h1>Таблиця Brands</h1>

    <?php
    include "databaseConnect.php";

    try {
        $stmt = $pdo->query("SELECT * FROM brands");
        printf("<h3>Список брендів:</h3>");
        printf("<table><tr><th>ID</th><th>Назва</th><th>Опис</th><th>Дата заснування</th></tr>");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Додаємо опис бренду
            $description = $row['description'] ? $row['description'] : "Немає опису";
            printf("<tr><td>%s</td><td>%s</td><td class='description'>%s</td><td>%s</td></tr>", $row['brand_id'], $row['name'], $description, $row['founded_date']);
        }
        printf("</table>");
    } catch (PDOException $e) {
        die("Помилка запиту: " . $e->getMessage());
    }
    ?>

    <ul>
        <li><a href="searchBrands.php">Пошук рядка</a></li>
        <li><a href="inviteBrands.php">Вставити рядок</a></li>
        <li><a href="updateBrands.php">Змінити рядок</a></li>
        <li><a href="deleteBrands.php">Видалити рядок</a></li>
        <li><a href="index.html">На головну</a></li>
    </ul>
</body>
</html>
