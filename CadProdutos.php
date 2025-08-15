<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Produtos</title>
    <link rel="stylesheet" href="./CSS/Index.css">
    <link rel="stylesheet" href="./CSS/CadProdutos.css">
    <!-- CSS do Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- JS do Bootstrap 5.3 (precisa do Popper incluso) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</head>

<?php
    include "Conexao.php";

    if(!empty($_SESSION['S_L_ID'])){     
        
        $P_NOME = '';
        $P_DESCRICAO = '';
        $P_VALOR = '';
        $P_ID = '';

        if(isset($_GET['link'])){
            $LINK = explode('&&',$_GET['link']);

            if($LINK[0] == 'Edit'){
                $P_ID = $LINK[1];

                $edit = 
                    $mysqli->query("select * from projeto_tmp.produtos where P_ID = '".$P_ID."' limit 1");
                $edit = $edit->fetch_assoc();

                $P_NOME = $edit['P_NOME'];
                $P_DESCRICAO = $edit['P_DESCRICAO'];
                $P_VALOR = $edit['P_VALOR'];
                $P_ID = $edit['P_ID'];
            }

            if($LINK[0] == 'Exc'){
                $PI_ID = $LINK[1];

                $stmt = $mysqli->prepare("delete from projeto_tmp.produtositens where PI_ID = ? ");
                $stmt->bind_param("i", $PI_ID);
                $stmt->execute();

            }
        }

        if(isset($_POST['BT_SALVAR'])){
            $P_ID = base64_decode($_POST['P_ID']);
            $P_NOME = $_POST['P_NOME'];
            $P_DESCRICAO = $_POST['P_DESCRICAO'];
            $P_VALOR = $_POST['P_VALOR'];

            if(empty($P_ID)){

                $stmt = $mysqli->prepare("insert into projeto_tmp.produtos (P_NOME, P_DESCRICAO, P_VALOR, L_ID) values (?, ?, ?, ?)");
                $stmt->bind_param("ssdi", $P_NOME, $P_DESCRICAO, $P_VALOR, $_SESSION['S_L_ID']);
                $stmt->execute();

            }elseif(!empty($P_ID)){

                $stmt = $mysqli->prepare("update projeto_tmp.produtos set P_NOME = ?, P_DESCRICAO = ?, P_VALOR = ? where P_ID = ? ");
                $stmt->bind_param("ssdi", $P_NOME, $P_DESCRICAO, $P_VALOR, $P_ID);
                $stmt->execute();

            }

            header("location: CadProdutos.php");
        }

        // Salvar imagens do jogo
        if(isset($_POST['BT_ARQUIVO'])){
            $P_ID = base64_decode($_POST['P_ID']);
            $PI_DATE = date("Y-m-d H:i:s");

            $caminho = __DIR__."/Docs/"; // Caminho absoluto para evitar problemas

            // Nome original do arquivo
            $nomeArquivo_TMP = $_FILES['PI_ARQUIVOS']['tmp_name'];

            // Nome original do arquivo
            $nomeArquivo = $_FILES['PI_ARQUIVOS']['name'];

            // Evita caracteres perigosos no nome
            $nomeArquivo = preg_replace('/[^A-Za-z0-9_\.-]/', '_', $nomeArquivo);

            $file_array = array_combine($nomeArquivo_TMP, $nomeArquivo);

            foreach($file_array as $tmp_folder => $image_name){

                // Move o arquivo para a pasta
                if (move_uploaded_file($tmp_folder, $caminho.$image_name)) {

                    $stmt = $mysqli->prepare("insert into projeto_tmp.produtositens (P_ID, PI_ARQUIVOS, L_ID, PI_DATE) values (?, ?, ?, ?)");
                    $stmt->bind_param("isis", $P_ID, $image_name, $_SESSION['S_L_ID'], $PI_DATE);
                    $stmt->execute();

                } 
            }

            echo "Arquivo enviado com sucesso!";

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
        <a href="Conexao.php?link=<?php echo urlencode("out&&sair") ?>" >Sair</a>
    </nav>

    <main>
        <div class="form-card">
            <form method="POST">
                <label>Nome:</label>
                <input type="text" required name="P_NOME" id="P_NOME" value="<?php echo $P_NOME; ?>">

                <label>Descrição:</label>
                <input type="text" name="P_DESCRICAO" id="P_DESCRICAO" value="<?php echo $P_DESCRICAO; ?>">

                <label>Valor:</label>
                <input type="number" required step="0.01" name="P_VALOR" id="P_VALOR" value="<?php echo $P_VALOR; ?>">

                <input type="hidden" name="P_ID" id="P_ID" value="<?php echo base64_encode($P_ID); ?>">

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
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="<?php echo "#MOD".$row['P_ID']; ?>">
                        Modal
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="<?php echo "MOD".$row['P_ID']; ?>" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">
                            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="TituloModalCentralizado"><?php echo $row['P_NOME']; ?></h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Fechar">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-card">
                                        <form method="POST" enctype="multipart/form-data">
                                            <Input type="hidden" name="P_ID" id="P_ID" value="<?php echo base64_encode($row['P_ID']); ?>">

                                            <label>Imagens e videos</label>
                                            <Input type="file" name="PI_ARQUIVOS[]" id="PI_ARQUIVOS[]" multiple accept="image/jpg, image/jpeg, image/png" required><br>

                                            <div class="form-actions">
                                                <Input type="submit" name="BT_ARQUIVO" value="Salvar arquivo">
                                            </div>
                                        </form>
                                    </div>

                                    <!-- Para visualizar todas as imagens inseridas -->
                                    <div class="card-grid">
                                    <?php
                                        $array_img =
                                            $mysqli->query("select
                                                                *
                                                            from
                                                                projeto_tmp.produtositens
                                                            where
                                                                P_ID = '".$row['P_ID']."' ");
                                        while($rowI = $array_img->fetch_assoc()){
 
                                    ?>
                                        
                                        <div class="card">
                                            <img src="Docs/<?php echo $rowI['PI_ARQUIVOS']?>" alt="Imagem do Produto">
                                            <a href="CadProdutos.php?link=<?php echo urlencode("Exc&&".$rowI['PI_ID']) ?>"><button class="btn btn-danger">Excluir</button></a>
                                        </div>
                                        
                                    <?php
                                        }
                                    ?>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botão de editar -->
                        <a class="btn btn-secondary" href="CadProdutos.php?link=<?php echo urlencode("Edit&&".$row['P_ID']) ?>">Editar</a>
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

</html>
