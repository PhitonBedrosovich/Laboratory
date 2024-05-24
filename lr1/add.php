<?php
require_once "head.php";
require_once "header.php";
require_once 'MenuTableModule.php';
require_once 'DishesTableModule.php';

$menuModule = new MenuTableModule('menu');

// Проверяем наличие id в запросе GET
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Получаем данные о блюде из базы данных по id
    $menuItem = $menuModule->getById($id);

    if ($menuItem) {
        // Если блюдо существует, заполняем поля формы данными из базы данных
        $name = htmlspecialchars($menuItem['name']);
        $description = htmlspecialchars($menuItem['description']);
        $weight = intval($menuItem['weight']);
        $img_path = $menuItem['img_path'];
        $id_dishes = intval($menuItem['id_dishes']);
        // Устанавливаем флаг редактирования
        $action = "edit";
    } else {
        // Если блюдо не найдено, выводим сообщение об ошибке
        echo "Ошибка: Блюдо не найдено.";
        exit;
    }
} else {
    // Если id отсутствует, устанавливаем значения по умолчанию для полей формы
    $name = "";
    $description = "";
    $weight = "";
    $img_path = "";
    $id_dishes = "";
    // Устанавливаем флаг добавления нового блюда
    $action = "add";
}

// Получение списка ресторанов из базы данных
$storeModule = new DishesTableModule("dishes");
$stores = $storeModule->getAll();

// Обработка данных из формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];

    // Валидация названия блюда
    if (empty($_POST['set_dishes_name'])) {
        $errors[] = "Название блюда обязательно для заполнения.";
    } elseif (strlen($_POST['set_dishes_name']) > 60) {
        $errors[] = "Название блюда не должно превышать 60 символов.";
    }

    // Проверка валидности стоимости
    if (!is_numeric($_POST['set_dishes_weight'])) {
        $errors[] = "Введите корректный вес.";
    }


    if (empty($errors)) {
        // Если данные прошли валидацию, продолжаем обработку данных
        $data = [
            'name' => htmlspecialchars($_POST['set_dishes_name']),
            'description' => htmlspecialchars($_POST['set_dishes_description']),
            'weight' => intval($_POST['set_dishes_weight']),
            'id_dishes' => intval($_POST['set_dishes']),
        ];
        // Устанавливаем id из формы, если он доступен
        if (isset($_POST['id'])) {
            $data['id'] = intval($_POST['id']);
        }

        // Обработка изображения, если оно было загружено
        if (isset($_FILES['set_dishes_img']) && $_FILES['set_dishes_img']['error'] === UPLOAD_ERR_OK) {
            $img_name = uniqid('img_') . '_' . $_FILES['set_dishes_img']['name'];
            $img_path = 'img/' . $img_name;
            move_uploaded_file($_FILES['set_dishes_img']['tmp_name'], $img_path);
            $data['img_path'] = $img_name;
        }

        // Вызов метода insert для добавления новой записи или обновления существующей
        $errors = $menuModule->insert($data);

        if (empty($errors)) {
            // Если нет ошибок, перенаправляем пользователя на главную страницу
            header('Location: menu_list.php');
            exit();
        }
    } else {
        // Если есть ошибки, выведите их пользователю
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
    }
}
?>

<!-- HTML-разметка для формы добавления нового блюда -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="menu_list.php">Меню</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= ($action == "edit") ? "Редактирование блюда $name" : "Добавление блюда" ?></li>
    </ol>
</nav>

<h1><?= ($action == "edit") ? "Редактирование блюда $id" : "Добавление блюда" ?></h1>

<form class="row row-cols-lg-auto g-3 align-items-center" name="add_dishes" method="post" action="add.php" enctype="multipart/form-data">
    <input type="hidden" name="action" value="<?= $action ?>">
    <?php if ($action == "edit") : ?>
        <input type="hidden" name="id" value="<?= $id ?>">
    <?php endif; ?>
    <div class="col-4">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Название блюда" name="set_dishes_name" maxlength="60" title="Название блюда" value="<?= $name ?>">
        </div>
    </div>

    <div class="col-4">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Рецепт" name="set_dishes_description" maxlength="60" title="Описание" value="<?= $description ?>">
        </div>
    </div>

    <div class="col-4">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Стоимость" name="set_dishes_weight" maxlength="60" title="Вес" value="<?= $weight ?>">
        </div>
    </div>

    <div class="col-4">
        <div class="input-group">
            <input type="hidden" name="MAX_FILE_SIZE" value="3000000">
            <input type="file" class="form-control" name="set_dishes_img" title="Фото">
        </div>
    </div>

    <div class="col-4">
        <div class="input-group">
            <select class="form-select" aria-label="Ресторан" name="set_dishes" title="Меню">
                <option value="" selected disabled>Выберите меню</option>
                <?php foreach ($stores as $store) : ?>
                    <option value="<?= $store['id'] ?>" <?= ($store['id'] == $id_dishes) ? "selected" : "" ?>><?= $store['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="col-4">
        <button class="btn btn-primary" type="submit"><?= ($action == "edit") ? "Сохранить" : "Добавить" ?></button>
    </div>
</form>
