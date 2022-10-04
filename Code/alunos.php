
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Alunos</h1>
</div>

<form method="POST" action="application/inserir-atualizar-aluno.php">
    <div class="row g-3">
        <div class="col-sm-4">
            <label for="txtID" class="form-label">ID</label>
            <input type="text" class="form-control" id="txtID" name="txtID" readonly required <?php echo isset($_GET['id']) ? "value='{$_GET['id']}'" : "value='NOVO'"; ?>>
        </div>
        <div class="col-sm-4">
            <label for="txtNome" class="form-label">Nome</label>
            <input type="text" class="form-control" id="txtNome" name="txtNome" placeholder="Nome do Aluno" required <?php echo isset($_GET['nome']) ? "value='{$_GET['nome']}'" : "value=''"; ?>>
        </div>
        <div class="col-sm-4">
            <label for="txtCpf" class="form-label">CPF</label>
            <input type="text" class="form-control" id="txtCpf" name="txtCpf" placeholder="Nome do Aluno" required <?php echo isset($_GET['cpf']) ? "value='{$_GET['cpf']}'" : "value=''"; ?>>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-sm-4">
            <label for="txtTelefone" class="form-label">Telefone</label>
            <input type="text" class="form-control" id="txtTelefone" name="txtTelefone" placeholder="Nº aluno" required <?php echo isset($_GET['telefone']) ? "value='{$_GET['telefone']}'" : "value=''"; ?>>
        </div>
        <div class="col-sm-4">
            <label for="txtSexo" class="form-label">Sexo</label>
            <input type="text" class="form-control" id="txtSexo" name="txtSexo" placeholder="Sexo do Aluno" required <?php echo isset($_GET['sexo']) ? "value='{$_GET['sexo']}'" : "value=''"; ?>>
        </div>
        <div class="col-sm-4">
            <label for="txtMulta" class="form-label">Multa</label>
            <input type="text" class="form-control" id="txtMulta" name="txtMulta" placeholder="Multa" required <?php echo isset($_GET['multa']) ? "value='{$_GET['multa']}'" : "value=''"; ?>>
        </div>
        
    </div>


    <div class="row g-3 pt-3">
        <div class="col-sm-6">
            <button class="w-100 btn btn-secondary btn-lg" type="reset" id="btnCancelar">Cancelar</button>
        </div>
        <div class="col-sm-6">
            <button class="w-100 btn btn-primary btn-lg" type="submit" id="btnSalvar">Salvar</button>
        </div>
    </div>
</form>



<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h2>Listagem de Alunos</h2>
</div>

<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nome</th>
                <th scope="col">CPF</th>
                <th scope="col">Telefone</th>
                <th scope="col">Sexo</th>
                <th scope="col">Multa</th>
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
            $sql = 'SELECT * FROM Alunos';
            $stmt = $conexao->prepare($sql);
            $stmt->execute();
            $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Imprimindo os dados na tabela
            if (!empty($dados)) {
                foreach ($dados as $linha) {
                    echo "<tr>
                            <td>{$linha['id_aluno']}</td>
                            <td>{$linha['nome']}</td>
                            <td>{$linha['cpf']}</td>
                            <td>{$linha['telefone']}</td>
                            <td>{$linha['sexo']}</td>
                            <td>{$linha['multa']}</td>
                            
                            <td>
                                <a href='sistema.php?tela=alunos&id={$linha['id_aluno']}&nome={$linha['nome']}&cpf={$linha['cpf']}&telefone={$linha['telefone']}&sexo={$linha['sexo']}&multa={$linha['multa']}'>Alterar</a>
                            </td>
                            <td>
                                <a onclick=\"excluirProduto({$linha['id_aluno']})\" href='#'><i class=\"fa-solid fa-trash-can\"></i></a>
                                </td>
                            
                        </tr>";
                }
            } else {
                echo "<tr>
                        <td colspan='6'>Nenhum aluno cadastrado.</td>
                    </tr>";
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="8"><strong><?php echo 'Total: ' . count($dados); ?></strong></td>
            </tr>
        </tfoot>
    </table>
</div>

<script>
    function excluirProduto(id) {
        var resposta = confirm('Desejas realmente excluir?');
        if (resposta) {
            window.location = "application/excluir-aluno.php?id=" + id;

        }
    }
</script>