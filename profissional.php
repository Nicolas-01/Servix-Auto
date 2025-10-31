<?php
require_once('cabecalho.php');

function retornaProfissionais()
{
    require('conexao.php');
    try {
        $sql = "SELECT p.*, e.nome AS especialidade 
                FROM profissional p
                JOIN especialidade e ON p.id_especialidade = e.id_especialidade";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        die("Erro ao retornar profissionais: " . $e->getMessage());
    }
}

$profissionais = retornaProfissionais();
?>

<div class="bordas">
    <h1>Profissionais</h1>
    <a href="novo_profissional.php" class="btn btn-success mt-2 mb-3">Cadastrar profissional</a>

    <?php
    if (isset($_GET['cadastro']) && $_GET['cadastro'] == 'true') {
        echo '<p class="text-success">Profissional cadastrado com sucesso!</p>';
    } elseif (isset($_GET['cadastro']) && $_GET['cadastro'] == 'false') {
        echo '<p class="text-danger">Erro ao cadastrar profissional!</p>';
    }
    ?>

    <table class="table table-hover table-striped" id="tabela">
        <thead>
            <tr>
                <th class="text-center">ID</th>
                <th class="text-center">Registro</th>
                <th class="text-center">Nome</th>
                <th class="text-center">Especialidade</th>
                <th class="text-center">Telefone</th>
                <th class="text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($profissionais as $p): ?>
                <tr>
                    <td class="text-center"><?= $p['id_profissional'] ?></td>
                    <td class="text-center"><?= $p['registro'] ?></td>
                    <td class="text-center"><?= $p['nome'] ?></td>
                    <td class="text-center"><?= $p['especialidade'] ?></td>
                    <td class="text-center"><?= $p['telefone'] ?></td>
                    <td class="text-center">
                        <a href="editar_profissional.php?id=<?= $p['id_profissional'] ?>"
                            class="btn btn-sm btn-tableAcoes">Editar</a>
                        <a href="consultar_profissional.php?id=<?= $p['id_profissional'] ?>"
                            class="btn btn-secondary btn-sm">Consultar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <button type="button" class="btn btn-secondary" onclick="window.location.href='principal.php';">Voltar</button>
</div>

<?php
require_once('rodape.php');
?>