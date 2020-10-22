<?php

require_once __DIR__ . '/../models/physicalperson.php';
require_once __DIR__ . '/../models/user.php';

class Factory
{
    public static function CreatePhysicalPerson($id, $name, $email, $salary, $birthday, $gender)
    {
        return new PhysicalPerson($id, $name, $email, $salary, $birthday, $gender);
    }

    public static function CreateUser($id, $username, $password)
    {
        return new User($id, $username, $password);
    }
}
