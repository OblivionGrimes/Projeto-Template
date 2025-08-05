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

        if(isset($_GET['success']) or isset($_GET['error'])){
            if(isset($_GET['success'])){
                echo "Cadastro realizado com sucesso!!";
            }
            if(isset($_GET['error'])){
                echo "Email ou senha estão incorretos!!";
            }
        }

        if(isset($_REQUEST['BT_SALVAR'])){
            $L_EMAIL = $_POST['L_EMAIL'];
            $L_SENHA = $_POST['L_SENHA'];

            $array_verifica =
                $mysqli->query("select 
                                    1 
                                from 
                                    projeto_tmp.sys_user 
                                where 
                                    L_EMAIL = '".$L_EMAIL."' and 
                                    L_SENHA = '".$L_SENHA."' 
                                limit 1");
            $result = $array_verifica->fetch_all();

            if($result[0][0] == 1){
                header("location: Index.php");
            }else{
                header("location: Login.php?error=1");
            }
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
<?php
    mysqli_close($mysqli);
?>
</html>