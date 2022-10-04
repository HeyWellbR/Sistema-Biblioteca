<?php
date_default_timezone_set('America/Sao_Paulo');
$data = date('Y-m-d H:i:s');
$dataFinal = date('Y-m-d H:i:s', strtotime('+7 days'));
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Empréstimos</h1>
</div>

<form method="POST" action="application/inserir-atualizar-emprestimo.php">
    <div class="row g-3">
        <input type="text" hidden name="hiddenIDAluno" <?php echo isset($_GET['idAluno']) ? "value='{$_GET['idAluno']}'" : "value=''"; ?>>
        <input type="text" hidden name="hiddenIDLivro" <?php echo isset($_GET['idLivro']) ? "value='{$_GET['idLivro']}'" : "value=''"; ?>>
        <div class="col-sm-4">
            <label for="txtID" class="form-label">ID</label>
            <input type="text" class="form-control" id="txtID" name="txtID" readonly required <?php echo isset($_GET['id']) ? "value='{$_GET['id']}'" : "value='NOVO'"; ?>>
        </div>
        <div class="col-sm-4">
            <label for="txtAluno" class="form-label">Aluno</label>
            <input type="text" class="form-control" id="txtAluno" name="txtAluno" placeholder="Nome do Aluno"  readonly required <?php echo isset($_GET['aluno']) ? "value='{$_GET['aluno']}'" : "value=''"; ?>>
        </div>
        <div class="col-sm-4">
            <label for="txtLivro" class="form-label">Livro</label>
            <input type="text" class="form-control" id="txtLivro" name="txtLivro" placeholder="Nome do Aluno" readonly required <?php echo isset($_GET['livro']) ? "value='{$_GET['livro']}'" : "value=''"; ?>>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-sm-6">
            <label for="txtRetirada" class="form-label">DataRetirada</label>
            <input type="text" class="form-control" id="txtRetirada" name="txtRetirada" placeholder="Gerada Automaticamente" required <?php echo isset($_GET['retirada']) ? "value='{$_GET['retirada']}'" : "value='$data'"; ?>>
        </div>
        <div class="col-sm-6">
            <label for="txtDevolucao" class="form-label">DataDevolução</label>
            <input type="text" class="form-control" id="txtDevolucao" name="txtDevolucao" placeholder="7 dias à partir de hoje" required <?php echo isset($_GET['devolucao']) ? "value='{$_GET['devolucao']}'" : "value='$dataFinal'"; ?>>
        </div>
        
    </div>


    <div class="row g-3 pt-3">
    <div class="col-sm-4">
            <button class="w-100 btn btn-secondary btn-lg" href="" type="reset" id="btnCancelar">Cancelar</button>
        </div>
        <div class="col-sm-4">
            <a class="w-100 btn btn-secondary btn-lg" href="#addTudo"data-toggle="modal" id="btnCancelar" style="background-color: #00A300;">Adicionar Aluno/Livro</a>
        </div>
        <div class="col-sm-4">
            <button class="w-100 btn btn-primary btn-lg" type="submit" id="btnSalvar">Salvar</button>
        </div>
    </div>
</form>



<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h2>Listagem de Empréstimos Ativos</h2>
</div>

