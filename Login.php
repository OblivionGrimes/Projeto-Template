<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./CadLog/Cadastro.css">
</head>
<body style='background-color: hsla(50, 33%, 25%, 0.75);'> <!-- temporario esse style -->

    <?php
        include "Conexao.php";

        if(isset($_GET['success'])){
            echo "Cadastro realizado com sucesso!!";
        }

        if(isset($_REQUEST['BT_SALVAR'])){

        }
    ?>

    <div class="div_principal">
        <Form method='POST'>
            <Label>Email:</label>
            <Input name='L_EMAIL' id='L_EMAIL' type='email' value='<?php echo $_POST['L_EMAIL'] ?? ''; ?>'></Input><br>
            <Label>Senha:</label>
            <Input name='L_SENHA' id='L_SENHA' type='password'></Input><br>
            <Input name='BT_SALVAR' type='submit' value='Acessar'></Input>
        </Form>
    </div>
</body>
</html>