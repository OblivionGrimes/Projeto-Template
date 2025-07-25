<?php 
    $SERVER_NAME = 'localhost';
    $SENHA = '';
    $HOST_NAME = 'root';
    //$BD = 'projeto_tmp';

    $mysqli = new mysqli($SERVER_NAME, $HOST_NAME, $SENHA);

    if($mysqli->connect_error){
        echo "conexão falhou";
    }else{
        echo "tudo certo";
    }

    mysqli_close($mysqli);
?>