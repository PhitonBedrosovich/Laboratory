<?php
require_once 'AbstractTableModule.php';

class MenuTableModule extends AbstractTableModule {
    private $conn;
    private $table_name="menu";

    public function __construct($table_name) {
        // Получение экземпляра подключения к базе данных
        $this->conn = DBConnection::getInstance();
        // Установка имени таблицы
    }

    // Метод для очистки входящих данных от потенциально опасных символов
    private function cleanInput($data) {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                // Рекурсивно очищаем каждое значение массива
                $data[$key] = $this->cleanInput($value);
            }
        } else {
            // Очищаем строку от потенциально опасных символов
            $data = htmlspecialchars(strip_tags($data));
        }
        return $data;
    }

    public function insert($data) {
        // Очистка входящих данных от потенциально опасных символов
        $data = $this->cleanInput($data);

        // Проверяем наличие id в данных
        if(isset($data['id']) && $data['id'] !== "") {
            // Если id существует и не пустое, это редактирование существующей записи

            // Формирование строки SET для обновления записи
            $set = [];
            foreach ($data as $key => $value) {
                if ($key !== 'id') {
                    $set[] = "$key = :$key";
                }
            }
            $set = implode(", ", $set);
            $query = "UPDATE $this->table_name SET $set WHERE id = :id";

            // Выполнение запроса на обновление записи
            return $this->executeQuery($query, $data);
        } else {

            // Если id отсутствует или пустое, это добавление новой записи

            $columns = implode(', ', array_keys($data));
            $placeholders = implode(', ', array_map(function($key) { return ":$key"; }, array_keys($data)));

            // Формирование SQL запроса для вставки записи
            $query = "INSERT INTO $this->table_name ($columns) VALUES ($placeholders)";

            // Выполнение запроса на вставку новой записи
            return $this->executeQuery($query, $data);
        }
    }

    public function delete($id) {
        // Очистка входящих данных от потенциально опасных символов
        $id = $this->cleanInput($id);

        $query = "DELETE FROM $this->table_name WHERE id = ?";
        $params = array($id);

        return $this->executeQuery($query, $params);
    }

    public function getById($id) {
        // Очистка входящих данных от потенциально опасных символов
        $id = $this->cleanInput($id);

        // Подготавливаем SQL запрос с использованием плейсхолдера для id
        $query = "SELECT * FROM $this->table_name WHERE id = ?";

        // Выполняем запрос и передаем значение id в качестве параметра
        return $this->executeQuery($query, [$id], true);
    }

    public function getAll() {
        try {
            // Формируем SQL запрос
            $query = "SELECT * FROM " . $this->table_name;

            // Подготавливаем и выполняем запрос
            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            // Получаем результат в виде ассоциативного массива
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result;
        } catch (PDOException $e) {
            // Обрабатываем исключение, если произошла ошибка при выполнении запроса
            die("Error: " . $e->getMessage());
        }
    }

    public function getAllByFilter($filter = "", $params = []) {
        // Очистка входящих данных от потенциально опасных символов
        $filter = $this->cleanInput($filter);

        $query = "SELECT * FROM $this->table_name";
        if (!empty($filter)) {
            $query .= " WHERE $filter";
        }

        return $this->executeQuery($query, $params);
    }

    private function executeQuery($query, $params = [], $single = false) {
        $stmt = $this->conn->prepare($query);
        if ($stmt === false) {
            die("Error in query preparation: " . $this->conn->error());
        }

        if (!empty($params)) {
            foreach ($params as $key => $value) {
                $stmt->bindValue(":param$key", $value);
            }
        }

        // При обновлении записи необходимо выполнить привязку параметров и передать параметры запроса
        if ($stmt->execute($params) === false) {
            die("Error in query execution: " . $stmt->errorInfo()[2]);
        }

        if ($single) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return $result;
    }
}

?>
