<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <link rel="stylesheet" href="./CSS/Index.css">
</head>

<?php
    include "Conexao.php";

    if(!empty($_SESSION['S_L_ID'])){     

        // Para deslogar
        $valor = urlencode("out&&sair");
?>

<body>
    <header>
        <h1>Bem-vindo <?php echo $_SESSION['S_L_NOME'] ?></h1>
    </header>

    <nav>
        <a href="index.php">Início</a>
        <a href="">Cadastrar produtos</a>
        <a href="">Meus Produtos</a>
        <a href="Conexao.php?link=<?php echo $valor ?>" >Sair</a>
    </nav>

    <main>
        <h2>Página Inicial</h2>
        <p>Este é um exemplo de template com HTML e CSS puro.</p>
    </main>

    <footer>
        &copy; 2025 - Meu Site
    </footer>
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