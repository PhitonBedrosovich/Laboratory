<?php
require_once 'head.php';
require_once 'header.php';
require_once 'MenuTableModule.php'; // Подключаем класс TableModule
require_once 'DishesTableModule.php';
// Создаем экземпляр TableModule для работы с блюдами
$menuModule = new MenuTableModule("menu");
$storeModule = new DishesTableModule("dishes");
// Проверяем, был ли отправлен POST-запрос на удаление записи
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $id = intval($_POST['delete_id']);

    // Вызываем метод delete для удаления записи с указанным id
    $deleted = $menuModule->delete($id);

}
// Получение restaurant_id из GET параметра, если он существует
$restaurant_id = isset($_GET['restaurant_id']) ? $_GET['restaurant_id'] : null;
// Получение всех блюд, если restaurant_id не указан, или только блюд, принадлежащих выбранному ресторану, если указан
$menuItems = ($restaurant_id !== null) ? $menuModule->getAllByFilter("id_dishes = ?", [$restaurant_id]) : $menuModule->getAll();

?>


<body>

<div class="container">
    <h1>Список блюд</h1>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">id</th>
            <th scope="col">Изображение</th>
            <th scope="col">Наименование</th>
            <th scope="col">Меню</th>
            <th scope="col">Описание</th>
            <th scope="col">Масса</th>
            <th colspan="2">Действия</th>
        </tr>
        </thead>
        <tbody> <!-- доделать спешлчарсы -->
        <?php foreach ($menuItems as $menuItem) : ?>
            <tr>
                <th scope="row"><?php echo intval($menuItem['id']); ?></th>
                <th scope="row"><img src="img/<?=$menuItem['img_path']?>" style="max-width: 150px;" alt=""></th>
                <td><?php echo htmlspecialchars($menuItem['name']); ?></td>
                <td><?php
                    // Получаем данные о ресторане по его id
                    $storeData = $storeModule->getById($menuItem['id_dishes']);

                    // Проверяем, является ли $storeData массивом
                    if (is_array($storeData)) {
                        // Выводим название ресторана
                        $restaurantName = $storeData['name'];
                    } else {
                        // Если $storeData не является массивом, установим пустое значение
                        $restaurantName = '';
                    }
                    // Выводим название ресторана
                    echo htmlspecialchars($restaurantName);
                    ?></td>
                <td><?php echo htmlspecialchars($menuItem['description']); ?></td>
                <td><?php echo intval($menuItem['weight']); ?></td>
                <td>
                    <a href="add.php?id=<?php echo intval($menuItem['id']); ?>" class="btn btn-primary">Изменить</a>
                    <form method="post" style="display: inline;">
                        <input type="hidden" name="delete_id" value="<?php echo intval($menuItem['id']); ?>">
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Удалить это?');">Удалить</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <a class="btn btn-primary" type="button" href="add.php">Добавить</a>
</div>

</body>

</html>
