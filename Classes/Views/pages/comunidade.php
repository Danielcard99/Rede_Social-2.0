<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem vindo
        <?php echo $_SESSION['nome']; ?>
    </title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <script src="https://kit.fontawesome.com/a63547dbd3.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?php echo INCLUDE_PATH_STATIC ?>css/home.css">
    <link rel="stylesheet" href="<?php echo INCLUDE_PATH_STATIC ?>css/comunidade.css">

</head>

<body>
    <Section class="main-feed">
        <?php include('includes/sidebar.php') ?>

        <div class="feed">
            <div class="comunidade">
                <div class="container-comunidade">
                    <h4>Amigos</h4>
                    <div class="container-comunidade-wraper">
                        <?php
                        foreach (\Classes\Models\UsuariosModel::listarAmigos() as $key => $value) {


                            ?>
                            <div class="container-comunidade-single">
                                <div class="img-comunidade-user-single">
                                    <?php
                                    if ($value['img'] == '') {

                                        ?>
                                        <img src="<?php echo INCLUDE_PATH_STATIC ?>images/images.png" />
                                    <?php } else { ?>
                                        <img src="<?php echo INCLUDE_PATH ?>uploads/<?php echo $value['img'] ?>">
                                    <?php } ?>
                                </div><!--img-comunidade-user-single-->
                                <div class="info-comunidade-user-single">
                                    <h2>
                                        <?php echo $value['nome']; ?>
                                    </h2>
                                    <p>
                                        <?php echo $value['email']; ?>
                                    </p>
                                </div><!--info-comunidade-user-single-->
                            </div><!--container-comunidade-single-->

                        <?php } ?>

                    </div><!--container-comunidade-wraper-->
                </div><!--container-comunidade-->


                <div class="container-comunidade">
                    <h4>Comunidade</h4>
                    <div class="container-comunidade-wraper">

                        <?php
                        $comunidade = \Classes\Models\UsuariosModel::listarComunidade();

                        foreach ($comunidade as $key => $value) {

                            $pdo = \Classes\Mysql::connect();
                            $verificarAmizade = $pdo->prepare("SELECT * FROM amizades WHERE (enviou = ? AND recebeu = ? And status = 1) OR (enviou = ? AND recebeu = ? And status = 1)");

                            $verificarAmizade->execute(array($value['id'], $_SESSION['id'], $_SESSION['id'], $value['id']));
                            if ($verificarAmizade->rowCount() == 1) {
                                //Já são amigos
                                continue;
                            }

                            if ($value['id'] == $_SESSION['id']) {
                                continue;
                            }

                            ?>

                            <div class="container-comunidade-single">
                                <div class="img-comunidade-user-single">
                                    <img src="<?php echo INCLUDE_PATH_STATIC ?>images/images.png" />
                                </div><!--img-comunidade-user-single-->
                                <div class="info-comunidade-user-single">
                                    <h2>
                                        <?php echo $value['nome'] ?>
                                    </h2>
                                    <p>
                                        <?php echo $value['email'] ?>
                                    </p>
                                    <div class="btn-solicitar-amizade">
                                        <?php
                                        if (\Classes\Models\UsuariosModel::existePedidoAmizade($value['id'])) {

                                            ?>
                                            <a
                                                href="<?php echo INCLUDE_PATH ?>comunidade?solicitarAmizade=<?php echo $value['id'] ?>">Solicitar
                                                Amizade</a>
                                        <?php } else { ?>
                                            <a href="javascript:void(0)" style="border:0;color:orange">Pedido pendente</a></a>
                                        <?php } ?>
                                    </div><!--btn-solicitar-amizade-->
                                </div><!--info-comunidade-user-single-->
                            </div><!--container-comunidade-single-->

                        <?php } ?>
                    </div><!--container-comunidade-wraper-->
                </div><!--container-comunidade-->
            </div><!--comunidade-->
        </div><!--feed-->
    </Section><!--main-feed-->
</body>

</html>