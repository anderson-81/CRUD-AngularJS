<?php

require_once __DIR__ . '/../database/connection.php';
require_once __DIR__ . '/../models/physicalperson.php';
require_once __DIR__ . '/../models/user.php';

class Controller
{

    private $pp;
    private $conn;
    private $usu;

    public function __construct($pp)
    {
        $this->pp = $pp;
        $this->conn = Connection::getInstance()->getConnection();
    }

    public function setUser($usu)
    {
        $this->usu = $usu;
    }

    private function GenerateID()
    {
        try {
            $stmt = $this->conn->prepare("SELECT MAX(ID) + 1 AS ID FROM person");
            $stmt->execute();
            $id = $stmt->fetchColumn();
            if ($id == NULL) {
                return 1;
            }
            return $id;
        } catch (Exception $ex) {
            return -1;
        }
    }

    private function StartTransaction()
    {
        try {
            $this->conn->beginTransaction();
            return 1;
        } catch (Exception $ex) {
            return -1;
        }
    }

    private function Commit()
    {
        try {
            $this->conn->commit();
            return 1;
        } catch (Exception $ex) {
            return -1;
        }
    }

    private function Rollback()
    {
        try {
            $this->conn->rollBack();
            return 1;
        } catch (Exception $ex) {
            return -1;
        }
    }

    /*************************************************************************/

    private function InsertPerson($id, $name, $email)
    {
        try {
            $data = [
                'id' => $id,
                'name' => $name,
                'email' => $email,
            ];
            $sql = "INSERT INTO person VALUES (:id, :name, :email)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($data);
            $stmt = NULL;
            return 1;
        } catch (Exception $ex) {
            return -1;
        }
    }

    private function InsertPhysicalPerson()
    {
        try {
            $data = [
                'id' => $this->pp->getId(),
                'salary' => $this->pp->getSalary(),
                'birthday' => $this->pp->getBirthday(),
                'gender' => $this->pp->getGender()
            ];
            $sql = "INSERT INTO physicalperson VALUES (:id, :id, :salary, :birthday, :gender)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($data);
            $stmt = NULL;
            return 1;
        } catch (Exception $ex) {
            return -1;
        }
    }

    public function Insert_PhysicalPerson()
    {
        $this->pp->setId($this->GenerateID());
        if ($this->pp->getId() > 0) {
            if ($this->StartTransaction() == 1) {
                if ($this->InsertPerson($this->pp->getId(), $this->pp->getName(), $this->pp->getEmail()) == 1) {
                    if ($this->InsertPhysicalPerson() == 1) {
                        $this->Commit();
                        $this->conn = NULL;
                        return 1;
                    } else {
                        $this->Rollback();
                        $this->conn = NULL;
                        return -1;
                    }
                } else {
                    $this->Rollback();
                    $this->conn = NULL;
                    return -1;
                }
            } else {
                $this->conn = NULL;
                return -1;
            }
        } else {
            $this->conn = NULL;
            return -1;
        }
    }

    private function EditPerson($id, $name, $email)
    {
        try {
            $data = [
                'id' => $id,
                'name' => $name,
                'email' => $email,
            ];
            $sql = "UPDATE person SET NAME = :name, EMAIL = :email WHERE ID = :id;";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($data);
            $stmt = NULL;
            return 1;
        } catch (Exception $ex) {
            return -1;
        }
    }

    private function EditPhysicalPerson()
    {
        try {
            $data = [
                'id' => $this->pp->getId(),
                'salary' => $this->pp->getSalary(),
                'birthday' => $this->pp->getBirthday(),
                'gender' => $this->pp->getGender()
            ];
            $sql = "UPDATE physicalperson SET SALARY = :salary, BIRTHDAY = :birthday, GENDER = :gender WHERE ID = :id;";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($data);
            $stmt = NULL;
            return 1;
        } catch (Exception $ex) {
            return -1;
        }
    }

