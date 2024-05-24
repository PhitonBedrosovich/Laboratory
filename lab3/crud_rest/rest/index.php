<?php
require_once '../vendor/autoload.php';
require_once "../classes/menus.php";
require_once "../classes/foods.php";
$app = new Silex\Application();

$app->after(function ($request, $response) {
    $response->headers->set('Access-Control-Allow-Origin', '*');
    $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    $response->headers->set('Access-Control-Allow-Headers', 'Origin, Content-Type, X-Auth-Token');
});

//для ресторанов:
$app->get('/menus/list.json', function () use ($app){
	$menus = new Menus;
	$list = $menus->read();
	return $app->json($list);
});

$app->post('/menus/add-item', function () use ($app){
	if (strlen($_POST['name']) ) {
		$name = $_POST['name'];

		$menus = new Menus;
		try {
			$menus->create(array("name" => $name));
			$lastid = $menus->lastID();
			return $app->json(array("create-menus" => "yes", "create-id" => $lastid));
		} catch (PDOException $e) {
			return $app->json(array("error" => $e->getMessage(), "create-menus" => "no"));
		}
	} else {
		return $app->json(array("create-menus" => "no"));
	}
});
$app->post('/menus/update-item', function ()use ($app) {
	$menus = new Menus;
	$id = intval($_POST["id"]);
	$name = $_POST["name"];

	if ($menus->exists($id) && strlen($name)) {
		try {
			$menus->update(array( "id" => $id, "name" => $name));
			return $app->json(array("update-menus" => "yes", "id_update" => $id));
		} catch (PDOException $e) {
			return $app->json(array("error" => $e->getMessage(), "update-menus" => "no"));
		}
	} else {
		return $app->json(array("update-menus" => "no"));
	}
});

$app->options('/menus/delete-item', function () use ($app) {
    $response = new \Symfony\Component\HttpFoundation\Response();
    $response->headers->set('Access-Control-Allow-Origin', '*');
    $response->headers->set('Access-Control-Allow-Methods', 'POST');
    $response->headers->set('Access-Control-Allow-Headers', 'Content-Type');
    return $response;
});


$app->post('/menus/delete-item', function () use ($app) {
    $id = isset($_POST["id"]) ? intval($_POST["id"]) : null;
    $menus = new Menus;
    if ($menus->exists($id)) {
        try {
            $menus->delete($id);
            $response = $app->json(array("delete-menus" => "yes", "id_delete" => $id));
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set('Access-Control-Allow-Methods', 'POST');
            $response->headers->set('Access-Control-Allow-Headers', 'Origin, Content-Type, X-Auth-Token');
            return $response;
        } catch (PDOException $e) {
            $response = $app->json(array("error" => $e->getMessage(), "delete-menus" => "no"));
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set('Access-Control-Allow-Methods', 'POST');
            $response->headers->set('Access-Control-Allow-Headers', 'Origin, Content-Type, X-Auth-Token');
            return $response;
        }
    } else {
        $response = $app->json(array("delete-menus" => "no"));
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', 'POST');
        $response->headers->set('Access-Control-Allow-Headers', 'Origin, Content-Type, X-Auth-Token');
        return $response;
    }
});

//для блюд:

