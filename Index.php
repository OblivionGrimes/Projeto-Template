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
        $logout = urlencode("out&&sair");
?>

<body>
    <header>
        <h1>Bem-vindo <?php echo $_SESSION['S_L_NOME'] ?></h1>
    </header>

    <nav>
        <a href="index.php">Início</a>
        <a href="CadProdutos.php">Cadastrar produtos</a>
        <a href="">Meus Produtos</a>
        <a href="Conexao.php?link=<?php echo $logout ?>" >Sair</a>
    </nav>

    <main>

        <div class="card-grid">
            <?php
                $array =
                    $mysqli->query("select 
                                        P.*,
                                        (select PI_ARQUIVOS from `projeto_tmp`.produtositens as PI where P.P_ID = PI.P_ID limit 1) as PI_ARQUIVOS
                                    from
                                        `projeto_tmp`.produtos as P
                                    order by
                                        P_NOME"); 
                while($row = $array->fetch_assoc()){
            ?>

            <div class="card">
                <img src="Docs/<?php echo $row['PI_ARQUIVOS']?>" alt="Imagem do Produto">
                <h3><?php echo $row['P_NOME'] ?></h3>
                <p><?php echo $row['P_DESCRICAO'] ?></p>
                <h4><?php echo number_format($row['P_VALOR'],2,',','.') ?></h4>
                <a href="#"><button>Comprar</button></a>
            </div>

            <?php
                } // do while
            ?>
        </div>

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