<?php
require_once("cabecalho.php");

function inserirServico($nome, $descricao, $preco)
{
    require("conexao.php");
    try {
        $sql = "INSERT INTO servico (nome, descricao, preco) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$nome, $descricao, $preco])) {
            header('location: servico.php?cadastro=true');
        } else {
            header('location: servico.php?cadastro=false');
        }
    } catch (Exception $e) {
        die("Erro ao inserir serviço: " . $e->getMessage());
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // ucfirst deixa a primeira letra do nome em maiúscula
    $nome = ucfirst($_POST['nome']);

    $descricao = $_POST['descricao'];

    // str_replace troca vírgula por ponto
    $preco = str_replace(',', '.', $_POST['preco']);

    inserirServico($nome, $descricao, $preco);
}
?>
<div class="bordasEditarServico">
    <div class="card-editar">
        <h2 class="titulo">Novo Serviço</h2>
        <form method="post">
            <div class="mb-3 card-edit">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" id="nome" name="nome" class="form-control" required
                    placeholder="Insira o nome do serviço">
            </div>

            <div class="mb-3 card-edit">
                <label for="descricao" class="form-label">Descrição</label>
                <textarea id="descricao" name="descricao" class="form-control" rows="4"
                    placeholder="Descreva o serviço"></textarea>
            </div>

            <div class="mb-3 card-edit">
                <label for="preco" class="form-label">Preço</label>
                <input type="text" id="preco" name="preco" class="form-control" required placeholder="Ex: 99.90">
            </div>

            <div class="mb-3 titulo">
                <button type="submit" class="btn btn-success">Enviar</button>
                <button type="button" class="btn btn-secondary"
                    onclick="window.location.href='servico.php';">Voltar</button>
            </div>
        </form>
    </div>
</div>

<?php
require_once("rodape.php");
?>