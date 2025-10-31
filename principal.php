<?php
require_once("cabecalho.php");

function retornaServico()
{
    require("conexao.php");
    try {
        // Consulta para pegar nome, descrição e preço de 3 serviços
        $sql = "SELECT nome, descricao, preco FROM servico LIMIT 3";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        die("Erro ao retornar serviços: " . $e->getMessage());
    }
}

$servicos = retornaServico();
?>

<div class="bordas">
    <h2>Olá, <?php echo $_SESSION['usuario']; ?> !😃</h2>

    <div class="secao-superior">
        <div class="calendario-container">
            <iframe
                src="https://calendar.google.com/calendar/embed?src=pt.brazilian%23holiday%40group.v.calendar.google.com&ctz=America%2FSao_Paulo"
                width="100%" height="250" frameborder="0" scrolling="no"></iframe>
        </div>

        <div class="agendamento-container">
            <a href="novo_agendamento.php" class="btn-principal btn-principal-agendamento">Novo Agendamento</a>
            <p class="descricao-agendamento">
                Aproveite a praticidade de agendar sua revisão com apenas alguns cliques. Não deixe para depois:
                mantenha seu veículo sempre em dia e evite surpresas no futuro. Agende agora mesmo e conte com o nosso
                atendimento de qualidade!
            </p>
        </div>
    </div>

    <div class="secao-inferior">
        <div class="servicos-info">
            <a href="servico.php" class="btn-principal btn-principal-servico">Ver Serviços</a>
            <p> Explore nossas opções de serviços, pensados para cuidar de todos os detalhes que seu veículo precisa.
                Navegue por nossa lista e descubra como podemos ajudar a manter seu veículo sempre em
                perfeitas condições.</p>
        </div>

        <div class="tabela-servicos">
            <table>
                <thead>
                    <tr class="text-center">
                        <th>Serviço</th>
                        <th>Descrição</th>
                        <th>Preço</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($servicos): ?>
                        <?php foreach ($servicos as $servico): ?>
                            <tr class="text-center">
                                <td><?= $servico['nome'] ?></td>
                                <td><?= $servico['descricao'] ?></td>
                                <td>R$ <?= number_format($servico['preco'], 2, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3">Nenhum serviço encontrado.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
require_once("rodape.php");
?>