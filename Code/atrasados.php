<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h2>Empréstimos Atrasados</h2>
</div>

<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Aluno</th>
                <th scope="col">Livro</th>
                <th scope="col">Data Retirada</th>
                <th scope="col">Data Devolucao</th>
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
            $sql = 'SELECT emprestimos.id_emprestimo, alunos.nome as nomeAluno, livros.nome as nomeLivro, emprestimos.data_retirada, emprestimos.data_devolucao, emprestimos.id_aluno, emprestimos.id_livro FROM emprestimos INNER JOIN alunos ON alunos.id_aluno = emprestimos.id_aluno INNER JOIN livros ON livros.id_livro = emprestimos.id_livro where situacao = 2';
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
                                <a href='application/devolver-emprestimo.php?id={$linha['id_emprestimo']}'>Devolver</a>
                            </td>
                            <td>
                                <a onclick=\"excluirProduto({$linha['id_emprestimo']})\" href='#'><i class=\"fa-solid fa-trash-can\"></i></a>
                            </td>
                            
                        </tr>";

                        $now = strtotime(date('Y-m-d H:i:s')); 
                        $your_date = strtotime($linha['data_devolucao']);
                        $datediff = $now - $your_date;
                        $datediff = round($datediff / (60 * 60 * 24));
                        $multa = $datediff * 0.33;
                        
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
                        
                        $sql = "UPDATE alunos SET multa= $multa where id_aluno={$linha['id_aluno']}";
                        $stmt = $conexao->prepare($sql);
                        $stmt->execute();

                }
            } else {
                echo "<tr>
                        <td colspan='7'>Nenhum livro em atrasado.</td>
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


<script>
    function excluirProduto(id) {
        var resposta = confirm('Desejas realmente excluir?');
        if (resposta) {
            window.location = "application/excluir-emprestimo.php?id=" + id;

        }
    }
</script>
