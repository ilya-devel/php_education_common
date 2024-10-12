<?php

namespace Geekbrains\Application1\Domain\Models;

use Geekbrains\Application1\Application\Application;
use Geekbrains\Application1\Infrastructure\Storage;

class User {
    private ?int $userId;

    private ?string $userName;

    private ?string $userLastName;
    private ?int $userBirthday;

    private static string $storageAddress = '/storage/birthdays.txt';

    public function __construct(int $userId = null, string $name = null, string $lastName = null, int $birthday = null){
        $this->userId = $userId;
        $this->userName = $name;
        $this->userLastName = $lastName;
        $this->userBirthday = $birthday;
    }

    public function setName(string $userName) : void {
        $this->userName = $userName;
    }

    public function setLastName(string $userLastName) : void {
        $this->userLastName = $userLastName;
    }

    public function getUserName(): string {
        return $this->userName;
    }

    public function getUserLastName(): string {
        return $this->userLastName;
    }

    public function getUserBirthday(): int {
        return $this->userBirthday;
    }

    public function setBirthdayFromString(string $birthdayString) : void {
        $this->userBirthday = strtotime($birthdayString);
    }

    public function getUserId(): int {
        return $this->userId;
    }

    public static function getAllUsersFromStorage(): array {
        $sql = "SELECT * FROM users";

        $handler = Application::$storage->get()->prepare($sql);
        $handler->execute();
        $result = $handler->fetchAll();

        $users = [];

        foreach($result as $item){
            $user = new User($item['id_user'], $item['user_name'], $item['user_lastname'], $item['user_birthday_timestamp']);
            $users[] = $user;
        }

        return $users;
    }

    public static function getUserByID(string $userId): array {
        $sql = "SELECT * FROM users WHERE id_user = :user_id";

        $handler = Application::$storage->get()->prepare($sql);
        $handler->execute([
            "user_id" => $userId
        ]);
        $result = $handler->fetchAll();

        $users = [];

        foreach($result as $item){
            $user = new User($item['id_user'], $item['user_name'], $item['user_lastname'], $item['user_birthday_timestamp']);
            $users[] = $user;
        }

        return $users;
    }

    public static function validateRequestData(): bool{
        $result = true;

        if(!(
            isset($_POST['name']) && !empty($_POST['name']) &&
            isset($_POST['lastname']) && !empty($_POST['lastname']) &&
            isset($_POST['birthday']) && !empty($_POST['birthday'])
        )){
            $result = false;
        }

        if (
            preg_match('/<([^>]+)>/', $_POST['name']) ||
            preg_match('/<([^>]+)>/', $_POST['lastname'])
        ) {
            $result = false;
        }


        if(!preg_match('/^(\d{2}-\d{2}-\d{4})$/', $_POST['birthday'])){
            $result =  false;
        }

        if(!isset($_SESSION['csrf_token']) || $_SESSION['csrf_token'] != $_POST['csrf_token']){
            $result = false;
        }

        return $result;
    }

    public function setParamsFromRequestData(): void {
        // var_dump($_POST);
        $this->userName = htmlspecialchars($_POST['name']);
        $this->userLastName = htmlspecialchars($_POST['lastname']);
        $this->setBirthdayFromString($_POST['birthday']);
    }

    public function saveToStorage(){
        $sql = "INSERT INTO users(user_name, user_lastname, user_birthday_timestamp) VALUES (:user_name, :user_lastname, :user_birthday)";

        $handler = Application::$storage->get()->prepare($sql);
        $handler->execute([
            'user_name' => $this->userName,
            'user_lastname' => $this->userLastName,
            'user_birthday' => $this->userBirthday
        ]);
    }

    public function updateToStorage(string $userId){
        $sql = "UPDATE users SET user_name = :user_name, user_lastname = :user_lastname, user_birthday_timestamp = :user_birthday WHERE id_user = :user_id";

        $handler = Application::$storage->get()->prepare($sql);
        $handler->execute([
            'user_name' => $this->userName,
            'user_lastname' => $this->userLastName,
            'user_birthday' => $this->userBirthday,
            'user_id' => $userId
        ]);
    }
}