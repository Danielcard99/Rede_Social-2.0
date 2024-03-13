<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="<?php echo INCLUDE_PATH_STATIC ?>css/style.css">

</head>

<body>
    <div class="sidebar"></div><!--sidebar-->
    <div class="form-container-login">
        <div class="logo-chamada-login">
            <img src="<?php echo INCLUDE_PATH_STATIC ?>images/logo_trial.fw.svg" alt="logo da rede social">
            <p>Conecte-se com seus amigos e expanda seus aprendizados com a nossa rede social.</p>
        </div><!--logo-chamada-login-->

        <div class="form-login">
            <form method="post">
                <input type="text" name="email" placeholder="Email">
                <input type="password" name="senha" placeholder="Senha">
                <input type="submit" name="acao" value="Entrar">
                <input type="hidden" name="login">
            </form>
            <p><a href="<?php INCLUDE_PATH ?>registrar">Criar Nova Conta</a></p>
        </div><!--form-login-->
    </div><!--form-container-login-->
</body>

</html>