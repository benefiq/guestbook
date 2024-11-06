<?php
$file = 'data.txt';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = nl2br(htmlspecialchars(trim($_POST['message'])));
    
    if ($name && $email && $message) {
        $entry = "$name | $email | " . date('Y-m-d H:i:s') . " | $message\n";
        file_put_contents($file, $entry, FILE_APPEND);
    }
}

$messages = file_exists($file) ? array_reverse(file($file)) : [];
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Гостевая книга</title>
</head>
<body>
    <h1>Гостевая книга</h1>
    <form method="post">
        <input type="text" name="name" placeholder="Ваше имя" required>
        <input type="email" name="email" placeholder="Ваш Email" required>
        <textarea name="message" placeholder="Ваше сообщение" required></textarea>
        <button type="submit">Отправить сообщение</button>
    </form>

    <h2>Сообщения:</h2>
    <div>
        <?php foreach ($messages as $msg): list($name, $email, $datetime, $text) = explode('|', $msg); ?>
            <div>
                <strong><?= trim($name) ?></strong> (<?= trim($email) ?>) <br>
                <em><?= trim($datetime) ?></em> <br>
                <p><?= $text ?></p>
                <hr>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>