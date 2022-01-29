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

        //Display Time in ago
        public function timeInAgo($timestamp){
            
            date_default_timezone_set('Africa/Bujumbura');

            $timestamp = strtotime($timestamp) ? strtotime($timestamp) : $timestamp;

            $time = time() - $timestamp;

            switch($time){
                //Seconds
                case $time <= 60:
                    return 'Just Now!';
                    break;
                //Minutes
                case $time >= 60 && $time < 3600:
                    return (round($time/60) == 1) ? 'A Minute ago' : round($time/60).' Minutes ago';
                    break;
                //Hours
                case $time >= 3600 && $time < 86400:
                    return (round($time/3600) == 1)? 'A Hour ago' : round($time/3600).' Hours ago';
                    break;
                //Days
                case $time >= 86400 && $time < 604800:
                    return (round($time/86400) == 1)? 'A Day ago' : round($time/86400).' Days ago';
                    break;
                //Weeks
                case $time >= 604800 && $time < 2600640:
                    return (round($time/604800) == 1)? 'a Week ago' : round($time/604800).' Weeks ago';
                    break;
                //Months
                case $time >= 2600640 && $time < 31207680:
                    return (round($time/2600640) == 1)? 'A Month ago' : round($time/2600640).' Months ago';
                    break;
                //Years
                case $time >= 31207680:
                    return (round($time/31207680) == 1)? 'a Year ago' : round($time/31207680).' Years ago';
                    break;

                default:
                    break;
            }
        }
    }
?>
