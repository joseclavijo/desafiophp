<?php
header('Content-Type: text/html; charset=utf-8');
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header ('Last-Modified: ' . gmdate("D,d M YH:i:s") . ' GMT');
header ('Cache-Control: no-cache, must-revalidate');
header ('Pragma: no-cache');
header ('Content-type: application/x-msexcel');
header ('Content-Disposition: attachment; filename="planilha.xls"');
header ("Content-Description: PHP Generated Data" );

// Criamos uma tabela HTML com o formato da planilha
$html = '';
$html .= '<table>';
$html .= '<tr>';
$html .= '<td colspan="3">Planilha Veículo</tr>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td><b>PLACA</b></td>';
$html .= '<td><b>RENAVAM</b></td>';
$html .= '<td><b>CHASSIS</b></td>';
$html .= '<td><b>MARCA</b></td>';
$html .= '<td><b>COR</b></td>';
$html .= '<td><b>ANO</b></td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td>'.$_POST['placa'].'</td>';
$html .= '<td>'.$_POST['renavam'].'</td>';
$html .= '<td>'.$_POST['chassi'].'</td>';
$html .= '<td>'.$_POST['marca'].'</td>';
$html .= '<td>'.$_POST['cor'].'</td>';
$html .= '<td>'.$_POST['ano'].'</td>';
$html .= '</tr>';
$html .= '</table>';
echo $html;
// Configurações header para forçar o download



// Envia o conteúdo do arquivo

exit;