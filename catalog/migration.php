<?php
// ----------------------------------------------
// Миграция БД
// ----------------------------------------------

//
// Подключение БД
//
function connection_db()
{
    try {
        $dbh = new PDO('sqlite:catalog_db.sqlite');
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        exit('Ошибка подключения к БД: ' . $e->getMessage());
    }
    return $dbh;
}

// $dbh->exec("CREATE TABLE 'categories' ( 
//     'id' INTEGER PRIMARY KEY, 
//     'name' VARCHAR(50) NOT NULL
// );");

// $dbh->exec('INSERT INTO categories (name) VALUES ("Телефоны")');
// $dbh->exec('INSERT INTO categories (name) VALUES ("Видео")');
// $dbh->exec('INSERT INTO categories (name) VALUES ("Фото")');
// $dbh->exec('INSERT INTO categories (name) VALUES ("Планшеты")');
// $dbh->exec('INSERT INTO categories (name) VALUES ("Ноутбуки")');
// $dbh->exec('INSERT INTO categories (name) VALUES ("Приставки")');
// $dbh->exec('INSERT INTO categories (name) VALUES ("Аудио")');
// $dbh->exec('INSERT INTO categories (name) VALUES ("Игрушки")');
// $dbh->exec('INSERT INTO categories (name) VALUES ("Одежда")');

// $dbh->exec("CREATE TABLE `products` (
//     `id` INTEGER PRIMARY KEY,
//     `name` varchar(100) NOT NULL,
//     `foto` varchar(200) DEFAULT NULL,
//     `price` int(10) NOT NULL,
//     `description` text NOT NULL,
//     `code` varchar(200) NOT NULL,
//     `quantity` int(7) DEFAULT NULL,
//     `category_id` INTEGER NOT NULL
// )");

// for ($i = 1; $i <= 300; $i++) {
    
//     $dbh->exec('INSERT INTO products (name, foto, price, description, code, quantity, category_id) 
//                 VALUES (
//                 "Товар ' . $i . '",
//                 "prev-foto' . rand(1, 5) . '.jpg",' .
//                 rand(100, 10000) . ',
//                 "Далеко-далеко за словесными горами в стране, гласных и согласных живут рыбные тексты. Обеспечивает жаренные, гор текста которой. Жаренные безопасную, эта переписали текстами до моей правилами строчка коварный текст свой которое о пустился.",
//                 "A00' . $i . '",' . 
//                 rand(1, 1000) . ',' .
//                 rand(1, 9) . '
//     )');
// }


// $sth = $dbh->query('SELECT * FROM categories');
// $array = $sth->fetchAll(PDO::FETCH_ASSOC);

// foreach ($array as $item) {
//     // echo '<pre>'; 
//     // print_r($item['name']);
//     // echo '</pre>';
//     echo $item['name'] . '<br>';
// }

// $sth = $dbh->query('SELECT * FROM products');
// $products = $sth->fetchAll(PDO::FETCH_ASSOC);

// foreach ($products as $product) {
//     // echo '<pre>'; 
//     // print_r($item['name']);
//     // echo '</pre>';
//     echo $product['name'] . ' Цена: ' . $product['price'] . ' Фото: ' . $product['foto'] . 
//          ' Артикул: ' . $product['code'] . ' Количество: ' . $product['quantity'] .
//          ' Категория: ' . $product['category_id'] . '<br>';
// }