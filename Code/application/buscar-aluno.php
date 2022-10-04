<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html><?php

$form['id_aluno']     = isset($_POST['txtAluno'])            ?   $_POST['txtAluno']             : '';
$form['id_livro']      = isset($_POST['txtLivro'])     ?   $_POST['txtLivro']      : '';


$strConnection = 'mysql:host=localhost;dbname=db_biblioteca';                
$db_usuario = 'root';                                                    
$db_senha = '';                                                           

try {
    $conexao = new PDO($strConnection, $db_usuario, $db_senha);           
} catch (PDOException $erro) {
    echo $erro->getMessage();                                          
    exit;                                                               
}



    $sql = 'SELECT nome, multa FROM alunos WHERE id_aluno = :aluno' ;
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':aluno', $form['id_aluno']);      
    $stmt->execute();
    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (!empty($dados)) {
        foreach ($dados as $linha) {
            if($linha['multa'] > 0){
                $msg = 'Aluno com Multa';
                echo "<script>
        alert('$msg');
        window.location = '../sistema.php?tela=emprestimos';
    </script>";
            }
        }
    }
    $sql = 'SELECT nome, emprestado FROM livros WHERE id_livro = :livro' ;
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':livro', $form['id_livro']);
    $stmt->execute();
    $dadosLivro = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (!empty($dadosLivro)) {
        foreach ($dadosLivro as $linha) {
            if($linha['emprestado'] > 0){
                $msg = 'Livro já emprestado';
                echo "<script>
        alert('$msg');
        window.location = '../sistema.php?tela=emprestimos';
    </script>";
            }
        }
    }
    
echo "<script>
        window.location = '../sistema.php?tela=emprestimos&idAluno={$form['id_aluno']}&aluno={$dados[0]['nome']}&idLivro={$form['id_livro']}&livro={$dadosLivro['0']['nome']}';
    </script>";
