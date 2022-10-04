<?php

$id_emp = $_GET['id'];
$id_livro = $_GET['id_livro'];
$status = 0;
$strConnection = 'mysql:host=localhost;dbname=db_biblioteca';
$db_usuario = 'root';
$db_senha = '';

try {
    $conexao = new PDO($strConnection, $db_usuario, $db_senha);
} catch (PDOException $erro) {
    echo $erro->getMessage();
    die;
}

$sql = 'UPDATE livros SET emprestado=0 where id_livro=:id';
$stmt = $conexao->prepare($sql);
$stmt->bindParam(':id', $id_livro);
$stmt->execute();

$sql = 'UPDATE emprestimos SET situacao=:situacao where id_emprestimo=:id';
$stmt = $conexao->prepare($sql);
$stmt->bindParam(':id', $id_emp);
$stmt->bindParam(':situacao', $status);
if ($stmt->execute()) {
    $mensagem = 'Empréstimo devolvido com sucesso';
    echo "<script>
        alert('$mensagem')
    </script>";
    header('LOCATION:../sistema.php?tela=emprestimos');
} else {
    $mensagem = 'Erro ao devolver o empréstimo';
    echo "<script>
        alert('$mensagem')s
    </script>";
    header('LOCATION:../sistema.php?tela=emprestimos');
}
