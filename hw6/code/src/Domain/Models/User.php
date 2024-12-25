<?php

namespace Geekbrains\Application1\Domain\Models;
use Geekbrains\Application1\Application\Application;
use Geekbrains\Application1\Application\Auth;
use Exception;


class User {

    private ?int $idUser;

    private ?string $userLogin;

    private ?string $userName;

    private ?string $userLastName;

    private ?int $userBirthday;

    private ?string $userPasswordHash;

    private ?string $userRole;

    public function __construct(
            int $id = null, 
            string $login = null, 
            string $name = null, 
            string $lastName = null, 
            int $birthday = null, 
            string $passwordHash = null, 
            string $role = null) {
        $this->idUser = $id;
        $this->userLogin = $login;
        $this->userName = $name;
        $this->userLastName = $lastName;
        $this->userBirthday = $birthday;
        $this->userPasswordHash = $passwordHash;
        $this->userRole = $role;
    }

    

    public function setUserName(string $userName) : void {
        $this->userName = $userName;
    }

    public function getUserName(): string {
        return $this->userName;
    }
    public function setUserLastName(string $userLastName) : void {
        $this->userLastName = $userLastName;
    }

    public function getUserLastName(): string {
        return $this->userLastName;
    }

    public function getUserBirthday(): int {
        return $this->userBirthday;
    }
    public function setUserId(int $id_user): void {
            $this->idUser = $id_user;
        }

    public function getUserId(): ?int {
            return $this->idUser;
        }
    public function setBirthdayFromString(string $birthdayString) : void {
        $this->userBirthday = strtotime($birthdayString);
    }

    public function setPasswordHash(string $userPasswordHash) : void {
        $this->userPasswordHash = $userPasswordHash;
    }

    public function getUserPasswordHash(): string {
        return $this->userPasswordHash;
    }

    public function setUserRole(string $userRole) : void {
        $this->userRole = $userRole;
    }

    public function getUserRole(): string {
        return $this->userRole;
    }
    public function setUserLogin(int $userLogin): void {
        $this->userLogin = $userLogin;
    }

    public function getUserLogin(): string {
        return $this->userLogin;
    }

    

    public static function getAllUsersFromStorage(?int $startUserId = null): array {
        $hasStartUserId = ($startUserId != null && $startUserId > 0);
        $sql = "SELECT * FROM users";
        if ($hasStartUserId) {
            $sql .= " WHERE id_user > :id_user";
        }
        $handler = Application::$storage->get()->prepare($sql);
        if ($hasStartUserId) {
            $handler->execute(['id_user' => $startUserId]);
        } else {
            $handler->execute();
        }
        $result = $handler->fetchAll();
        $users = [];
        foreach($result as $item){
            $user = new User(
                $item['id_user'], 
                $item['user_login'], 
                $item['user_name'], 
                $item['user_lastname'],
                $item['user_birthday_timestamp'],
                $item['user_password_hash'],
                $item['user_role']);
            $users[] = $user;
        }
        return $users;
    }


    public static function validateRequestData(): void{
        if (isset($_POST['login']) && empty($_POST['login'])) {
            throw new \Exception("Не введен логин");
        }
        if (!preg_match('/^[A-ZА-Яa-zа-я]+$/u', $_POST['login'])) {
            throw new \Exception("Некорректно введен логин - используйте только буквы вне зависимости от регистра");
        }
        if (isset($_POST['name']) && empty($_POST['name'])) {
            throw new \Exception("Не введено имя");
        }
        if (!preg_match('/^[A-ZА-Я][a-zа-я]+$/u', $_POST['name'])) {
            throw new \Exception("Некорректно введено имя - используейте только буквы, начиная с прописной");
        }
        if (isset($_POST['lastname']) && empty($_POST['lastname'])) {
            throw new \Exception("Не введена фамилия");
        }
        if (!preg_match('/^[A-ZА-Я][a-zа-я]+$/u', $_POST['lastname'])) {
            throw new \Exception("Некорректно введена фамилия - используейте только буквы, начиная с прописной");
        }
        if (isset($_POST['birthday']) && empty($_POST['birthday'])) {
            throw new \Exception("Не введена дата рождения");
        }
        if (!preg_match('/^(\d{2}-\d{2}-\d{4})$/', $_POST['birthday'])) {
            throw new \Exception("Введетите дату рождения в формате DD-MM-YYYY");
        }
        if (isset($_POST['password']) && empty($_POST['password'])) {
            throw new \Exception("Не введен пароль");
        }
        if (!isset($_SESSION['csrf_token']) 
        || $_SESSION['csrf_token'] != $_POST['csrf_token']) 
    {
            throw new \Exception("Ошибка. Подмена формы");
        }
    }

    public function setParamsFromRequestData(): void {
        if ($_POST['id'] != '') {
            $this->idUser = htmlspecialchars($_POST['id']);
        }
        $this->userLogin = htmlspecialchars($_POST['login']);
        $this->userName = htmlspecialchars($_POST['name']);
        $this->userLastName = htmlspecialchars($_POST['lastname']);
        $this->setBirthdayFromString($_POST['birthday']); 
        $this->userPasswordHash = Auth::getPasswordHash($_POST['password']);
        $this->userRole = "guest";
    }
    public function saveToStorage(){
        $sql = "INSERT INTO users(user_login, user_name, user_lastname, user_birthday_timestamp, user_password_hash, user_role) VALUES (:user_login, :user_name, :user_lastname, :user_birthday, :user_password_hash, :user_role)";
        $handler = Application::$storage->get()->prepare($sql);
        $handler->execute([
            'user_login' => $this->userLogin,
            'user_name' => $this->userName,
            'user_lastname' => $this->userLastName,
            'user_birthday' => $this->userBirthday,
            'user_password_hash' => $this->userPasswordHash,
            'user_role' => $this->userRole
        ]);
    }


    public function updateInStorage(): void{
        $sql = "UPDATE users SET user_name = :user_name, user_lastname = :user_lastname, user_birthday_timestamp = :user_birthday WHERE id_user = :id";
        $handler = Application::$storage->get()->prepare($sql);
        $handler->execute([
            'id' => $this->idUser, 
            'user_name' => $this->userName,
            'user_lastname' => $this->userLastName,
            'user_birthday' => $this->userBirthday
        ]);
    }

    public static function exists(int $id): bool{
        $sql = "SELECT count(id_user) as user_count FROM users WHERE id_user = :id_user";

        $handler = Application::$storage->get()->prepare($sql);
        $handler->execute([
            'id_user' => $id
        ]);

        $result = $handler->fetchAll();

        return (count($result) > 0 && $result[0]['user_count'] > 0);
    }
    public function updateUser(int $id, string $name): void{
        $sql = "UPDATE users SET user_name = :name WHERE id_user = :id";

        $handler = Application::$storage->get()->prepare($sql);
        $handler->execute(['id' => $id, 'name' => $name]);
    }

    public static function deleteFromStorage(int $user_id) : void {
        $sql = "DELETE FROM users WHERE id_user = :id_user";

        $handler = Application::$storage->get()->prepare($sql);
        $handler->execute(['id_user' => $user_id]);
    }

    public function getUserDataAsArray(): array {
        $userArray = [
            'id' => $this->idUser,
            'userlogin' => $this->userLogin,
            'username' => $this->userName, 
            'userlastname' => $this->userLastName,
            'userbirthday' => date('d-m-Y', $this->userBirthday),
            'userpassword' => $this->userPasswordHash
        ];

        return $userArray;
    }

}