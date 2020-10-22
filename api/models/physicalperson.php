<?php

require_once 'person.php';

class PhysicalPerson implements Person
{
    private $id;
    private $name;
    private $email;
    private $salary;
    private $birthday;
    private $gender;

    public function setId($id)
    {
        return $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setSalary($salary)
    {
        $this->salary = $salary;
    }

    public function getSalary()
    {
        return $this->salary;
    }

    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
    }

    public function getBirthday()
    {
        return $this->birthday;
    }

    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function __construct($id, $name, $email, $salary, $birthday, $gender)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->salary = $salary;
        $this->birthday = $birthday;
        $this->gender = $gender;
    }
}
