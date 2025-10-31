<?php
require_once("cabecalho.php");

function consultaServico($id_servico)
{
    require("conexao.php");
    try {
        $sql = "SELECT * FROM servico WHERE id_servico = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id_servico]);
        $servico = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$servico) {
            die("Erro ao consultar registro!");
        }
        return $servico;
    } catch (Exception $e) {
        die("Erro ao consultar o serviço: " . $e->getMessage());
    }
}

function excluirServico($id_servico)
{
    require("conexao.php");
    try {
        $sql = "DELETE FROM servico WHERE id_servico = ?";
        $stmt = $pdo->prepare($sql);

        if ($stmt->execute([$id_servico])) {
            header("Location: servico.php?exclusao=true");
        } else {
            header("Location: servico.php?exclusao=false");
        }
    } catch (Exception $e) {
        die("Erro ao excluir o serviço: " . $e->getMessage());
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_servico = $_POST['id_servico'];
    excluirServico($id_servico);
} else {
    $id_servico = $_GET['id'];
    $servico = consultaServico($id_servico);
}
?>

<div class="bordasConsultarServico">
    <div class="card-editar">
        <form method="post">
            <h2 class="titulo-consultar">Consultar Serviço</h2>

            <input type="hidden" name="id_servico" value="<?= $servico['id_servico'] ?>">

            <div class="mb-3 card-consultar">
                <p><strong>Nome:</strong> <?= $servico['nome'] ?></p>
            </div>

            <div class="mb-3 card-consultar">
                <p><strong>Descrição:</strong> <?= $servico['descricao'] ?></p>
            </div>

            <div class="mb-3 card-consultar">
                <p><strong>Preço:</strong> <?= $servico['preco'] ?></p>
            </div>

            <div class="mb-3 titulo-consultar">
                <p><strong>Deseja excluir esse registro?</strong></p>
                <button type="submit" class="btn btn-danger">Excluir</button>
                <button type="button" class="btn btn-secondary"
                    onclick="window.location.href='servico.php';">Voltar</button>
            </div>
        </form>
    </div>
</div>

<?php
require_once("rodape.php");
?>