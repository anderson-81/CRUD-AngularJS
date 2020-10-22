<?php

require_once __DIR__ . '/../database/connection.php';
require_once __DIR__ . '/../factories/factory.php';

class Validation
{
    #region Singleton
    private static $instance = null;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Validation();
        }
        return self::$instance;
    }
    #endregion

    private $errors = array();

    // options: 0 => insert, 1 => edition, 2 => exclusion;
    public function ValidatePhysicalPerson($pp, $option)
    {
        #region id
        if ($option != 0) {
            if ($this->CheckIfNotNullOrEmpty($pp->getId())) {
                try {
                    intval($pp->getId());
                    if ($this->CheckRangeNumeric($pp->getId(), 1, 99999999999999)) {
                    } else {
                        $this->setError("ID outside the valid range.");
                    }
                } catch (Exception $e) {
                    $this->setError("Invalid ID.");
                }
            } else {
                $this->setError("ID is empty.");
            }
        }
        #endregion

        if ($option  != 2) {
            #region name
            if ($this->CheckIfNotNullOrEmpty($pp->getName())) {
                if ($this->CheckSizeField($pp->getName(), 3, 45)) {
                } else {
                    $this->setError("Invalid character quantity for name: [Min: 3 | Max: 45].");
                }
            } else {
                $this->setError("Name is empty.");
            }
            #endregion

            #region email
            if ($this->CheckIfNotNullOrEmpty($pp->getEmail())) {
                if ($this->CheckSizeField($pp->getEmail(), 7, 45)) {
                    if ($this->CheckRegex($pp->getEmail(), "/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]{2,4}/")) {

                        $test = 0;

                        if ($option == 0) {
                            $test = 1;
                        } else {
                            $facade = Facade::getInstance();
                            $result = $facade->Get_PhysicalPerson_By_Id($pp);
                            if ($result[0]["EMAIL"] != $pp->getEmail()) {
                                $test = 1;
                            }
                        }

                        if ($test == 1) {
                            if ($this->CheckIfNotExistsInTable($pp->getEmail(), "email", "person") == 1) {
                            } else {
                                $this->setError("E-mail already registered.");
                            }
                        }
                    } else {
                        $this->setError("Invalid E-mail.");
                    }
                } else {
                    $this->setError("Invalid character quantity for e-mail: [Min: 7 | Max: 45].");
                }
            } else {
                $this->setError("E-mail is empty.");
            }
            #endregion

            #region salary
            if ($this->CheckIfNotNullOrEmpty($pp->getSalary())) {
                try {
                    floatval($pp->getSalary());
                    if ($this->CheckRangeNumeric($pp->getSalary(), 0, 9999999999.99)) {
                    } else {
                        $this->setError("Salary outside the valid range.");
                    }
                } catch (Exception $e) {
                    $this->setError("Invalid salary.");
                }
            } else {
                $this->setError("Salary is empty.");
            }
            #endregion

            #region birthday
            if ($this->CheckIfNotNullOrEmpty($pp->getBirthday())) {
                try {
                    date(strtotime($pp->getBirthday()));
                    if ($this->CheckYear($pp->getBirthday(), -18)) {
                    } else {
                        $this->setError("Birthday outside the valid range: [-18 years]");
                    }
                } catch (Exception $e) {
                    $this->setError("Invalid Birthday.");
                }
            } else {
                $this->setError("Birthday is empty.");
            }
            #endregion

            #region gender
            if ($this->CheckIfNotNullOrEmpty($pp->getGender())) {
                if ($this->CheckSizeField($pp->getGender(), 1, 1)) {
                    if ($this->CheckRegex($pp->getGender(), "/([M{1},F{1}])/")) {
                    } else {
                        $this->setError("Invalid gender.");
                    }
                } else {
                    $this->setError("Invalid character quantity for gender: [Min: 1 | Max: 1].");
                }
            } else {
                $this->setError("Gender is empty.");
            }
            #endregion
        }
        return $this->errors;
    }

    public function ValidateUser($user)
    {
        #region name
        if ($this->CheckIfNotNullOrEmpty($user->getUsername())) {
            if ($this->CheckSizeField($user->getUsername(), 5, 45)) {
            } else {
                $this->setError("Invalid username.");
            }
        } else {
            $this->setError("Username is empty.");
        }
        #endregion

        #region name
        if ($this->CheckIfNotNullOrEmpty($user->getPassword())) {
            if ($this->CheckSizeField($user->getPassword(), 5, 45)) {
            } else {
                $this->setError("Invalid password.");
            }
        } else {
            $this->setError("Password is empty.");
        }
        #endregion
        return $this->errors;
    }

    private function setError($error)
    {
        array_push($this->errors, $error);
    }

    #region privates
    private function CheckIfNotNullOrEmpty($value)
    {
        if (!is_null($value)) {
            if ($value != "") {
                return 1;
            }
        }
        return 0;
    }

    private function CheckSizeField($value, $min, $max)
    {
        return ((strlen($value) >= $min) && (strlen($value) <= $max));
    }

    private function CheckRangeNumeric($value, $min, $max)
    {
        return (($value >= $min) && ($value <= $max));
    }

    private function CheckRegex($value, $pattern)
    {
        return preg_match($pattern, $value);
    }

    private function CheckYear($value, $year)
    {
        try {
            $dateTest = (new DateTime())->modify("-18 years");
            $dateValue = (new DateTime($value));
            return $dateValue <= $dateTest;
        } catch (Exception $ex) {
            return 0;
        }
    }

    private function CheckIfExistsInTable($value, $field, $table)
    {
        $conn = Connection::getInstance()->getConnection();
        try {
            $stmt = $conn->prepare("SELECT * FROM $table WHERE $field = :value;");
            $stmt->bindValue(":value", $value);
            $stmt->execute();
            $result = $stmt->fetchColumn();
            $conn = NULL;
            return ($result == false ? 0 : 1);
        } catch (Exception $exc) {
            return 0;
        }
    }

    private function CheckIfNotExistsInTable($value, $field, $table)
    {
        return ($this->CheckIfExistsInTable($value, $field, $table) == 0);
    }
    #endregion
}
