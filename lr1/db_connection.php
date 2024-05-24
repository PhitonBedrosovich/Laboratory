<?php
class DBConnection {
    // Статическое свойство для хранения единственного экземпляра подключения
    private static $instance = null;

    // Метод для получения экземпляра подключения
    public static function getInstance() {
        if (!self::$instance) {
            try {
                $hostname = "localhost";
                $username = "vse_dly_tebe";
                $password = "123";
                $dbname = "restaurant__dishes";

                $dsn = "mysql:host=$hostname;dbname=$dbname";
                self::$instance = new PDO($dsn, $username, $password);

                // Настройка PDO для выброса исключений при ошибке
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e) {
                die("Connection failed: " . $e->getMessage());
            }
        }
        return self::$instance;
    }

    // Запрещаем создание экземпляров класса извне
    private function __construct() {}

    // Запрещаем клонирование объекта
    private function __clone() {}


    public function __wakeup() {}
}

// Использование:
$pdo = DBConnection::getInstance();
