<?php include('./layouts/header.php'); ?>

<div class="container mt-5">
    <h1>Qual seu signo?</h1>
    <?php


    $data_nascimento = $_POST['data_nascimento'];   /* Puxando as informações da data informada pelo usuario */
    $signos = simplexml_load_file("./signos.xml");  /* Buscando as informações do arquivo XML */
    $data_nascimento = new DateTime($data_nascimento); /* Criando o obejeto Datetime com as informações da data_nascimento  */
    $signo_encontrado = false;


    foreach ($signos->signo as $signo) {
        $data_inicio = DateTime::createFromFormat('d/m', (string)$signo->dataInicio);
        $data_fim = DateTime::createFromFormat('d/m', (string)$signo->dataFim);
        $data_inicio->setDate(
            $data_nascimento->format('Y'),
            $data_inicio->format('m'),   /* Fomatando o DateTime para receber somente o Dia e Mes */
            $data_inicio->format('d')
        );
        $data_fim->setDate(
            $data_nascimento->format('Y'),
            $data_fim->format('m'),
            $data_fim->format('d')
        );
        if ($data_inicio > $data_fim) { /* Se a fata inicio for maior que a data fim adicione 1 ano */
            $data_fim->modify('+1 year');

            if ($data_nascimento < $data_inicio && $data_nascimento > $data_fim) {
                continue;
            }
        }
        if ($data_nascimento >= $data_inicio && $data_nascimento <= $data_fim) {
            echo "<h2>{$signo->signoNome}</h2>";
            $signo_encontrado = true;
            break;
        }
    }
    if (!$signo_encontrado) {
        echo "<p>Não foi possível determinar seu signo. Verifique a data informada.</p>";
    }
    ?>
    <a href="index.php" class="btn btn-secondary">Voltar</a>
</div>


</body>

</html>