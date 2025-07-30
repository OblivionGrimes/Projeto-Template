<?php 
    $SERVER_NAME = 'localhost';
    $SENHA = '';
    $HOST_NAME = 'root';
    //$BD = 'projeto_tmp';

    $mysqli = new mysqli($SERVER_NAME, $HOST_NAME, $SENHA);

    date_default_timezone_set('America/Bahia');

    if($mysqli->connect_error){
        echo "conexão falhou";
    }/*else{
        echo "tudo certo";
    }*/

    //mysqli_close($mysqli);
?>