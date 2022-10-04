<?php
session_start();
$form['id_emprestimo']     = isset($_POST['txtID'])            ?   $_POST['txtID']             : '';
$form['id_aluno']      = isset($_POST['hiddenIDAluno'])     ?   $_POST['hiddenIDAluno']      : '';
$form['id_livro']    = isset($_POST['hiddenIDLivro'])    ?   $_POST['hiddenIDLivro']     : '';
$form['data']    = isset($_POST['txtRetirada'])       ?   $_POST['txtRetirada']        : '';
$form['data_devolucao']    = isset($_POST['txtDevolucao'])       ?   $_POST['txtDevolucao']        : '';
$form['id_usuario'] = isset($_SESSION['id']) ? $_SESSION['id']  : '';

$strConnection = 'mysql:host=localhost;dbname=db_biblioteca';                
$db_usuario = 'root';                                                    
$db_senha = '';                                                           

try {
    $conexao = new PDO($strConnection, $db_usuario, $db_senha);           
} catch (PDOException $erro) {
    echo $erro->getMessage();                                          
    exit;                                                               
}


if ($form['id_emprestimo'] == 'NOVO') {
    $sql = 'INSERT INTO emprestimos (data_retirada, data_devolucao, situacao, id_aluno, id_livro, id_usuario)
            VALUES (:data_retirada, :data_devolucao, 1, :id_aluno, :id_livro, :id_usuario)';
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':id_aluno', $form['id_aluno']);
    $stmt->bindParam(':id_livro', $form['id_livro']);      
    $stmt->bindParam(':id_usuario', $form['id_usuario']);

};


$stmt->bindParam(':data_retirada', $form['data']);                
$stmt->bindParam(':data_devolucao', $form['data_devolucao']);         
  

if ($stmt->execute()) {
    $mensagem = 'Sucesso';
} else {
    $mensagem = 'Erro';
}

    $sql = 'UPDATE livros SET emprestado=1 where id_livro=:id';
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':id', $form['id_livro']);
    $stmt->execute();

echo "<script>
        alert('$mensagem');
        window.location = '../sistema.php?tela=emprestimos';
    </script>";
