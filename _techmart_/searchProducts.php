<html>
<head>
    <meta charset="utf-8">
    <meta name="keywords" content="Лабораторна робота, MySQL, робота з базою даних">
    <meta name="description" content="Лабораторна робота. Робота з базою даних">
    <title>Таблиця Products</title>
    <?php include 'stylessearch.php'; ?>
</head>
<body>
    <h1>Пошук продукту</h1>

    <form method="POST" action="">
        <input type="text" name="search_product" placeholder="Частина назви продукту">
        <input type="submit" value="Пошук продукту">
    </form>

    <div class="result">
        <?php
        include "databaseConnect.php";

        if (isset($_POST['search_product']) && !empty($_POST['search_product'])) {
            $search = "%" . $_POST['search_product'] . "%";
            $stmt = $pdo->prepare("SELECT product_id, name, price FROM products WHERE name LIKE :search");
            $stmt->bindParam(':search', $search);
            $stmt->execute();
        
            $count = $stmt->rowCount();
        
            if ($count > 0) {
                echo "<h3>Результати пошуку:</h3>";
                echo "<table>";
                echo "<tr><th>ID</th><th>Назва продукту</th><th>Ціна</th></tr>";
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['product_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['price']) . "</td>";
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
        <li><a href="showProducts.php">Таблиця Products</a></li>
        <li><a href="index.html">На головну</a></li>
    </ul>
</body>

</html>
