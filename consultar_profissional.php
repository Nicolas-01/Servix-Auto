<?php
require_once("cabecalho.php");
function consultaProfissional($id_profissional)
{
    require("conexao.php");
    try {
        $sql = "SELECT p.*, e.nome AS especialidade_nome 
        FROM profissional p 
        INNER JOIN especialidade e ON p.id_especialidade = e.id_especialidade WHERE p.id_profissional = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id_profissional]);
        $profissional = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$profissional) {
            die("Erro ao consultar o profissional!");
        } else {
            return $profissional;
        }
    } catch (Exception $e) {
        die("Erro ao consultar o profissional: " . $e->getMessage());
    }
}
function excluirProfissional($id_profissional)
{
    require("conexao.php");
    try {
        $sql = "DELETE FROM profissional WHERE id_profissional = ?";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$id_profissional])) {
            header('location: profissional.php?exclusao=true');
        } else {
            header('location: profissional.php?exclusao=false');
        }
    } catch (Exception $e) {
        die("Erro ao excluir o profissional: " . $e->getMessage());
    }
}
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['excluir'])) {
    $id_profissional = $_POST['id_profissional'];
    excluirProfissional($id_profissional);
} else {
    $profissional = consultaProfissional($_GET['id']);
}
?>

<div class="bordasEditarServico">
    <div class="card-consultar-Prof">
        <form method="post">
            <h2 class="titulo-consultar">Consultar Profissional</h2>

            <input type="hidden" name="id_profissional" value="<?= $profissional['id_profissional'] ?>">

            <div class="mb-3 card-consult-prof">
                <p><b>Nome:</b> <?= $profissional['nome'] ?></p>
            </div>

            <div class="mb-3 card-consult-prof">
                <p><b>Registro:</b> <?= $profissional['registro'] ?></p>
            </div>

            <div class="mb-3 card-consult-prof">
                <p><b>Especialidade:</b> <?= $profissional['especialidade_nome'] ?></p>
            </div>

            <div class="mb-3 card-consult-prof">
                <p><b>Telefone:</b> <?= $profissional['telefone'] ?></p>
            </div>

            <div class="mb-3 titulo-consultar">
                <p><b>Deseja excluir este agendamento?</b></p>
                <button type="submit" name="excluir" class="btn btn-danger">Excluir</button>
                <button type="button" class="btn btn-secondary"
                    onclick="window.location.href='profissional.php';">Voltar</button>
            </div>
        </form>
    </div>
</div>

<?php
require_once("rodape.php");
?>