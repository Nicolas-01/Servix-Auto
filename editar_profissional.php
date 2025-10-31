<?php
require_once("cabecalho.php");
function consultaProfissional($id_profissional)
{
    require("conexao.php");
    try {
        $sql = "SELECT * FROM profissional WHERE id_profissional = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id_profissional]);
        $profissional = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$profissional) {
            die("Erro ao consultar registro!");
        } else {
            return $profissional;
        }
    } catch (Exception $e) {
        die("Erro ao consultar o profissional: " . $e->getMessage());
    }
}

function retornaEspecialidades()
{
    require("conexao.php");
    try {
        $sql = "SELECT * FROM especialidade";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        die("Erro ao retornar especialidades: " . $e->getMessage());
    }
}
 
function alterarProfissional($id_profissional, $registro, $nome, $id_especialidade, $telefone)
{
    require("conexao.php");
    try {
        $sql = "UPDATE profissional SET registro = ?, nome = ?, id_especialidade = ?, telefone = ? WHERE id_profissional = ?";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$registro, $nome, $id_especialidade, $telefone, $id_profissional])) {
            header('location: profissional.php?edicao=true');
        } else {
            header('location: profissional.php?edicao=false');
        }
    } catch (Exception $e) {
        die("Erro ao alterar o profissional: " . $e->getMessage());
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_profissional = $_POST['id_profissional'];
    $registro = $_POST['registro'];
    $nome = $_POST['nome'];
    $id_especialidade = $_POST['especialidade'];
    $telefone = $_POST['telefone'];
    alterarProfissional($id_profissional, $registro, $nome, $id_especialidade, $telefone);
} else {
    $profissional = consultaProfissional($_GET['id']);
    $especialidades = retornaEspecialidades();
} 
?>

<div class="bordasEditarServico">
    <div class="card-editar">
        <h2 class="titulo">Editar Profissional</h2>
        <form method="post"> <input type="hidden" name="id_profissional"
                value="<?= $profissional['id_profissional'] ?>">

            <div class="mb-3 card-edit">
                <label for="registro" class="form-label">Registro</label>
                <input type="text" id="registro" name="registro" class="form-control" required
                    value="<?= $profissional['registro'] ?>">
            </div>

            <div class="mb-3 card-edit">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" id="nome" name="nome" class="form-control" required
                    value="<?= $profissional['nome'] ?>">
            </div>

            <div class="mb-3 card-edit">
                <label for="especialidade" class="form-label">Especialidade</label>
                <select id="especialidade" name="especialidade" class="form-control" required>
                    <option value="">Selecione...</option>
                    <?php foreach ($especialidades as $esp): ?>
                        <option value="<?= $esp['id_especialidade'] ?>"
                            <?= ($esp['id_especialidade'] == $profissional['id_especialidade']) ? 'selected' : '' ?>>
                            <?= $esp['nome'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3 card-edit">
                <label for="telefone" class="form-label">Telefone</label>
                <input type="text" id="telefone" name="telefone" class="form-control" required
                    value="<?= $profissional['telefone'] ?>">
            </div>

            <div class="mb-3 titulo">
                <button type="submit" class="btn btn-success">Enviar</button>
                <button type="button" class="btn btn-secondary"
                    onclick="window.location.href='profissional.php';">Voltar</button>
            </div>

        </form>
    </div>
</div>

<?php
require_once("rodape.php");
?>