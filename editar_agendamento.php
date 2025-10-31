<?php
require_once("cabecalho.php");

function consultaAgendamento($id_agendamento)
{
    require("conexao.php");
    try {
        $sql = "SELECT * FROM agendamento WHERE id_agendamento = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id_agendamento]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        die("Erro ao consultar o agendamento: " . $e->getMessage());
    }
}

function atualizarAgendamento($id_agendamento, $data, $hora, $id_cliente, $id_profissional, $id_servico)
{
    require("conexao.php");
    try {
        $sql = "UPDATE agendamento 
                SET data = ?, hora = ?, id_cliente = ?, id_profissional = ?, id_servico = ?
                WHERE id_agendamento = ?";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$data, $hora, $id_cliente, $id_profissional, $id_servico, $id_agendamento])) {
            header('location: agendamento.php?edicao=true');
        } else {
            header('location: agendamento.php?edicao=false');
        }
    } catch (Exception $e) {
        die("Erro ao atualizar o agendamento: " . $e->getMessage());
    }
}

function listarClientes()
{
    require("conexao.php");
    $stmt = $pdo->query("SELECT id_cliente, nome FROM cliente");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function listarProfissionais()
{
    require("conexao.php");
    $stmt = $pdo->query("SELECT id_profissional, nome FROM profissional");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function listarServicos()
{
    require("conexao.php");
    $stmt = $pdo->query("SELECT id_servico, nome FROM servico");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Lógica principal
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_agendamento = $_POST['id_agendamento'];
    $data = $_POST['data'];
    $hora = $_POST['hora'];
    $id_cliente = $_POST['id_cliente'];
    $id_profissional = $_POST['id_profissional'];
    $id_servico = $_POST['id_servico'];

    atualizarAgendamento($id_agendamento, $data, $hora, $id_cliente, $id_profissional, $id_servico);
} else {
    $agendamento = consultaAgendamento($_GET['id']);
    $clientes = listarClientes();
    $profissionais = listarProfissionais();
    $servicos = listarServicos();
}
?>

<div class="bordasEditarServico">
    <div class="card-novo-agendamento">
        <form method="post">
            <h2 class="titulo-consultar">Editar Agendamento</h2>

            <input type="hidden" name="id_agendamento" value="<?= htmlspecialchars($agendamento['id_agendamento']) ?>">

            <div class="mb-3 card-agend">
                <label for="data" class="form-label">Data</label>
                <input type="date" id="data" name="data" class="form-control" required
                    value="<?= $agendamento['data'] ?>" min="<?= date('Y-m-d') ?>">
            </div>

            <div class="mb-3 card-agend">
                <label for="hora" class="form-label">Hora</label>
                <select id="hora" name="hora" class="form-control" required>
                    <option value="">Selecione...</option>
                    <?php
                    $inicio = new DateTime('08:00');
                    $fim = new DateTime('16:30');
                    while ($inicio <= $fim) {
                        $horaFormatada = $inicio->format('H:i');
                        $selected = ($horaFormatada == $agendamento['hora']) ? 'selected' : '';
                        echo "<option value=\"$horaFormatada\" $selected>$horaFormatada</option>";
                        $inicio->add(new DateInterval('PT30M'));
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3 card-agend">
                <label for="id_cliente">Cliente</label>
                <select name="id_cliente" id="id_cliente" class="form-control" required>
                    <option value="">Selecione...</option>
                    <?php foreach ($clientes as $cliente): ?>
                        <option value="<?= $cliente['id_cliente'] ?>" <?= $cliente['id_cliente'] == $agendamento['id_cliente'] ? 'selected' : '' ?>>
                            <?= $cliente['nome'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3 card-agend">
                <label for="id_profissional">Profissional</label>
                <select name="id_profissional" id="id_profissional" class="form-control" required>
                    <option value="">Selecione...</option>
                    <?php foreach ($profissionais as $prof): ?>
                        <option value="<?= $prof['id_profissional'] ?>"
                            <?= $prof['id_profissional'] == $agendamento['id_profissional'] ? 'selected' : '' ?>>
                            <?= $prof['nome'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3 card-agend">
                <label for="id_servico">Serviço</label>
                <select name="id_servico" id="id_servico" class="form-control" required>
                    <option value="">Selecione...</option>
                    <?php foreach ($servicos as $servico): ?>
                        <option value="<?= $servico['id_servico'] ?>" <?= $servico['id_servico'] == $agendamento['id_servico'] ? 'selected' : '' ?>>
                            <?= $servico['nome'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3 titulo">
                <button type="submit" class="btn btn-success">Enviar</button>
                <button type="button" class="btn btn-secondary"
                    onclick="window.location.href='agendamento.php';">Voltar</button>
            </div>
        </form>
    </div>
</div>

<?php
require_once("rodape.php");
?>