<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<?php
    include "Conexao.php";

    if(isset($_POST['BT_SALVAR'])){

        $L_NOME = $_POST['L_NOME'];
        $L_EMAIL = $_POST['L_EMAIL'];
        $L_SENHA = $_POST['L_SENHA'];
        $L_TIPO = $_POST['L_TIPO_USER'];
        $L_DATA = date("Y-m-d H:i:s");

        $stmt = $mysqli->prepare("insert into projeto_tmp.sys_user (L_NOME, L_EMAIL, L_SENHA, L_TIPO, L_DATA) values (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssis",$L_NOME, $L_EMAIL, $L_SENHA, $L_TIPO, $L_DATA);
        $stmt->execute();

        header("Location: Cadastro.php?success=1");
    }
?>

<body style='background-color: hsla(50, 33%, 25%, 0.75);'> <!-- temporario esse style -->
    <div>
        <?php
            if(isset($_GET['success'])){
                echo "Cadastro realizado com sucesso!!";
            }
        ?>
        <Form method='POST'>
            <Label>Nome:</label>
            <Input name='L_NOME' id='L_NOME' type='text'></Input><br>
            <Label>Email:</label>
            <Input name='L_EMAIL' id='L_EMAIL' type='email'></Input><br>
            <Label>Senha:</label>
            <Input name='L_SENHA' id='L_SENHA' type='password'></Input><br>
            <p>Este cadastro é para comerciante?</p>
            <input type="radio" id='L_TIPO_USER' name="L_TIPO_USER" value="1">
            <label for="L_TIPO_USER">Sim</label><br>
            <input type="radio" id='L_TIPO_USER' name="L_TIPO_USER" value="2">
            <label for="L_TIPO_USER">Não</label><br>
            <Input name='BT_SALVAR' type='submit' value='Salvar'></Input>
        </Form>
    </div>
</body>
<?php
    mysqli_close($mysqli);
?>
</html>