    public function Edit_PhysicalPerson()
    {
        if ($this->StartTransaction() == 1) {
            if ($this->EditPerson($this->pp->getId(), $this->pp->getName(), $this->pp->getEmail()) == 1) {
                if ($this->EditPhysicalPerson() == 1) {
                    $this->Commit();
                    $this->conn = NULL;
                    return 1;
                } else {
                    $this->Rollback();
                    $this->conn = NULL;
                    return -1;
                }
            } else {
                $this->Rollback();
                $this->conn = NULL;
                return -1;
            }
        } else {
            $this->conn = NULL;
            return -1;
        }
    }

    private function DeletePerson($id)
    {
        try {
            $data = [
                'id' => $id
            ];
            $sql = "DELETE FROM PERSON WHERE ID = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($data);
            $stmt = NULL;
            return 1;
        } catch (Exception $ex) {
            return -1;
        }
    }

    private function DeletePhysicalPerson()
    {
        try {
            $data = [
                'id' => $this->pp->getId()
            ];
            $sql = "DELETE FROM PHYSICALPERSON WHERE ID = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($data);
            $stmt = NULL;
            return 1;
        } catch (Exception $ex) {
            return -1;
        }
    }

    public function Delete_PhysicalPerson()
    {
        if ($this->StartTransaction() == 1) {
            if ($this->DeletePhysicalPerson() == 1) {
                if ($this->DeletePerson($this->pp->getId()) == 1) {
                    $this->Commit();
                    $this->conn = NULL;
                    return 1;
                } else {
                    $this->Rollback();
                    $this->conn = NULL;
                    return -1;
                }
            } else {
                $this->Rollback();
                $this->conn = NULL;
                return -1;
            }
        } else {
            $this->conn = NULL;
            return -1;
        }
    }

    public function Get_PhysicalPerson_By_Name()
    {
        try {
            $name = $this->pp->getName() . '%';
            $stmt = $this->conn->prepare("SELECT *, strftime('%Y-%m-%d',BIRTHDAY) as BIRTHDAY FROM PERSON INNER JOIN PHYSICALPERSON ON PERSON.ID = PHYSICALPERSON.PERSON_ID WHERE PERSON.NAME LIKE :name");
            $stmt->bindValue(":name", $name);
            $stmt->execute();
            $resultado = $stmt->fetchAll();
            $this->conn = NULL;
            return $resultado;
        } catch (Exception $exc) {
            return NULL;
        }
    }

    public function Get_PhysicalPerson_By_Id()
    {
        try {
            $id = $this->pp->getId();
            $stmt = $this->conn->prepare("SELECT *, strftime('%Y-%m-%d',BIRTHDAY) as BIRTHDAY FROM PERSON INNER JOIN PHYSICALPERSON ON PERSON.ID = PHYSICALPERSON.PERSON_ID WHERE PERSON.ID = :id");
            $stmt->bindValue(":id", $id);
            $stmt->execute();
            $result = $stmt->fetchAll();
            $this->conn = NULL;
            return $result;
        } catch (Exception $exc) {
            return NULL;
        }
    }

    public function Login()
    {
        try {
            $username = addslashes($this->usu->getUsername());
            $password = hash('sha512', addslashes($this->usu->getPassword()));

            $sql = "SELECT USERNAME FROM USER WHERE USERNAME = '$username' AND PASSWORD = '$password'";
            $result = $this->conn->query($sql);
            if ($result) {
                foreach ($result as $row) {
                    $col = $row[0];
                }

                if ($username == $col) {
                    $this->conn = NULL;
                    $num = hash('sha512', rand(100000, 900000));
                    session_start();
                    $_SESSION["numLogin"] = $num;
                    $_SESSION["username"] = $this->usu->getUsername();
                    return 1;
                }
                return 0;
            } else {
                $this->conn = NULL;
                return 0;
            }
        } catch (Exception $exc) {
            return -1;
        }
    }
}
