<?php
require_once("cabecalho.php");

function retornaAgendamentos()
{
    require("conexao.php");
    try {
        $sql = "SELECT a.id_agendamento, a.data, a.hora, 
                       c.nome AS cliente_nome, 
                       p.nome AS profissional_nome, 
                       s.nome AS servico_nome
                FROM agendamento a
                JOIN cliente c ON a.id_cliente = c.id_cliente
                JOIN profissional p ON a.id_profissional = p.id_profissional
                JOIN servico s ON a.id_servico = s.id_servico";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        die("Erro ao consultar agendamentos: " . $e->getMessage());
    }
}

function retornaClientes()
{
    require("conexao.php");
    try {
        $sql = "SELECT id_cliente, nome FROM cliente";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        die("Erro ao consultar clientes: " . $e->getMessage());
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
        die("Erro ao consultar profissionais: " . $e->getMessage());
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
        die("Erro ao consultar serviços: " . $e->getMessage());
    }
}

$agendamentos = retornaAgendamentos();
?>

<div class="bordas">
    <h1>Agendamentos</h1>

    <a href="novo_agendamento.php" class="btn btn-success mt-2 mb-3">Novo agendamento</a>

    <table class="table table-hover table-striped servicoTable" id="tabela">
        <thead>
            <tr>
                <th class="text-center">ID</th>
                <th class="text-center">Data</th>
                <th class="text-center">Hora</th>
                <th class="text-center">Cliente</th>
                <th class="text-center">Profissional</th>
                <th class="text-center">Serviço</th>
                <th class="text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($agendamentos as $agendamento): ?>
                <tr>
                    <td class="text-center"><?= $agendamento['id_agendamento'] ?></td>
                    <td class="text-center">
                        <?php
                        $dataFormatada = new DateTime($agendamento['data']);
                        echo $dataFormatada->format('d/m/Y');
                        ?>
                    </td>
                    <td class="text-center">
                        <?php
                        $horaFormatada = new DateTime($agendamento['hora']);
                        echo $horaFormatada->format('H:i');
                        ?>
                    </td>
                    <td class="text-center"><?= $agendamento['cliente_nome'] ?></td>
                    <td class="text-center"><?= $agendamento['profissional_nome'] ?></td>
                    <td class="text-center"><?= $agendamento['servico_nome'] ?></td>
                    <td class="text-center">
                        <a href="editar_agendamento.php?id=<?= $agendamento['id_agendamento'] ?>"
                            class="btn btn-sm btn-tableAcoes">Editar</a>
                        <a href="consultar_agendamento.php?id=<?= $agendamento['id_agendamento'] ?>"
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