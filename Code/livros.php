
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Livros</h1>
</div>

<form method="POST" action="application/inserir-atualizar-livro.php">
    <div class="row g-3">
        <div class="col-sm-6">
            <label for="txtID" class="form-label">ID</label>
            <input type="text" class="form-control" id="txtID" name="txtID" readonly required <?php echo isset($_GET['id']) ? "value='{$_GET['id']}'" : "value='NOVO'"; ?>>
        </div>
        <div class="col-sm-6">
            <label for="txtNome" class="form-label">Nome</label>
            <input type="text" class="form-control" id="txtNome" name="txtNome" placeholder="Nome do Livro" required <?php echo isset($_GET['nome']) ? "value='{$_GET['nome']}'" : "value=''"; ?>>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-sm-6">
            <label for="txtEditora" class="form-label">Editora</label>
            <input type="text" class="form-control" id="txtEditora" name="txtEditora" placeholder="" required <?php echo isset($_GET['editora']) ? "value='{$_GET['editora']}'" : "value=''"; ?>>
        </div>
        <div class="col-sm-6">
            <label for="txtGenero" class="form-label">Gênero</label>
            <input type="text" class="form-control" id="txtGenero" name="txtGenero" placeholder="" required <?php echo isset($_GET['genero']) ? "value='{$_GET['genero']}'" : "value=''"; ?>>
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
    <h2>Listagem de Livros</h2>
</div>

<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nome</th>
                <th scope="col">Editora</th>
                <th scope="col">Gênero</th>
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
            $sql = 'SELECT * FROM livros';
            $stmt = $conexao->prepare($sql);
            $stmt->execute();
            $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Imprimindo os dados na tabela
            if (!empty($dados)) {
                foreach ($dados as $linha) {
                    echo "<tr>
                            <td>{$linha['id_livro']}</td>
                            <td>{$linha['nome']}</td>
                            <td>{$linha['editora']}</td>
                            <td>{$linha['genero']}</td>
                            
                            <td>
                                <a href='sistema.php?tela=livros&id={$linha['id_livro']}&nome={$linha['nome']}&editora={$linha['editora']}&genero={$linha['genero']}'>Alterar</a>
                            </td>
                            <td>
                                <a onclick=\"excluirProduto({$linha['id_livro']})\" href='#'><i class=\"fa-solid fa-trash-can\"></i></a>
                                </td>
                            
                        </tr>";
                }
            } else {
                echo "<tr>
                        <td colspan='6'>Nenhum livro cadastrado.</td>
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

<script>
    function excluirProduto(id) {
        var resposta = confirm('Desejas realmente excluir?');
        if (resposta) {
            window.location = "application/excluir-livro.php?id=" + id;

        }
    }
</script>