<html>
<head>
    <meta charset="utf-8">
    <meta name="keywords" content="Лабораторна робота, MySQL, робота з базою даних">
    <meta name="description" content="Лабораторна робота. Робота з базою даних">
    <title>Вставка даних у таблицю Brands</title>
    <?php include 'stylesinvite.php'; ?>
</head>
<body>

    <h1>Вставка даних у таблицю Brands</h1>

    <form method="POST" action="">
        <input type="text" name="insert_name" placeholder="Name" required>
        <input type="text" name="insert_description" placeholder="Description" required>
        <input type="date" name="insert_founded_date" placeholder="Founded Date" required>
        <input type="submit" name="insert" value="Вставити бренд">
    </form>

    <?php
    if (isset($_POST['insert'])) {
        include "databaseConnect.php";

        $name = $_POST['insert_name'];
        $description = $_POST['insert_description'];
        $founded_date = $_POST['insert_founded_date'];

        // SQL запит для вставки даних у таблицю brands
        $stmt = $pdo->prepare("INSERT INTO brands (name, description, founded_date) VALUES (:name, :description, :founded_date)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':founded_date', $founded_date);

        if ($stmt->execute()) {
            echo "<div class='message success-message'><p>Бренд доданий успішно!</p></div>";
        } else {
            echo "<div class='message error-message'><p>Помилка додавання бренду.</p></div>";
        }
    }
    ?>

    <ul>
        <li><a href="showBrands.php">Показати таблицю брендів</a></li>
        <li><a href="index.html">На головну</a></li>
    </ul>

</body>
</html>