<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Aluno</th>
                <th scope="col">Livro</th>
                <th scope="col">Data Retirada</th>
                <th scope="col">Data Limite Devolucao</th>
                <th scope="col">Ações</th>
                <th scope="col"> </th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Conectando ao BD com PDO
            $strConnection = 'mysql:host=localhost;dbname=db_biblioteca;charset=UTF8';
            $db_usuario = 'root';
            $db_senha = '';

            // Tratamento de erros
            try {
                $conexao = new PDO($strConnection, $db_usuario, $db_senha);
            } catch (PDOException $erro) {
                echo $erro->getMessage();
                exit;
            }

            // Definindo e executando a query SQL
            $sql = 'SELECT emprestimos.id_emprestimo, alunos.nome as nomeAluno, livros.nome as nomeLivro, emprestimos.data_retirada, emprestimos.data_devolucao, emprestimos.id_aluno, emprestimos.id_livro FROM emprestimos INNER JOIN alunos ON alunos.id_aluno = emprestimos.id_aluno INNER JOIN livros ON livros.id_livro = emprestimos.id_livro where situacao = 1';
            $stmt = $conexao->prepare($sql);
            $stmt->execute();
            $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Imprimindo os dados na tabela
            if (!empty($dados)) {
                foreach ($dados as $linha) {

                    $date1 = new DateTime($linha['data_devolucao']);
                    $date2 = new DateTime(date('Y-m-d H:i:s')); // Can use date/string just like strtotime.
                    if($date1 < $date2){
                        $sql = "UPDATE emprestimos SET situacao=2 where id_emprestimo={$linha['id_emprestimo']}";
                        $stmt = $conexao->prepare($sql);
                        $stmt->execute();

                    }else{
                    echo "<tr>
                            <td>{$linha['id_emprestimo']}</td>
                            <td>{$linha['nomeAluno']}</td>
                            <td>{$linha['nomeLivro']}</td>
                            <td>{$linha['data_retirada']}</td>
                            <td>{$linha['data_devolucao']}</td>
                            
                            <td>
                                <a href='application/devolver-emprestimo.php?id={$linha['id_emprestimo']}&id_livro={$linha['id_livro']}'>Devolver</a>
                            </td>
                            <td>
                                <a onclick=\"excluirProduto({$linha['id_emprestimo']})\" href='#'><i class=\"fa-solid fa-trash-can\"></i></a>
                            </td>
                            
                        </tr>";
                    } 
                }
            } else {
                echo "<tr>
                        <td colspan='7'>Nenhum empréstimo cadastrado.</td>
                    </tr>";
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="7"><strong><?php echo 'Total: ' . count($dados); ?></strong></td>
            </tr>
        </tfoot>
    </table>
</div>



<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h2>Listagem de Empréstimos Devolvidos</h2>
</div>

<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Aluno</th>
                <th scope="col">Livro</th>
                <th scope="col">Data Retirada</th>
                <th scope="col">Data Limite Devolução</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Conectando ao BD com PDO
            $strConnection = 'mysql:host=localhost;dbname=db_biblioteca;charset=UTF8';
            $db_usuario = 'root';
            $db_senha = '';

            // Tratamento de erros
            try {
                $conexao = new PDO($strConnection, $db_usuario, $db_senha);
            } catch (PDOException $erro) {
                echo $erro->getMessage();
                exit;
            }

            // Definindo e executando a query SQL
            $sql = 'SELECT emprestimos.id_emprestimo, alunos.nome as nomeAluno, livros.nome as nomeLivro, emprestimos.data_retirada, emprestimos.data_devolucao, emprestimos.id_aluno, emprestimos.id_livro FROM emprestimos INNER JOIN alunos ON alunos.id_aluno = emprestimos.id_aluno INNER JOIN livros ON livros.id_livro = emprestimos.id_livro where situacao = 0';
            $stmt = $conexao->prepare($sql);
            $stmt->execute();
            $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Imprimindo os dados na tabela
            if (!empty($dados)) {
                foreach ($dados as $linha) {
                    echo "<tr>
                            <td>{$linha['id_emprestimo']}</td>
                            <td>{$linha['nomeAluno']}</td>
                            <td>{$linha['nomeLivro']}</td>
                            <td>{$linha['data_retirada']}</td>
                            <td>{$linha['data_devolucao']}</td>
                            
                            <td>
                                <a onclick=\"excluirProduto({$linha['id_emprestimo']})\" href='#'><i class=\"fa-solid fa-trash-can\"></i></a> 
                                </td>
                            
                        </tr>";
                }
            } else {
                echo "<tr>
                        <td colspan='6'>Nenhum empréstimo devolvido.</td>
                    </tr>";
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6"><strong><?php echo 'Total: ' . count($dados); ?></strong></td>
            </tr>
        </tfoot>
    </table>
</div>


<div id="addTudo" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form method="POST" action="application/buscar-aluno.php">
					<div class="modal-header">
						<h4 class="modal-title">Digite os dados para a busca</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label>ID Aluno</label>
							<input type="text" class="form-control" name="txtAluno" >
						</div>
						<div class="form-group">
							<label>ID livro</label>
							<input type="text" class="form-control" name="txtLivro" >
						</div>
					</div>
					<div class="modal-footer">
						<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
						<input type="submit" class="btn btn-success" value="Buscar">
					</div>
				</form>
			</div>
		</div>
	</div>



<script>
    function excluirProduto(id) {
        var resposta = confirm('Desejas realmente excluir?');
        if (resposta) {
            window.location = "application/excluir-emprestimo.php?id=" + id;

        }
    }
</script>
