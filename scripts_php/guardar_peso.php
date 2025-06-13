<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $valor = $_POST["caja_valor"];
        $dato = substr($valor, 0, -6);
        $peso = substr($dato, 1);
        
        echo "Peso: $peso kg"; 
        if ($peso >0){
            include("conexion.php");
            $conn=conectar();
            $arete=1;
            $fecha=date("d/m/Y");
            
            $sql = "INSERT INTO bascula (id_pesaje, id_arete, peso, fecha) VALUES (0, '$arete', '$peso', '$fecha')";
            if (mysqli_query($conn, $sql)) {
                 echo " - registro guardado ";
            } else {
              echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
            mysqli_close($conn);
        }        
    }
?>