<?php
    function conectar(){
        $servername = "localhost";
        $database = "ranchov";
        $username = "root";
        $password = "";
        // Create connection
         $conn = mysqli_connect($servername, $username, $password, $database);
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        else{
            echo "  &#161;Conexión éxitosa! ";
        }
        return $conn;
    }
?>