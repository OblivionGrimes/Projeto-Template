<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Produtos</title>
    <link rel="stylesheet" href="./CSS/Index.css">
    <link rel="stylesheet" href="./CSS/CadProdutos.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>

<?php
    include "Conexao.php";

    if(!empty($_SESSION['S_L_ID'])){     

        // Para deslogar
        $valor = urlencode("out&&sair");


        if(isset($_POST['BT_SALVAR'])){
            $P_NOME = $_POST['P_NOME'];
            $P_DESCRICAO = $_POST['P_DESCRICAO'];
            $P_VALOR = $_POST['P_VALOR'];

            $stmt = $mysqli->prepare("insert into projeto_tmp.produtos (P_NOME, P_DESCRICAO, P_VALOR, L_ID) values (?, ?, ?, ?)");
            $stmt->bind_param("ssdi", $P_NOME, $P_DESCRICAO, $P_VALOR, $_SESSION['S_L_ID']);
            $stmt->execute();

            header("location: CadProdutos.php");
        }

        // Salvar imagens do jogo
        if(isset($_POST['BT_ARQUIVO'])){
            $P_ID = base64_decode($_POST['P_ID']);

            print_r($_FILES['PI_ARQUIVOS']);
        }
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
        <div class="form-card">
            <form method="POST">
                <label>Nome:</label>
                <input type="text" required name="P_NOME" id="P_NOME" value="">

                <label>Descrição:</label>
                <input type="text" name="P_DESCRICAO" id="P_DESCRICAO" value="">

                <label>Valor:</label>
                <input type="number" required step="0.01" name="P_VALOR" id="P_VALOR" value="">

                <div class="form-actions">
                    <input type="submit" name="BT_SALVAR" value="Salvar">
                </div>
            </form>
        </div>

        <div class="produtos-tabela-container">
            <table class="produtos-tabela">
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Valor</th>
                    <th>Ações</th>
                </tr>
                <?php 
                    $array = 
                        $mysqli->query("select 
                                            a.*,
                                            b.L_NOME
                                        from
                                            projeto_tmp.produtos as a
                                        inner join
                                            projeto_tmp.sys_user as b on a.L_ID = b.L_ID 
                                        where
                                            a.L_ID = '".$_SESSION['S_L_ID']."'
                                        order by
                                            P_NOME ");
                    while($row = $array->fetch_assoc()){
                ?>
                <tr>
                    <td><?php echo $row['P_ID']; ?></td>
                    <td><?php echo $row['P_NOME']; ?></td>
                    <td><?php echo $row['P_DESCRICAO']; ?></td>
                    <td><?php echo number_format($row['P_VALOR'], 2, ',', '.'); ?></td>
                    <td> <!-- Botão para acionar modal -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="<?php echo "#MOD".$row['P_ID']; ?>">
                        Modal
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="<?php echo "MOD".$row['P_ID']; ?>" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="TituloModalCentralizado"><?php echo $row['P_NOME']; ?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-card">
                                    <form method="POST" enctype="multipart/form-data">
                                        <Input type="hidden" name="P_ID" id="P_ID" value="<?php echo base64_encode($row['P_ID']); ?>">

                                        <label>Imagem ou video</label>
                                        <Input type="file" name="PI_ARQUIVOS" id="PI_ARQUIVOS" multiple ><br>

                                        <div class="form-actions">
                                            <Input type="submit" name="BT_ARQUIVO" value="Salvar arquivo">
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            </div>
                            </div>
                        </div>
                        </div>
                    </td>

                </tr>
                <?php
                    }
                ?>
            </table>
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
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</html>
