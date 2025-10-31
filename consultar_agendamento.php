<?php
require_once("cabecalho.php");

function consultaAgendamento($id_agendamento)
{
    require("conexao.php");
    try {
        $sql = "SELECT a.*, 
                       c.nome AS nome_cliente, 
                       p.nome AS nome_profissional, 
                       s.nome AS nome_servico
                FROM agendamento a
                JOIN cliente c ON a.id_cliente = c.id_cliente
                JOIN profissional p ON a.id_profissional = p.id_profissional
                JOIN servico s ON a.id_servico = s.id_servico
                WHERE a.id_agendamento = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id_agendamento]);
        $agendamento = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$agendamento) {
            die("Agendamento não encontrado.");
        }
        return $agendamento;
    } catch (Exception $e) {
        die("Erro ao consultar agendamento: " . $e->getMessage());
    }
}

function excluirAgendamento($id_agendamento)
{
    require("conexao.php");
    try {
        $sql = "DELETE FROM agendamento WHERE id_agendamento = ?";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$id_agendamento])) {
            header('location: agendamento.php?exclusao=true');
        } else {
            header('location: agendamento.php?exclusao=false');
        }
    } catch (Exception $e) {
        die("Erro ao excluir agendamento: " . $e->getMessage());
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_agendamento = $_POST['id_agendamento'];
    excluirAgendamento($id_agendamento);
} else {
    $agendamento = consultaAgendamento($_GET['id']);
}
?>

<div class="bordasConsultarServico">
    <div class="card-consultar-agend">
        <form method="post">
            <h2 class="titulo-consultar">Consultar Agendamento</h2>

            <input type="hidden" name="id_agendamento" value="<?= $agendamento['id_agendamento'] ?>">

            <div class="mb-3 card-consult-agend">
                <p><strong>Data:</strong> <?= (new DateTime($agendamento['data']))->format('d/m/Y') ?></p>
            </div>

            <div class="mb-3 card-consult-agend">
                <p><strong>Hora:</strong> <?= (new DateTime($agendamento['hora']))->format('H:i') ?></p>
            </div>

            <div class="mb-3 card-consult-agend">
                <p><strong>Cliente:</strong> <?= $agendamento['nome_cliente'] ?></p>
            </div>

            <div class="mb-3 card-consult-agend">
                <p><strong>Profissional:</strong> <?= $agendamento['nome_profissional'] ?></p>
            </div>

            <div class="mb-3 card-consult-agend">
                <p><strong>Serviço:</strong> <?= $agendamento['nome_servico'] ?></p>
            </div>

            <div class="mb-3 titulo-consultar">
                <p><b>Deseja excluir este agendamento?</b></p>
                <button type="submit" class="btn btn-danger">Excluir</button>
                <button type="button" class="btn btn-secondary"
                    onclick="window.location.href='agendamento.php';">Voltar</button>
            </div>
        </form>
    </div>
</div>

<?php
require_once("rodape.php");
?>