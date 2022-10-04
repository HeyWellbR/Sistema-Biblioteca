<?php

$id_livro = $_GET['id'];

$strConnection = 'mysql:host=localhost;dbname=db_biblioteca';
$db_usuario = 'root';
$db_senha = '';

try {
    $conexao = new PDO($strConnection, $db_usuario, $db_senha);
} catch (PDOException $erro) {
    echo $erro->getMessage();
    die;
}

$sql = 'DELETE from livros WHERE id_livro=:id;';
$stmt = $conexao->prepare($sql);
$stmt->bindParam(':id', $id_livro);
if ($stmt->execute()) {
    $mensagem = 'livro excluído com sucesso';
    echo "<script>
        alert('$mensagem')
    </script>";
    header('LOCATION:../sistema.php?tela=livros');
} else {
    $mensagem = 'Erro ao excluir o livro >:(';
    echo "<script>
        alert('$mensagem')s
    </script>";
    header('LOCATION:../sistema.php?tela=livros');
}
