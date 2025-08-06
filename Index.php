<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <link rel="stylesheet" href="./CadLog/Cadastro.css">
</head>

<?php
    include "Conexao.php";

    if(!empty($_SESSION['S_L_ID'])){     
?>

<body>
    <p> Voce logou!! </p>
</body>

<?php
    mysqli_close($mysqli);

    // para caso alguem tente entrar sem conta
    }else{ 
        session_unset();
        session_destroy();

        header("location: Login.php");
        exit;
    }
?>

</html>