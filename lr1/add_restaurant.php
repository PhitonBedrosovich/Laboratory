<?php
require_once "head.php";
require_once "header.php";
require_once 'MenuTableModule.php'; // Подключение класса TableModule
require_once 'DishesTableModule.php';
// Создание экземпляра класса TableModule для работы с таблицей "a_store"
$storeModule = new DishesTableModule("dishes");

// Инициализация переменных
$errors = [];

// Проверка наличия id в GET-запросе для определения режима работы (добавление или редактирование)
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $storeData = $storeModule->getById($id);

    if ($storeData) {
        // Если ресторан существует, заполняем поля формы данными из базы данных
        $storeName = htmlspecialchars($storeData['name']);
        // Устанавливаем флаг редактирования
        $action = "edit";
    } else {
        // Если ресторан не найден, выводим сообщение об ошибке
        echo "Ошибка: Меню не найден.";
        exit;
    }
} else {
    // Если id отсутствует, устанавливаем значения по умолчанию для полей формы
    $storeName = "";
    // Устанавливаем флаг добавления нового ресторана
    $action = "add";
}

// Обработка данных из формы при отправке POST-запроса
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $storeName = htmlspecialchars($_POST['store_name']);

    // Валидация названия ресторана
    if (empty($storeName)) {
        $errors[] = "Название меню обязательно для заполнения.";
    }

    if (empty($errors)) {
        // Если данные прошли валидацию, продолжаем обработку данных
        $data = array(
            "name" => $storeName
        );

        if (isset($_POST['id'])) {
            $data['id'] = intval($_POST['id']);
        }

        // Вызов метода insert для добавления нового ресторана или обновления существующего
        $errors = $storeModule->insert($data);

        if (empty($errors)) {
            // Если нет ошибок, перенаправляем пользователя на страницу списка ресторанов
            header('Location: dishes_list.php');
            exit();
        }
    }
}
?>

<!-- HTML форма для добавления или редактирования ресторана -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="dishes_list.php">Список меню</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= ($action == "edit") ? "Редактирование меню  $storeName" : "Добавить меню" ?></li>
    </ol>
</nav>
<h1><?= ($action == "edit") ? "Редактирование меню $id" : "Добавить меню" ?></h1>

<!-- Вывод ошибок, если они есть -->
<?php if (!empty($errors)) : ?>
    <div class="alert alert-danger" role="alert">
        <?php foreach ($errors as $error) : ?>
            <?= $error ?><br>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<!-- Форма для добавления или редактирования ресторана -->
<form method="post" action="add_restaurant.php">
    <?php if ($action === "edit") : ?>
        <input type="hidden" name="id" value="<?= intval($id) ?>">
    <?php endif; ?>
    <div class="mb-3">
        <label for="store_name" class="form-label">Название меню</label>
        <input type="text" class="form-control" id="store_name" name="store_name" required value="<?= htmlspecialchars($storeName) ?>">
    </div>
    <button type="submit" class="btn btn-primary"><?= ($action == "edit") ? "Сохранить" : "Добавить" ?></button>
</form>
