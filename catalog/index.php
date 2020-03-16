<?php
header('Content-Type: text/html; charset=UTF-8');
error_reporting(E_ALL);
mb_internal_encoding('UTF-8');

// Полный путь к текущему исполняемому скрипту
define('SITE_URL', substr($_SERVER['SCRIPT_NAME'], 0, strripos($_SERVER['SCRIPT_NAME'], '/') + 1));

// Подключение библиотеки функций (работа с БД)
include_once __DIR__ . '/functions.php';

// Заголовок страницы
$title = 'Мини-каталог товаров';

// Флаг сортировки списка категорий
$order_by = '';

// Флаг выбора экрана для отображения
$main = '';

// Инициализация переменных для пагинации 
$page_num = 1; // текущая страница
$on_page  = 9; // количество записей на странице
$all_page = 1; // количество страниц

// -----------------------------------------------
// Если пришли по ссылке с get-параметром order
// сортировка
// -----------------------------------------------   
if (isset($_GET['order'])) {

    if ($_GET['order'] === 'asc') {
        $order_by = 'ORDER BY categories.name';
    } elseif ($_GET['order'] === 'num') {
        $order_by = 'ORDER BY num DESC';
    } else {
        $order_by = '';
    }

// -----------------------------------------------
// Если пришли по ссылке с get-параметром cat 
// выбор категории и пагинация
// -----------------------------------------------     
} elseif (isset($_GET['cat'])) {

    $id = (int)$_GET['cat'];
    $page_num = (isset($_GET['pag'])) ? (int)$_GET['pag'] : 1;
    $products = get_products($id, $page_num, $on_page);
    $all_products = get_all_products($id);
    $all_page = ($on_page !== 0) ? ceil($all_products['count'] / $on_page) : 1;
    $cramb_category_name = get_category($id);
    $main = 'products';

// -----------------------------------------------
// Если пришли по ссылке с get-параметром prod
// выбор продукта
// -----------------------------------------------     
} elseif (isset($_GET['prod'])) {

    $product = get_product((int)$_GET['prod']);
    $product['full-foto'] = explode('-', $product['foto'])[1];
    $cramb_product_cat = get_category($product['category_id']);
    $main = 'product';

}

// Получение списка категорий
$categories = get_categories($order_by);

?><!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Мини-каталог</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Main CSS -->
    <link rel="stylesheet" href="<?=SITE_URL;?>style.css">
</head>
<body>
    <div class="container">
        <!-- Title -->
        <div class="row">
            <div class="col-12">
                <h1 class="display-4"><?=$title;?></h1>
            </div>
        </div>
        <!-- End Title -->
        <hr>
        <!-- Breadcrumb -->
        <div class="row">
            <div class="col-12">
                 <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item <?=$cramb_home;?>">
                            <a href="<?=SITE_URL;?>">Главная</a>
                        </li>
                        <?php if(!empty($cramb_category_name)): ?>
                        <li class="breadcrumb-item active"><?=$cramb_category_name;?></li>
                        <?php endif; ?>
                        <?php if(!empty($product)): ?>
                        <li class="breadcrumb-item">
                            <a href="<?=SITE_URL;?>index.php?cat=<?=$product['category_id'];?>"><?=$cramb_product_cat;?></a>                  
                        </li>
                        <li class="breadcrumb-item active" aria-current="page"><?=$product['name'];?></li>
                        <?php endif; ?>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- End Breadcrumb -->
        <div class="row">
            <!-- Categories -->
            <div class="col-12 col-sm-4 col-md-3">
                <?php if(!empty($categories)): ?>
                <ul class="nav flex-column">
                    <?php foreach ($categories as $category): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?=SITE_URL;?>index.php?cat=<?=$category['id']?>"><?=$category['name']?> 
                            <span class="badge badge-primary badge-pill"><?=$category['num']?></span>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
                <a href="<?=SITE_URL;?>index.php?order=asc" class="btn btn-outline-primary my-btn">в алфавитном</a>
                <a href="<?=SITE_URL;?>index.php?order=num" class="btn btn-outline-primary my-btn">по количеству</a>
            </div>
            <!-- End Categories -->
            <!-- Products -->
            <div class="col-12 col-sm-8 col-md-9">
            <?php if(empty($main)): ?>
                <div class="alert alert-primary" role="alert">Выберите категорию</div>
            <?php elseif($main==='products'): ?>
                <?php if(!empty($products)): ?>
                <!-- Cards -->
                <div class="card-deck">
                    <?php foreach ($products as $product): ?>
                    <a href="<?=SITE_URL;?>index.php?prod=<?=$product['id'];?>" class="card  card-ext">
                        <img class="card-img-top" src="<?=SITE_URL;?>temp/<?=$product['foto'];?>">
                        <div class="card-body">
                            <h3 class="card-title"><?=$product['name'];?></h3>
                            <p class="card-text product-price">Цена: <?=$product['price'];?> руб.</p>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
                <!-- End Cards -->
                <!-- Pagination -->
                <nav aria-label="...">
                    <ul class="pagination">
                        <?php for ($i = 1; $i <= $all_page; $i++): ?>
                        <?php if ($page_num === $i): ?>
                        <li class="page-item active">
                        <?php else: ?>
                        <li class="page-item">
                        <?php endif; ?>
                            <a class="page-link" href="<?=SITE_URL;?>index.php?cat=<?=$all_products['category_id'];?>&pag=<?=$i;?>"><?=$i;?></a>
                        </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
                <!-- End Pagination -->
                <?php endif; ?>
            <?php elseif($main==='product'): ?>
                <?php if(!empty($product)): ?>
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-wrap">
                            <a href="<?=SITE_URL;?>temp/<?=$product['full-foto'];?>" data-toggle="modal" data-target="#exampleModalCenter">
                                <img class="card-img-top product-img" src="<?=SITE_URL;?>temp/<?=$product['foto'];?>">
                            </a>
                            <div class="box-right">
                                <h3 class="card-title"><?=$product['name'];?></h3>
                                <p class="card-text product-price">Цена: <?=$product['price'];?> руб.</p>
                                <p class="card-text">Артикул: <?=$product['code'];?></p>
                                <p class="card-text">Количество на складе: <?=$product['quantity'];?></p>
                            </div>
                        </div>
                        <p class="card-text">Описание: <?=$product['description'];?></p>
                    </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="document" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="container-fluid">
                                    <img src="<?=SITE_URL;?>temp/<?=$product['full-foto'];?>">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Modal -->
                <?php endif; ?>
            <?php endif; ?>
            </div>
            <!-- End Products -->
        </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>