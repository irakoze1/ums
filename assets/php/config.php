<?php

use FFI\Exception;

class Database{
        const USERNAME = 'irth@biu.bi';
        const PASSWORD = '77500433@68Titi';

        private $dsn = "mysql: host=localhost;dbname=user_system";
        private $dbuser = "root";
        private $dbpass = "root";

        public $conn;
        public function __construct(){
            try{
                $this->conn = new PDO($this->dsn,$this->dbuser,$this->dbpass);

            }catch(PDOException $e){
                echo 'Error : '.$e->getMessage();
            }
            return$this->conn;
        }

        //Check input
        public function test_input($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);

            return $data;
        }

        //Error Success Message Alert
        public function showMessage($type,$message){
            return '<div class="alert alert-'.$type.' alert-dismissibe">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong class="text-center">'.$message.'</strong>
            </div>';
        }
    }
?>
