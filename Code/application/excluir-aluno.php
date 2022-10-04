<?php

$id_aluno = $_GET['id'];

$strConnection = 'mysql:host=localhost;dbname=db_biblioteca';
$db_usuario = 'root';
$db_senha = '';

try {
    $conexao = new PDO($strConnection, $db_usuario, $db_senha);
} catch (PDOException $erro) {
    echo $erro->getMessage();
    die;
}

$sql = 'DELETE from alunos WHERE id_aluno=:id;';
$stmt = $conexao->prepare($sql);
$stmt->bindParam(':id', $id_aluno);
if ($stmt->execute()) {
    $mensagem = 'Aluno excluído com sucesso';
    echo "<script>
        alert('$mensagem')
    </script>";
    header('LOCATION:../sistema.php?tela=alunos');
} else {
    $mensagem = 'Erro ao excluir o Aluno >:(';
    echo "<script>
        alert('$mensagem')s
    </script>";
    header('LOCATION:../sistema.php?tela=alunos');
}