$app->get('/foods/list.json', function () use ($app){
	$food = new Foods();
	$list = $food->read();
	return $app->json($list);
});
$app->post('/foods/add-item', function () use ($app) {
    $name = $_POST["name"];
    $id_dishes = $_POST['id_dishes'];
    $weight = $_POST['weight'];
    $description = $_POST['description'];


    // Добавьте обработку загруженного файла
    if (isset($_FILES['img_path']) && $_FILES['img_path']['error'] === UPLOAD_ERR_OK) {
        $tempFilePath = $_FILES['img_path']['tmp_name'];
        $img_name = uniqid('img_') . '_' . $_FILES['img_path']['name'];
        $newFilePath = 'C:/xampp/htdocs/lab2.2/src/assets/img/' . $img_name; // Укажите путь соответственно

        // Переместите загруженный файл в папку проекта
        if (!move_uploaded_file($tempFilePath, $newFilePath)) {
            // Если не удалось переместить файл, отправьте сообщение об ошибке
            $errorMessage = 'Ошибка при перемещении файла';
            return $app->json(array("error" => $errorMessage, "create-food" => "no"));
        }
    $img_path =$img_name ;
        // Теперь $newFilePath содержит путь к загруженному изображению, который можно сохранить в базе данных
    }

    $food = new Foods();
    try {
        $food->create(array('name' => $name, "id_dishes" => $id_dishes, "description" => $description, "weight" => $weight, "img_path" => $img_path));
        return $app->json(array("create-food" => "yes"));
    } catch (PDOException $e) {
        return $app->json(array("error" => $e->getMessage(), "create-food" => "no"));
    }
});

$app->post('/foods/update-item', function () use ($app){
    $id= $_POST['id'];
    $name = $_POST['name'];
    $id_dishes = $_POST['id_dishes'];
    $weight = $_POST['weight'];
    $description = $_POST['description'];
    // Добавьте обработку загруженного файла
    if (isset($_FILES['img_path']) && $_FILES['img_path']['error'] === UPLOAD_ERR_OK) {
        $tempFilePath = $_FILES['img_path']['tmp_name'];
        $img_name = uniqid('img_') . '_' . $_FILES['img_path']['name'];
        $newFilePath = 'C:/xampp/htdocs/lab2.2/src/assets/img/' . $img_name; // Укажите путь соответственно

        // Переместите загруженный файл в папку проекта
        if (!move_uploaded_file($tempFilePath, $newFilePath)) {
            // Если не удалось переместить файл, отправьте сообщение об ошибке
            $errorMessage = 'Ошибка при перемещении файла';
            return $app->json(array("error" => $errorMessage, "create-food" => "no"));
        }
        $img_path =$img_name ;
        // Теперь $newFilePath содержит путь к загруженному изображению, который можно сохранить в базе данных
    }
	$food = new Foods;
	if ($food->exists($id) && strlen($name)) {
		try {
			$food->update(array("id" => $id, 'name' => $name, "id_dishes" => $id_dishes, "description" => $description, "weight" => $weight, "img_path" => $img_path));
			return $app->json(array("update-food" => "yes", "id_update" => $id));
		} catch (PDOException $e) {
			return $app->json(array("error" => $e->getMessage(), "update-food" => "no"));
		}
	} else {
		return $app->json(array("update-food" => "no"));
	}
});

$app->post('/foods/delete-item', function () use ($app) {
    $id = intval($_POST["id"]);

    $food = new Foods();
    if ($food->exists($id)) {
        try {
            // Получаем информацию о блюде
            $dishInfo = $food->get($id);
            $img_path = 'C:/xampp/htdocs/lab2.2/src/assets/img/' . $dishInfo['img_path']; // Получаем путь к изображению

            // Удаляем запись из базы данных
            $food->delete($id);

            // Удаляем файл изображения, если он существует
            if (!empty($img_path) && file_exists($img_path)) {
                unlink($img_path); // Удаляем файл
            }

            return $app->json(array("delete-food" => "yes", "id_delete" => $id));
        } catch (PDOException $e) {
            return $app->json(array("error" => $e->getMessage(), "delete-food" => "no"));
        }
    } else {
        return $app->json(array("delete-food" => "no"));
    }
});

$app->get('/foods/SelectByID', function () use ($app){
    $id_dishes = intval($_GET['id_dishes']);
    $fields = array(); // Добавьте дополнительные поля для фильтрации, если необходимо
    $food = new Foods();
    $list = $food->getRecordsByFilter($id_dishes, $fields);
    return $app->json($list);
});

$app->run();