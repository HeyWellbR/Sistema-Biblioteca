<?php
    $usuario = isset($_POST['txtUser']) ? $_POST['txtUser'] : '';
    $senha = isset($_POST['txtSenha']) ? $_POST['txtSenha'] : '';
    if (empty($usuario) &&  empty($senha)) {

        header('LOCATION: ../index.php');
    };
    $strConnection = 'mysql:host=localhost;dbname=db_biblioteca';
    $db_usuario = 'root';
    $db_senha = '';

    $conexao = new PDO($strConnection, $db_usuario, $db_senha);

    $sql = 'SELECT id_usuario, usuario from usuarios where usuario =:user and senha=:pass ';
    $stmt = $conexao->prepare($sql,);
    $stmt->bindParam(':user', $usuario);
    $stmt->bindParam(':pass', $senha);
    $stmt->execute();

    if (!$stmt->rowCount() > 0) {
        echo '<script>
                    alert(\'Senha ou login errados\');
                    document.location = "../index.php";
                </script>';
    } else {
        $dados = $stmt->fetch(PDO::FETCH_ASSOC);

        session_start();
        $_SESSION['logado'] = true;
        $_SESSION['id'] = $dados['id_usuario'];
        $_SESSION['nome'] = $dados['nome'];
        header('LOCATION: ../sistema.php');
    };
?>