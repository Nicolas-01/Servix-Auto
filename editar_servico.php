<?php
require_once("cabecalho.php");
function retornaServico($id_servico)
{
    require("conexao.php");
    try {
        $sql = "SELECT * FROM servico WHERE id_servico = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id_servico]);
        $servico = $stmt->fetch();
        if (!$servico) {
            die("Serviço não encontrado!");
        }
        return $servico;
    } catch (Exception $e) {
        die("Erro ao consultar o serviço: " . $e->getMessage());
    }
}
function alterarServico($nome, $descricao, $preco, $id_servico)
{
    require("conexao.php");
    try {
        $sql = "UPDATE servico SET nome = ?, descricao = ?, preco = ? WHERE id_servico = ?";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$nome, $descricao, $preco, $id_servico])) {
            header("Location: servico.php?edicao=true");
        } else {
            header("Location: servico.php?edicao=false");
        }
    } catch (Exception $e) {
        die("Erro ao alterar o serviço: " . $e->getMessage());
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_servico = $_POST['id_servico'];
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    alterarServico($nome, $descricao, $preco, $id_servico);
} else {
    $id_servico = $_GET['id'];
    $servico = retornaServico($id_servico);
}
?>

<div class="bordasEditarServico">
    <div class="card-editar">
        <h2 class="titulo">Editar Serviço</h2>
        <form method="post"> <input type="hidden" name="id_servico" value="<?= $servico['id_servico'] ?>">
            <div class="mb-3 card-edit">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" id="nome" name="nome" class="form-control" required placeholder="Insira um serviço"
                    value="<?= $servico['nome'] ?>">
            </div>

            <div class="mb-3 card-edit">
                <label for="descricao" class="form-label">Descrição</label>
                <textarea id="descricao" name="descricao" class="form-control" required
                    placeholder="Descreva o serviço"><?= $servico['descricao'] ?></textarea>
            </div>


            <div class="mb-3 card-edit">
                <label for="preco" class="form-label">Preço</label>
                <input type="number" step="0.01" id="preco" name="preco" class="form-control" required
                    placeholder="Ex: 99.90" value="<?= htmlspecialchars($servico['preco']) ?>">
            </div>

            <div class="mb-3 titulo">
                <button type="submit" class="btn btn-success">Enviar</button>
                <button type="button" class="btn btn-secondary"
                    onclick="window.location.href='servico.php';">Voltar</button>
            </div>
        </form>
    </div>
</div>

<?php
require_once("rodape.php");
?>