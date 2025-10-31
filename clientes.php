<?php
require_once("cabecalho.php");

function retornaClientes()
{
    require("conexao.php");
    try {
        $sql = "SELECT id_cliente, nome, cpf, telefone, email FROM cliente";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        die("Erro ao consultar clientes: " . $e->getMessage());
    }
}

$clientes = retornaClientes();
?>
<div class="bordas">
    <h1>Clientes</h1>

    <a href="novo_usuario.php" class="btn btn-success mb-3">Novo cliente</a>

    <table class="table table-hover table-striped servicoTable" id="tabela">
        <thead>
            <tr>
                <th class="text-center">ID</th>
                <th class="text-center">Nome</th>
                <th class="text-center">CPF</th>
                <th class="text-center">Telefone</th>
                <th class="text-center">Email</th>
                <th class="text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clientes as $cliente): ?>
                <tr>
                    <td class="text-center"><?= $cliente['id_cliente'] ?></td>
                    <td class="text-center"><?= $cliente['nome'] ?></td>
                    <td class="text-center"><?= $cliente['cpf'] ?></td>
                    <td class="text-center"><?= $cliente['telefone'] ?></td>
                    <td class="text-center"><?= $cliente['email'] ?></td>
                    <td class="text-center">
                        <a href="editar_cliente.php?id=<?= $cliente['id_cliente'] ?>"
                            class="btn btn-sm btn-tableAcoes">Editar</a>
                        <a href="consultar_cliente.php?id=<?= $cliente['id_cliente'] ?>"
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