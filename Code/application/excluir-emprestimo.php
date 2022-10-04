<?php

$id_emp = $_GET['id'];

$strConnection = 'mysql:host=localhost;dbname=db_biblioteca';
$db_usuario = 'root';
$db_senha = '';

try {
    $conexao = new PDO($strConnection, $db_usuario, $db_senha);
} catch (PDOException $erro) {
    echo $erro->getMessage();
    die;
}

$sql = 'DELETE from emprestimos WHERE id_emprestimo=:id;';
$stmt = $conexao->prepare($sql);
$stmt->bindParam(':id', $id_emp);
if ($stmt->execute()) {
    $mensagem = 'Empréstimo excluído com sucesso';
    echo "<script>
        alert('$mensagem')
    </script>";
    header('LOCATION:../sistema.php?tela=emprestimos');
} else {
    $mensagem = 'Erro ao excluir o Empréstimo >:(';
    echo "<script>
        alert('$mensagem')s
    </script>";
    header('LOCATION:../sistema.php?tela=emprestimos');
}
