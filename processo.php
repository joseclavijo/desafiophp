<?php

$pasta_cookies = 'cookies/';
define('COOKIELOCAL', str_replace('\\', '/', realpath('./')).'/'.$pasta_cookies);
define('HTTPCOOKIELOCAL',$pasta_cookies);
@session_start();
$cookieFile = COOKIELOCAL.session_id();
$cookieFile_fopen = HTTPCOOKIELOCAL.session_id();

if(!file_exists($cookieFile))
{
    $file = fopen($cookieFile, 'w');
    fclose($file);
}

$url = 'http://getran.detran.df.gov.br/site/Captcha.jsp';	// url do captcha do detran
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:8.0) Gecko/20100101 Firefox/8.0');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$return = curl_exec($ch);
curl_close($ch);

$imgsource = str_replace('Quanto é ','', $return);
$imgsource = str_replace('?','', $imgsource);
$segundo = (int) trim(str_replace('+','', strstr(trim($imgsource),'+')));
$primeiro = (int) trim(strstr(trim($imgsource),'+', true));
$soma = ($primeiro + $segundo);

//echo $return.' = '.$soma.'<br/>';
###################################### RESULTADO E COOKIE ################################


$file = fopen($cookieFile_fopen, 'r');
$conteudo = fread($file, 1024);
fclose ($file);
$inicio = strstr($conteudo,'JSESSIONID');
$cookie = str_replace('JSESSIONID	','JSESSIONID=',strstr($inicio, 'esteem',true).'esteem;');
$cookie .= '_ga=GA1.4.402324376.1560987054; _gid=GA1.4.1287405304.1560987054; SERVERID=A'; // token do captcha
$url2 = 'http://getran.detran.df.gov.br/site/veiculos/consultas/consulta-veiculo.jsp';	// url a ser extraida

// passando os parametros pro post
$post = 'PLACA='.$_POST['placa'].'&RENAVAM='.$_POST['renavam'].'&CODSEG='.$soma;


$ch = curl_init($url2);
curl_setopt($ch, CURLOPT_POST, false);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);		// aqui estao os campos de formulario
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);	// dados do arquivo de cookie
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);	// dados do arquivo de cookie
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:8.0) Gecko/20100101 Firefox/8.0');
curl_setopt($ch, CURLOPT_COOKIE, $cookie);	    // dados de sessao
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
curl_setopt($ch, CURLOPT_REFERER, 'http://getran.detran.df.gov.br/site/veiculos/consultas/consulta-veiculo.jsp');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$html = curl_exec($ch);
curl_close($ch);


// fazendo o include do extrator de dados html

include ('simple_html_dom.php');

$html2 = str_get_html($html);


// extraindo is dados das div html

$placa = $html2->find('input[id="Placa"]');
$renavam = $html2->find('input[id="Renavam"]');
$chassi = $html2->find('input[id="Chassi"]');
$marcaModelo = $html2->find('input[id="MarcaModelo"]');
$cor = $html2->find('input[id="Cor"]');
$fabricacao = $html2->find('input[id="AnoGabModelo"]');

$informacoes = [
    'placa' => $placa[0]->value,
    'renavam' => $renavam[0]->value,
    'chassi' => $chassi[0]->value,
    'marca' => $marcaModelo[0]->value,
    'cor' => $cor[0]->value,
    'ano' => $fabricacao[0]->value,
];

?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!--    <link rel="icon" href="../../../../favicon.ico">-->

    <title>Consulta Veiculo Dentra DF</title>

    <!-- Principal CSS do Bootstrap -->
    <link href="https://getbootstrap.com.br/docs/4.1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Estilos customizados para esse template -->
    <link href="https://getbootstrap.com.br/docs/4.1/examples/sign-in/signin.css" rel="stylesheet">
</head>

<body class="text-center">
<div class="container">

    <h1>Informações do Veículo:</h1>
    <br>

    <table class="table">
        <thead>
        <tr>
            <th>PLACA</th>
            <th>RENAVAM</th>
            <th>CHASSI</th>
            <th>MARCA/MODELO</th>
            <th>COR</th>
            <th>ANO FABRICACAO</th>
            <th>ARQUIVO</th>
        </tr>
        </thead>

        <tbody>

        <td><?= $informacoes['placa']?></td>
        <td><?= $informacoes['renavam']?></td>
        <td><?= $informacoes['chassi']?></td>
        <td><?= $informacoes['marca']?></td>
        <td><?= $informacoes['cor']?></td>
        <td><?= $informacoes['ano']?></td>
        <td>
            <form action="xls.php" method="post">
                <input type="hidden" name="placa" value="<?= $informacoes['placa']?>">
                <input type="hidden" name="renavam" value="<?= $informacoes['renavam']?>">
                <input type="hidden" name="chassi" value="<?= $informacoes['chassi']?>">
                <input type="hidden" name="marca" value="<?= $informacoes['marca']?>">
                <input type="hidden" name="cor" value="<?= $informacoes['cor']?>">
                <input type="hidden" name="ano" value="<?= $informacoes['ano']?>">
                <button class="btn btn-md btn-primary btn-block" type="submit">Baixar</button>
            </form>
        </td>

        </tbody>
    </table>
</div>
</body>
</html>