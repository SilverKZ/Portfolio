<?php
// ----------------------------------------------
// Библиотека функций
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

//
// Подготовка запроса и запрос
//
function execute(string $sql, array $data = [])
{
    $dbh = connection_db();
    $sth = $dbh->prepare($sql);
    $sth->execute($data);
    return $sth->fetchAll(PDO::FETCH_ASSOC);
}

//
// Возвращает список категорий с сортировкой по параметру order_by
//
function get_categories($order_by)
{
    $sql = 'SELECT categories.id, categories.name, COUNT(products.id) AS num 
            FROM categories LEFT OUTER JOIN products
            ON categories.id=products.category_id
            GROUP BY categories.id ' . $order_by;
    return execute($sql);
}

//
// Возвращает список товаров категории $id
// $page_num - текущая страница
// $on_page  - количество записей на странице
//
function get_products(int $id, int $page_num, int $on_page = 9)
{
    $shift = ($page_num - 1) * $on_page;
    $sql = 'SELECT id, name, foto, price FROM products 
            WHERE category_id=:id LIMIT :shift, :on_page';
    return execute($sql, [':id' => $id, ':shift' => $shift, ':on_page' => $on_page]);
}

//
// Возвращает количество товаров категории $id
//
function get_all_products(int $id)
{
    $sql = 'SELECT COUNT(id) AS count, category_id FROM products WHERE category_id=:id';
    $result = execute($sql, [':id' => $id]);
    return $result[0];
}

//
// Возвращает информацию о товаре по параметру $id
//
function get_product(int $id)
{
    $sql = 'SELECT * FROM products WHERE id=:id';
    $result = execute($sql, [':id' => $id]);
    return $result[0];
}

//
// Возвращает название категории по параметру $id
//
function get_category(int $id)
{
    $sql = 'SELECT name AS num FROM categories WHERE id=:id';
    $result = execute($sql, [':id' => $id]);
    return $result[0]['num'];    
}
