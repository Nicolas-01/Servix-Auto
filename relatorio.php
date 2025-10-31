<?php
require_once('cabecalho.php');

function retornaAgendamentosPorProfissional()
{
    require("conexao.php");
    try {
        $sql = "SELECT p.nome AS nome_profissional, COUNT(a.id_agendamento) AS total_agendamentos
                FROM profissional p
                LEFT JOIN agendamento a ON a.id_profissional = p.id_profissional
                GROUP BY p.id_profissional
                ORDER BY total_agendamentos DESC";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        die("Erro ao consultar agendamentos por profissional: " . $e->getMessage());
    }
}

$dados = retornaAgendamentosPorProfissional();
?>
<div class="bordas">
    <h1>Relatório de Agendamentos por Profissional</h1>

    <div id="chart_div" style="width: 100%; height: 500px;"></div>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
        google.charts.load('current', { packages: ['corechart', 'bar'] });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Profissional', 'Agendamentos'],
                <?php
                foreach ($dados as $linha) {
                    echo "['" . addslashes($linha['nome_profissional']) . "', " . $linha['total_agendamentos'] . "],";
                }
                ?>
            ]);

            var options = {
                title: 'Agendamentos por Profissional',
                chartArea: { width: '60%' },
                hAxis: {
                    title: 'Total de Agendamentos',
                    minValue: 0
                },
                vAxis: {
                    title: 'Profissional'
                }
            };

            var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }
    </script>

    <button type="button" class="btn btn-secondary btn-relatorio"
        onclick="window.location.href='principal.php';">Voltar</button>
</div>

<?php
require_once('rodape.php');
?>