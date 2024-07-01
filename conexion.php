<?php
    Class Conexion{
        public function conectar(){
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "sistema_reservas";
            $conn = new mysqli($servername, $username, $password, $dbname);
            if(!$conn){
                die("Connection failed: " . mysqli_connect_error());
            }else{
                return $conn;
            }
        }
    }
?>