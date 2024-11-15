<html>
<head>
    <meta charset="utf-8">
    <meta name="keywords" content="Лабораторна робота, MySQL, робота з базою даних">
    <meta name="description" content="Лабораторна робота. Робота з базою даних">
    <title>Таблиця Categories</title>
    <?php include 'stylessearch.php'; ?>
</head>
<body>
    <h1>Пошук категорії</h1>

    <form method="POST" action="">
        <input type="text" name="search_category" placeholder="Частина назви категорії">
        <input type="submit" value="Пошук категорії">
    </form>

    <div class="result">
        <?php
        include "databaseConnect.php";

        if (isset($_POST['search_category']) && !empty($_POST['search_category'])) {
            $search = "%" . $_POST['search_category'] . "%";
            $stmt = $pdo->prepare("SELECT category_id, category_name FROM categories WHERE category_name LIKE :search");
            $stmt->bindParam(':search', $search);
            $stmt->execute();
        
            $count = $stmt->rowCount();
        
            if ($count > 0) {
                echo "<h3>Результати пошуку:</h3>";
                echo "<table>";
                echo "<tr><th>ID</th><th>Назва категорії</th></tr>";
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['category_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['category_name']) . "</td>";
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
        <li><a href="showCategories.php">Таблиця Categories</a></li>
        <li><a href="index.html">На головну</a></li>
    </ul>
</body>

</html>
