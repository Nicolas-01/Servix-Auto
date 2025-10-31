<?php
require_once("cabecalho.php");

function retornaClientes()
{
    require("conexao.php");
    try {
        $sql = "SELECT id_cliente, nome FROM cliente";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        die("Erro ao retornar clientes: " . $e->getMessage());
    }
}

function retornaProfissionais()
{
    require("conexao.php");
    try {
        $sql = "SELECT id_profissional, nome FROM profissional";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        die("Erro ao retornar profissionais: " . $e->getMessage());
    }
}

function retornaServicos()
{
    require("conexao.php");
    try {
        $sql = "SELECT id_servico, nome FROM servico";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        die("Erro ao retornar serviços: " . $e->getMessage());
    }
}

function inserirAgendamento($data, $hora, $idCliente, $idProfissional, $idServico)
{
    require("conexao.php");
    try {
        $sql = "INSERT INTO agendamento (data, hora, id_cliente, id_profissional, id_servico) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$data, $hora, $idCliente, $idProfissional, $idServico]);
        return true;
    } catch (Exception $e) {
        die("Erro ao salvar o agendamento: " . $e->getMessage());
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = $_POST['data'];
    $hora = $_POST['hora'];
    $idCliente = $_POST['idCliente'];
    $idProfissional = $_POST['idProfissional'];
    $idServico = $_POST['idServico'];

    if (inserirAgendamento($data, $hora, $idCliente, $idProfissional, $idServico)) {
        header('Location: agendamento.php?cadastro=true');
    }
}

$clientes = retornaClientes();
$profissionais = retornaProfissionais();
$servicos = retornaServicos();
?>

<div class="bordasEditarServico">
    <div class="card-novo-agendamento">
        <h2 class="titulo">Novo Agendamento</h2>

        <form method="POST" action="">
            <div class="mb-3 card-agend">
                <label for="data" class="form-label">Data</label>
                <input type="date" id="data" name="data" class="form-control" required min="<?= date('Y-m-d') ?>">
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
                        echo "<option value=\"{$horaFormatada}\">{$horaFormatada}</option>";
                        $inicio->add(new DateInterval('PT30M'));
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3 card-agend">
                <label for="idCliente" class="form-label">Cliente</label>
                <select id="idCliente" name="idCliente" class="form-control" required>
                    <option value="">Selecione...</option>
                    <?php foreach ($clientes as $cliente): ?>
                        <option value="<?= $cliente['id_cliente'] ?>"><?= $cliente['nome'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3 card-agend">
                <label for="idProfissional" class="form-label">Profissional</label>
                <select id="idProfissional" name="idProfissional" class="form-control" required>
                    <option value="">Selecione...</option>
                    <?php foreach ($profissionais as $profissional): ?>
                        <option value="<?= $profissional['id_profissional'] ?>"><?= $profissional['nome'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3 card-agend">
                <label for="idServico" class="form-label">Serviço</label>
                <select id="idServico" name="idServico" class="form-control" required>
                    <option value="">Selecione...</option>
                    <?php foreach ($servicos as $servico): ?>
                        <option value="<?= $servico['id_servico'] ?>"><?= $servico['nome'] ?></option>
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