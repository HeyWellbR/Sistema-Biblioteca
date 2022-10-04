<?php

$form['id_livro']     = isset($_POST['txtID'])            ?   $_POST['txtID']             : '';
$form['nome']      = isset($_POST['txtNome'])     ?   $_POST['txtNome']      : '';
$form['editora']    = isset($_POST['txtEditora'])    ?   $_POST['txtEditora']     : '';
$form['genero']    = isset($_POST['txtGenero'])       ?   $_POST['txtGenero']        : '';

$strConnection = 'mysql:host=localhost;dbname=db_biblioteca';                
$db_usuario = 'root';                                                    
$db_senha = '';                                                           

try {
    $conexao = new PDO($strConnection, $db_usuario, $db_senha);           
} catch (PDOException $erro) {
    echo $erro->getMessage();                                          
    exit;                                                               
}


if ($form['id_livro'] == 'NOVO') {
    $sql = 'INSERT INTO livros (nome, editora, genero)
            VALUES (:nome, :editora, :genero)';
    $stmt = $conexao->prepare($sql);

} else {
    $sql = 'UPDATE livros SET nome=:nome, editora=:editora, genero=:genero where id_livro=:id';
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':id', $form['id_livro']);
}


$stmt->bindParam(':nome', $form['nome']);                
$stmt->bindParam(':editora', $form['editora']);         
$stmt->bindParam(':genero', $form['genero']);       

if ($stmt->execute()) {
    $mensagem = 'Sucesso';
} else {
    $mensagem = 'Erro';
}


echo "<script>
        alert('$mensagem');
        window.location = '../sistema.php?tela=livros';
    </script>";
