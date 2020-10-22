<?php

require_once __DIR__ . '/../controllers/controller.php';
require_once __DIR__ . '/../factories/factory.php';
require_once __DIR__ . '/../configs/defaultdata.php';

class Facade
{
    #region Singleton
    private static $instance = null;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Facade();
        }
        return self::$instance;
    }
    #endregion

    #region PHYSICALPERSON
    public function Insert_PhysicalPerson($pp)
    {
        $default = DefaultData::getInstance();
        $ctr = new Controller($pp);
        if($default->ValidateInsert($pp)){
            if ($ctr->Insert_PhysicalPerson() == 1) {
                return 1;
            } else {
                return -1;
            }
        }
        return 0;
    }

    public function Edit_PhysicalPerson($pp)
    {
        $default = DefaultData::getInstance();
        $ctr = new Controller($pp);
        if($default->ValidateEdit($pp)){
            if ($ctr->Edit_PhysicalPerson() == 1) {
                return 1;
            } else {
                return -1;
            }
        }
        return 0;
    }

    public function Delete_PhysicalPerson($pp)
    {
        $default = DefaultData::getInstance();
        $ctr = new Controller($pp);
        if($default->ValidateDelete($pp)){
            if ($ctr->Delete_PhysicalPerson() == 1) {
                return 1;
            } else {
                return -1;
            }
        }
        return 0;
    }

    public function Get_PhysicalPerson_By_Name($pp)
    {
        $ctr = new Controller($pp);
        return $ctr->Get_PhysicalPerson_By_Name();
    }

    public function Get_PhysicalPerson_By_Id($pp)
    {
        $ctr = new Controller($pp);
        return $ctr->Get_PhysicalPerson_By_Id();
    }
    #endregion

    #region USER
    public function Login($user)
    {
        $ctr = new Controller("");
        $ctr->setUser($user);
        return $ctr->Login();
    }
    #endregion
}
