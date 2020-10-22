<?php

require_once __DIR__ . '/../database/connection.php';
require_once __DIR__ . '/../factories/factory.php';
require_once __DIR__ . '/validation.php';

class DefaultData
{
    #region Singleton
    private static $instance = null;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new DefaultData();
        }
        return self::$instance;
    }
    #endregion

    public function ValidateInsert($pp)
    {
        $result = 1;
        
        if ($pp->getName() != "John Lee 01") {
            $result = 0;
        }

        if ($pp->getEmail() != "email@crudangularjs.com") {
            $result = 0;
        }

        if ($pp->getSalary() != "3333.33") {
            $result = 0;
        }

        if ($pp->getBirthday() != "1980-01-02") {
            $result = 0;
        }

        if ($pp->getGender() != "M") {
            $result = 0;
        }
        return $result;
    }

    public function ValidateEdit($pp)
    {
        $result = 1;
        
        if ($pp->getId() != 11) {
            $result = 0;
        }

        if ($pp->getName() != "John Lee 02") {
            $result = 0;
        }

        if ($pp->getEmail() != "email@crudangularjs.com") {
            $result = 0;
        }

        if ($pp->getSalary() != "7777.77") {
            $result = 0;
        }

        if ($pp->getBirthday() != "1990-02-01") {
            $result = 0;
        }

        if ($pp->getGender() != "M") {
            $result = 0;
        }
        return $result;
    }

    public function ValidateDelete($pp)
    {
        return $this->CheckEmail($pp);
    }

    private function CheckEmail($pp)
    {
        $conn = Connection::getInstance()->getConnection();
        try {
            $stmt = $conn->prepare("SELECT * FROM person WHERE email = 'email@crudangularjs.com' AND id = :value;");
            $stmt->bindValue(":value", $pp->getId());
            $stmt->execute();
            $result = $stmt->fetchColumn();
            $conn = NULL;
            return ($result == false ? 0 : 1);
        } catch (Exception $exc) {
            return 0;
        }
    }
}
