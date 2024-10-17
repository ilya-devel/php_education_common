<?php

namespace Geekbrains\Application1\Domain\Controllers;

use Geekbrains\Application1\Application\Application;
use Geekbrains\Application1\Application\Render;
use Geekbrains\Application1\Application\Auth;
use Geekbrains\Application1\Domain\Models\User;

class UserController extends AbstractController
{

    protected array $actionsPermissions = [
        'actionHash' => ['admin', 'some'],
        'actionSave' => ['admin']
    ];

    private function checkIsAdmin(): bool
    {
        $roles = $this->getUserRoles();
        if (empty($roles)) {
            return false;
        }
        return in_array('admin', $roles);
    }

    public function actionIndex(): string
    {
        $users = User::getAllUsersFromStorage();

        $render = new Render();

        $isAdmin = $this->checkIsAdmin();

        if (!$users) {
            return $render->renderPage(
                'user-empty.tpl',
                [
                    'title' => 'Список пользователей в хранилище',
                    'message' => "Список пуст или не найден",
                    'isAdmin' => $isAdmin
                ]
            );
        } else {
            return $render->renderPage(
                'user-index.tpl',
                [
                    'title' => 'Список пользователей в хранилище',
                    'users' => $users,
                    'isAdmin' => $isAdmin
                ]
            );
        }
    }

    public function actionSave(): string
    {
        if (User::validateRequestData()) {
            $user = new User();
            $user->setParamsFromRequestData();
            $user->saveToStorage();

            $render = new Render();

            return $render->renderPage(
                'user-created.tpl',
                [
                    'title' => 'Пользователь создан',
                    'message' => "Создан пользователь " . $user->getUserName() . " " . $user->getUserLastName()
                ]
            );
        } else {
            throw new \Exception("Переданные данные некорректны");
        }
    }

    public function actionUpdate(): string
    {
        if (User::validateRequestData()) {
            $user = User::getUserByID($_GET['user_id']);
            if (empty($user)) {
                return "";
            }
            $user = $user[0];
            $user->setParamsFromRequestData();
            $user->updateToStorage($_GET['user_id']);

            $render = new Render();

            return $render->renderPage(
                'user-created.tpl',
                [
                    'title' => 'Пользователь обновлён',
                    'message' => "Обновлён пользователь " . $user->getUserName() . " " . $user->getUserLastName()
                ]
            );
        } else {
            throw new \Exception("Переданные данные некорректны");
        }
    }

    public function actionEdit(): string
    {
        $render = new Render();

        if (!isset($_GET['user_id'])) {
            return $render->renderPageWithForm(
                'user-form.tpl',
                [
                    'title' => 'Форма создания пользователя',
                    'action' => '/user/save/'
                ]
            );
        }

        $user = User::getUserByID($_GET['user_id']);
        if (empty($user)) {
            return "";
        }

        return $render->renderPageWithForm(
            'user-form.tpl',
            [
                'title' => 'Форма обновления пользователя',
                'action' => '/user/update/?user_id=' . $_GET['user_id'],
                'user' => $user[0]
            ]
        );
    }

    public function actionAuth(): string
    {
        $render = new Render();

        return $render->renderPageWithForm(
            'user-auth.tpl',
            [
                'title' => 'Форма логина',
                'auth_error' => null,
            ]
        );
    }

    public function actionHash(): string
    {
        if (isset($_GET['pass_string']) && !empty($_GET['pass_string'])) {
            return Auth::getPasswordHash($_GET['pass_string']);
        } else {
            throw new \Exception('Не возможно сгенерировать хэш, т.к. не переданы данные для генерации');
        }
    }

    public function actionLogin(): string
    {
        $result = false;

        if (isset($_POST['login']) && isset($_POST['password'])) {
            $result = Application::$auth->proceedAuth($_POST['login'], $_POST['password']);
        }

        if (!$result) {
            $render = new Render();
            return $render->renderPageWithForm(
                'user-auth.tpl',
                [
                    'title' => 'Форма логина',
                    'auth_error' => true,
                    'error_msg' => 'Неверные логин или пароль'
                ]
            );
        } else {
            header('Location: /');
            return "";
        }
    }
    public function actionLogout(): string
    {
        session_destroy();
        setcookie('user_name', '', time() - 1000, '/');
        header('Location: /');
        return '';
    }

    public function actionIndexRefresh()
    {
        $users = User::getAllUsersFromStorage();
        $userData = [];

        foreach ($users as $user) {
            $userTmpData = $user->getUserAsArray();
            if ($this->checkIsAdmin()) {
                $userTmpData['useredit'] = '/user/edit/?user_id=' . $user->getUserId();
                $userTmpData['userremove'] = '/user/remove/?user_id=' . $user->getUserId();
            }
            $userData[] = $userTmpData;
        }

        return json_encode($userData);
    }

    public function actionRemove()
    {
        if (!$this->checkIsAdmin()) {
            return "Вы не имеете прав на удаление";
        }
        if (isset($_GET['user_id'])) {
            $result = User::removeUserFromStorage($_GET['user_id']);
            if (empty($result)) {
                return "Пользователь не найден";
            } else {
                header('Location: /user/index/');
                return '';
            }
        } else {
            return "Не указан ID пользователя для удаления";
        }
    }
}