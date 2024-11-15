<html>
<head>
    <meta charset="utf-8">
    <meta name="keywords" content="Лабораторна робота, MySQL, робота з базою даних">
    <meta name="description" content="Лабораторна робота. Робота з базою даних">
    <title>Таблиця Brands</title>
    <?php include 'stylessearch.php'; ?>
</head>
<body>
    <h1>Пошук бренду</h1>

    <form method="POST" action="">
        <input type="text" name="search_brand" placeholder="Частина назви бренду">
        <input type="submit" value="Пошук бренду">
    </form>

    <div class="result">
        <?php
        include "databaseConnect.php";

        if (isset($_POST['search_brand']) && !empty($_POST['search_brand'])) {
            $search = "%" . $_POST['search_brand'] . "%";
            $stmt = $pdo->prepare("SELECT brand_id, name, description FROM brands WHERE name LIKE :search OR description LIKE :search");
            $stmt->bindParam(':search', $search);
            $stmt->execute();
        
            $count = $stmt->rowCount();
        
            if ($count > 0) {
                echo "<h3>Результати пошуку:</h3>";
                echo "<table>";
                echo "<tr><th>ID</th><th>Назва</th><th>Опис</th></tr>";
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['brand_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['description']) . "</td>";
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
        <li><a href="showBrands.php">Таблиця Brands</a></li>
        <li><a href="index.html">На головну</a></li>
    </ul>
</body>

</html>
