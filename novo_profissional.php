<?php
require_once('cabecalho.php');
function retornaEspecialidades()
{
    require('conexao.php');
    try {
        $sql = "SELECT * FROM especialidade";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        die("Erro ao retornar especialidades: " . $e->getMessage());
    }
}
function cadastrarProfissional($nome, $registro, $especialidade, $telefone)
{
    require('conexao.php');
    try {
        $sql = "INSERT INTO profissional (nome, registro, id_especialidade, telefone) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$nome, $registro, $especialidade, $telefone])) {
            header('Location: profissional.php?cadastro=true');
        } else {
            header('Location: profissional.php?cadastro=false');
        }
    } catch (Exception $e) {
        die("Erro ao cadastrar o profissional: " . $e->getMessage());
    }
}

$especialidades = retornaEspecialidades();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $registro = $_POST['registro'];
    $especialidade = $_POST['especialidade'];
    $telefone = $_POST['telefone'];
    cadastrarProfissional($nome, $registro, $especialidade, $telefone);
}
?>
<div class="fundoProfissional">
    <div class="card-novo-profissional">
        <h1 class="titulo">Cadastrar Profissional</h1>

        <form method="post">
            <div class="textfieldProfissional">
                <label for="nome">Nome</label>
                <input type="text" id="nome" name="nome" required placeholder="Henrique Costa">
            </div>

            <div class="textfieldProfissional">
                <label for="registro">Registro</label>
                <input type="text" id="registro" name="registro" required placeholder="1001">
            </div>

            <div class="textfieldProfissional">
                <label for="especialidade">Especialidade</label>
                <select id="especialidade" name="especialidade" required>
                    <option value="">Selecione...</option>
                    <?php foreach ($especialidades as $esp): ?>
                        <option value="<?= $esp['id_especialidade'] ?>">
                            <?= $esp['nome'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="textfieldProfissional">
                <label for="telefone">Telefone</label>
                <input type="text" id="telefone" name="telefone" required placeholder="(11) 99999-9999">
            </div>

            <div class="mb-3 titulo-consultar">
                <button class="btn-cadastrar">Enviar</button>
                <button type="button" class="btn btn-secondary"
                    onclick="window.location.href='profissional.php';">Voltar</button>
            </div>
        </form>
    </div>
</div>

<?php
require_once("rodape.php");
?>