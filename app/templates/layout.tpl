<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <title>Semana da computação 2017</title>
    <meta name="Description" content="Semana da computação 2017"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">

    <!-- Bootstrap css -->
    <link href="{base_url}/css/bootstrap.min.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- carrent css -->
    <link href="{base_url}/css/semcomp.css" rel="stylesheet">
</head>
<body>
<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
                <a class="navbar-brand" href="{base_url}/">SemComp2017</a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href="{path_for name="confirmar"}">Confirmar</a></li>
                <li><a href="{path_for name="relatorio"}">Relatório</a></li>
                <li><a href="{path_for name="relatorioConfirmado"}">Lista de Confirmados</a></li>
            </ul>
        </div>
    </div>
</div>

<div class="container content">
    {block name=content}{/block}
</div>

<!-- jQuery -->
<script src="{base_url}/js/jquery-2.1.0.min.js"></script>
<!-- Bootstrap js -->
<script src="{base_url}/js/bootstrap.min.js"></script>
{block name=javascript}{/block}
</body>
</html>