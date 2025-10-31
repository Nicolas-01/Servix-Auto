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
            die("Cliente não encontrado.");
        }
        return $cliente;
    } catch (Exception $e) {
        die("Erro ao consultar cliente: " . $e->getMessage());
    }
}

function atualizarCliente($id_cliente, $nome, $cpf, $telefone, $email)
{
    require("conexao.php");
    try {
        $sql = "UPDATE cliente SET nome = ?, cpf = ?, telefone = ?, email = ? WHERE id_cliente = ?";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$nome, $cpf, $telefone, $email, $id_cliente])) {
            header('Location: clientes.php?edicao=true');
        } else {
            header('Location: clientes.php?edicao=false');
        }
    } catch (Exception $e) {
        die("Erro ao atualizar cliente: " . $e->getMessage());
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_cliente = $_POST['id_cliente'];
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    atualizarCliente($id_cliente, $nome, $cpf, $telefone, $email);
} else {
    $cliente = consultaCliente($_GET['id']);
}
?>

<div class="bordasEditarServico">
    <div class="card-editar">
        <form method="post">
            <h2 class="titulo-consultar">Editar Cliente</h2>

            <input type="hidden" name="id_cliente" value="<?=$cliente['id_cliente'] ?>">

            <div class="mb-3 card-edit">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" id="nome" name="nome" class="form-control" required
                    value="<?=$cliente['nome'] ?>">
            </div>

            <div class="mb-3 card-edit">
                <label for="cpf" class="form-label">CPF</label>
                <input type="text" id="cpf" name="cpf" class="form-control" required
                    value="<?=$cliente['cpf'] ?>">
            </div>

            <div class="mb-3 card-edit">
                <label for="telefone" class="form-label">Telefone</label>
                <input type="text" id="telefone" name="telefone" class="form-control" required
                    value="<?=$cliente['telefone'] ?>">
            </div>

            <div class="mb-3 card-edit">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" id="email" name="email" class="form-control" required
                    value="<?=$cliente['email'] ?>">
            </div>

            <div class="mb-3 titulo">
                <button type="submit" class="btn btn-success">Enviar</button>
                <button type="button" class="btn btn-secondary"
                    onclick="window.location.href='clientes.php';">Voltar</button>
            </div>
        </form>
    </div>
</div>

<?php
require_once("rodape.php");
?>