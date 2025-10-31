<?php
require_once("cabecalho.php");
function retornaServico()
{
    require("conexao.php");
    try {
        $sql = "SELECT * FROM servico";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        die("Erro ao retornar serviços: " . $e->getMessage());
    }
}
$servicos = retornaServico(); ?>
<div class="bordas">
    <h1>Serviços</h1> <a href="novo_servico.php" class="btn btn-success mt-3 mb-3">Novo serviço</a>

    <?php
    if (isset($_GET['cadastro']) && $_GET['cadastro'] == "true") {
        echo '<p class="text-success">Registro realizado com sucesso!</p>';
    } elseif (isset($_GET['cadastro']) && $_GET['cadastro'] == "false") {
        echo '<p class="text-danger">Erro ao realizar registro!</p>';
    }
    ?>

    <table class="table table-hover table-striped" id="tabela">
        <thead>
            <tr>
                <th class="text-center">ID</th>
                <th class="text-center">Nome</th>
                <th class="text-center">Descrição</th>
                <th class="text-center">Preço</th>
                <th class="text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($servicos as $servico): ?>
                <tr>
                    <td class="text-center"><?= $servico['id_servico'] ?></td>
                    <td class="text-center"><?= ucfirst($servico['nome']) ?></td>
                    <!-- ucfirst deixa a primeira letra em maiúsculo -->
                    <td><?= $servico['descricao'] ?></td>
                    <td class="text-center tamanho-preco">R$ <?= number_format($servico['preco'], 2, ',', '.') ?></td>
                    <td class="text-center">
                        <a href="editar_servico.php?id=<?= $servico['id_servico'] ?>"
                            class="btn btn-sm btn-tableAcoes">Editar</a>
                        <a href="consultar_servico.php?id=<?= $servico['id_servico'] ?>"
                            class="btn btn-secondary btn-sm">Consultar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <button type="button" class="btn btn-secondary" onclick="window.location.href='principal.php';">Voltar</button>

</div>

<?php
require_once("rodape.php");
?>