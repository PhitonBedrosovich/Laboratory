<?php
require_once 'head.php';
require_once 'header.php';
require_once 'MenuTableModule.php'; // Подключаем класс TableModule
require_once 'DishesTableModule.php';
// Создаем экземпляр TableModule для работы с ресторанами
$restaurantModule = new DishesTableModule("dishes");
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $id = $_POST['delete_id'];

    // Вызываем метод delete для удаления записи с указанным id
    $deleted = $restaurantModule->delete($id);

}
// Получение всех ресторанов
$restaurants = $restaurantModule->getAll();

?>



<body>

<div class="container">
    <h1>Меню</h1>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Название</th>
            <th scope="col">Действия</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($restaurants as $restaurant) : ?>
            <tr>
                <th scope="row"><?php echo intval($restaurant['id']); ?></th>
                <td><?php echo htmlspecialchars($restaurant['name']); ?></td>
                <td>
                    <a href="add_restaurant.php?id=<?php echo intval($restaurant['id']); ?>" class="btn btn-primary">Изменить</a>
                    <form method="post" style="display: inline;">
                        <input type="hidden" name="delete_id" value="<?php echo intval($restaurant['id']); ?>">
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Вы хотите удалить запись?');">Удалить</button>
                    </form>
                    <a href="menu_list.php?restaurant_id=<?php echo intval($restaurant['id']); ?>" class="btn btn-info">Список блюд</a>                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <a class="btn btn-primary" type="button" href="add_restaurant.php">Добавить</a>
</div>

</body>

</html>

