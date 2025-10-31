<?php
require_once("cabecalho.php");

function consultaCliente($id_cliente)
{
    require("conexao.php");
    try {
        $sql = "SELECT * FROM cliente WHERE id_cliente = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id_cliente]);
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$cliente) {
            die("Cliente não encontrado!");
        }
        return $cliente;
    } catch (Exception $e) {
        die("Erro ao consultar cliente: " . $e->getMessage());
    }
}

function excluirCliente($id_cliente)
{
    require("conexao.php");
    try {
        $sql = "DELETE FROM cliente WHERE id_cliente = ?";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$id_cliente])) {
            header("Location: clientes.php?exclusao=true");
        } else {
            header("Location: clientes.php?exclusao=false");
        }
    } catch (Exception $e) {
        die("Erro ao excluir cliente: " . $e->getMessage());
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['excluir'])) {
    $id_cliente = $_POST['id_cliente'];
    excluirCliente($id_cliente);
} else {
    if (!isset($_GET['id'])) {
        die("ID do cliente não informado!");
    }
    $cliente = consultaCliente($_GET['id']);
}
?>

<div class="bordasEditarServico">
    <div class="card-editar">
        <form method="post">
            <h2 class="titulo-consultar">Consultar Cliente</h2>

            <input type="hidden" name="id_cliente" value="<?= $cliente['id_cliente'] ?>">

            <div class="mb-3 card-consult-prof">
                <p><b>Nome:</b> <?= $cliente['nome'] ?></p>
            </div>

            <div class="mb-3 card-consult-prof">
                <p><b>CPF:</b> <?= $cliente['cpf'] ?></p>
            </div>

            <div class="mb-3 card-consult-prof">
                <p><b>Telefone:</b> <?= $cliente['telefone'] ?></p>
            </div>

            <div class="mb-3 card-consult-prof">
                <p><b>Email:</b> <?= $cliente['email'] ?></p>
            </div>

            <div class="mb-3 titulo-consultar">
                <p><b>Deseja excluir este agendamento?</b></p>
                <button type="submit"  name="excluir" class="btn btn-danger">Excluir</button>
                <button type="button" class="btn btn-secondary" onclick="window.location.href='clientes.php';">Voltar</button>
            </div>
        </form>
    </div>
</div>

<?php
require_once("rodape.php");
?>
