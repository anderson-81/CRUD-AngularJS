<?php

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: POST, GET, OPTION');
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require_once __DIR__ . '/facades/facade.php';
require_once __DIR__ . '/configs/validation.php';

ignore_user_abort(true);
error_reporting(0);
session_start();
$errors = [];

if (isset($_SESSION['username'])) {

    $post = json_decode(file_get_contents("php://input"));
    $option = htmlspecialchars(addslashes(trim($post->option)));
    $hash = htmlspecialchars(addslashes(trim($post->token)));

    if (isset($option)) {

        #region Insert Physical Person
        if ($option == 1) {
            if ($_SESSION['_token'] == $hash) {
                DestroyToken();
                $pp = CreatePhysicalPersonFromPost($post);
                $errors = ValidatePhysicalPerson($pp, 0);
                if (ValidatePhysicalPerson($pp, 0) == []) {
                    $facade = Facade::getInstance();
                    echo json_encode($facade->Insert_PhysicalPerson($pp));
                } else {
                    DestroyToken();
                    echo json_encode($errors);
                }
            } else {
                DestroyToken();
                echo json_encode(-1);
            }
        }
        #endregion

        #region Edit Physical Person
        if ($option == 2) {
            if ($_SESSION['_token'] == $hash) {
                DestroyToken();
                $pp = CreatePhysicalPersonFromPost($post);
                $errors = ValidatePhysicalPerson($pp, 1);
                if ($errors == []) {
                    $facade = Facade::getInstance();
                    echo json_encode($facade->Edit_PhysicalPerson($pp));
                } else {
                    DestroyToken();
                    echo json_encode($errors);
                }
            } else {
                DestroyToken();
                echo json_encode(-1);
            }
        }
        #endregion

        #region Edit Physical Person
        if ($option == 3) {
            if ($_SESSION['_token'] == $hash) {
                DestroyToken();
                $pp = CreatePhysicalPersonFromPost($post);
                $errors = ValidatePhysicalPerson($pp, 2);
                if ($errors == []) {
                    $facade = Facade::getInstance();
                    echo json_encode($facade->Delete_PhysicalPerson($pp));
                } else {
                    DestroyToken();
                    echo json_encode($errors);
                }
            } else {
                DestroyToken();
                echo json_encode(-1);
            }
        }
        #endregion

        #region Get_PhysicalPerson_By_Name
        if ($option == 4) {
            if ($_SESSION['_token'] == $hash) {
                $pp = CreatePhysicalPersonFromPost($post);
                DestroyToken();
                $facade = Facade::getInstance();
                echo json_encode($facade->Get_PhysicalPerson_By_Name($pp));
            } else {
                echo json_encode(-1);
            }
        }
        #endregion

        #region Get_PhysicalPerson_By_Id
        if ($option == 5) {
            if ($_SESSION['_token'] == $hash) {
                $pp = CreatePhysicalPersonFromPost($post);
                DestroyToken();
                $facade = Facade::getInstance();
                echo json_encode($facade->Get_PhysicalPerson_By_Id($pp));
            } else {
                DestroyToken();
                echo json_encode(-1);
            }
        }
        #endregion

        #region CheckSession
        if ($option == 7) {
            echo CheckSession();
        }
        #endregion

        #region session_destroy
        if ($option == 8) {
            if (session_destroy()) {
                echo json_encode(1);
            } else {
                echo json_encode(-1);
            }
        }
        #endregion

        #region Token
        if ($option == 9) {
            echo Token();
        }
        #endregion
    }
} else {
    $post = json_decode(file_get_contents("php://input"));
    $option = htmlspecialchars(addslashes(trim($post->option)));

    #region Login
    if ($option == 6) {
        $hash = htmlspecialchars(addslashes(trim($post->token)));
        if ($_SESSION['_token'] == $hash) {
            DestroyToken();
            $user = CreateUserFromPost($post);
            $errors = ValidateUser($user);
            if ($errors == []) {
                $facade = Facade::getInstance();
                echo json_encode($facade->Login($user));
            } else {
                DestroyToken();
                echo json_encode($errors);
            }
        } else {
            DestroyToken();
            echo json_encode(-1);
        }
    }
    #endregion

    #region CheckSession
    if ($option == 7) {
        echo CheckSession();
    }
    #endregion

    #region Token
    if ($option == 9) {
        echo Token();
    }
    #endregion
}

#region Methods
function CheckSession()
{
    if (isset($_SESSION['username'])) {
        return json_encode(1);
    } else {
        return json_encode(0);
    }
}

function DestroyToken()
{
    unset($_SESSION['_token']);
}

function Token()
{
    session_start();
    $_SESSION['_token'] = hash('sha512', rand(100, 10000));
    echo json_encode($_SESSION['_token']);
}

function CreatePhysicalPersonFromPost($post)
{
    $pp = NULL;

    if (isset($post->data)) {

        if (preg_match("/^\d+$/", htmlspecialchars(addslashes(trim($post->data)))))
            $id = htmlspecialchars(addslashes(trim($post->data)));
        else
            $name = htmlspecialchars(addslashes(trim($post->data)));

        $pp = Factory::CreatePhysicalPerson(
            htmlspecialchars(isset($id) ? $id : 0),
            htmlspecialchars(isset($name) ? $name : ""),
            "",
            0.0,
            "",
            ""
        );
    } else {
        $pp = Factory::CreatePhysicalPerson(
            htmlspecialchars(isset($post->id) ? addslashes(trim($post->id)) : 0),
            htmlspecialchars(isset($post->name) ? addslashes(trim($post->name)) : ""),
            htmlspecialchars(isset($post->email) ? addslashes(trim($post->email)) : ""),
            htmlspecialchars(isset($post->salary) ? addslashes(trim($post->salary)) : 0.0),
            htmlspecialchars(isset($post->birthday) ? addslashes(trim($post->birthday)) : ""),
            htmlspecialchars(isset($post->gender) ? addslashes(trim($post->gender)) : "")
        );
    }
    return $pp;
}

function ValidatePhysicalPerson($pp, $option)
{
    $validate = Validation::getInstance();
    return $validate->ValidatePhysicalPerson($pp, $option);
}

function ValidateUser($user)
{
    $validate = Validation::getInstance();
    return $validate->ValidateUser($user);
}

function CreateUserFromPost($post)
{
    $user = NULL;

    $user = Factory::CreateUser(
        0,
        htmlspecialchars(isset($post->username) ? addslashes(trim($post->username)) : ""),
        htmlspecialchars(isset($post->password) ? addslashes(trim($post->password)) : "")
    );

    return $user;
}
#endregion
