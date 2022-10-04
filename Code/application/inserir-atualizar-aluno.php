<?php

$form['id_aluno']     = isset($_POST['txtID'])            ?   $_POST['txtID']             : '';
$form['nome']      = isset($_POST['txtNome'])     ?   $_POST['txtNome']      : '';
$form['cpf']    = isset($_POST['txtCpf'])    ?   $_POST['txtCpf']     : '';
$form['telefone']    = isset($_POST['txtTelefone'])       ?   $_POST['txtTelefone']        : '';
$form['sexo']    = isset($_POST['txtSexo'])       ?   $_POST['txtSexo']        : '';

$strConnection = 'mysql:host=localhost;dbname=db_biblioteca';                
$db_usuario = 'root';                                                    
$db_senha = '';                                                           

try {
    $conexao = new PDO($strConnection, $db_usuario, $db_senha);           
} catch (PDOException $erro) {
    echo $erro->getMessage();                                          
    exit;                                                               
}


if ($form['id_aluno'] == 'NOVO') {
    $sql = 'INSERT INTO alunos (nome, cpf, telefone, sexo)
            VALUES (:nome, :cpf, :telefone, :sexo)';
    $stmt = $conexao->prepare($sql);

} else {
    $sql = 'UPDATE alunos SET nome=:nome, cpf=:cpf, telefone=:telefone, sexo=:sexo where id_aluno=:id';
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':id', $form['id_aluno']);
}


$stmt->bindParam(':nome', $form['nome']);                
$stmt->bindParam(':cpf', $form['cpf']);         
$stmt->bindParam(':telefone', $form['telefone']);
$stmt->bindParam(':sexo', $form['sexo']);       

if ($stmt->execute()) {
    $mensagem = 'Sucesso';
} else {
    $mensagem = 'Erro';
}


echo "<script>
        alert('$mensagem');
        window.location = '../sistema.php?tela=alunos';
    </script>";
