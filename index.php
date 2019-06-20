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
<form class="form-signin" action="/processo.php" method="post">
    <!--    <img class="mb-4" src="../../assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">-->
    <h1 class="h3 mb-3 font-weight-normal">Informações do Veículo</h1>
    <label for="inputEmail" class="sr-only">Placa</label>
    <input type="text" id="Placa" class="form-control" name="placa" placeholder="Informe a placa do veículo" maxlength="11" required autofocus>
    <label for="inputEmail" class="sr-only">Renavam</label>
    <input type="text" id="Placa" class="form-control" name="renavam" placeholder="Informe o renavam do veículo" maxlength="11" required autofocus>


    <button class="btn btn-lg btn-primary btn-block" type="submit">Enviar</button>
</form>
</body>
</html>