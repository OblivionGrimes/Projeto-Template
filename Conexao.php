<?php 
    $SERVER_NAME = 'localhost';
    $SENHA = '';
    $HOST_NAME = 'root';
    //$BD = 'projeto_tmp';

    $mysqli = new mysqli($SERVER_NAME, $HOST_NAME, $SENHA);

    date_default_timezone_set('America/Bahia');

    if($mysqli->connect_error){
        echo "conexão falhou";
    }

    session_start();

    if(isset($_GET['link'])){
        $LINK = explode('&&',$_GET['link']);

        if($LINK[0] == 'success'){
            $query_session =
                $mysqli->query("select
                                    *
                                from
                                    projeto_tmp.sys_user
                                where
                                    L_ID = '".$LINK[1]."' ");

            $QuerryPrincipal = $query_session->fetch_assoc();

            if(!empty($QuerryPrincipal['L_ID'])){

                $_SESSION['S_L_ID'] = $QuerryPrincipal['L_ID'];
                $_SESSION['S_L_NOME'] = $QuerryPrincipal['L_NOME'];
                $_SESSION['S_L_EMAIL'] = $QuerryPrincipal['L_EMAIL'];

                header("location: index.php");
                exit;
            }elseif(empty($QuerryPrincipal['L_ID']) ){
                session_unset();
                session_destroy();

                header("location: Login.php?error=1");
                exit;
            }
        }
    }

?>