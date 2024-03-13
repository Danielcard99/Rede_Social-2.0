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

</head>

<body>
    <Section class="main-feed">
        <?php include('includes/sidebar.php') ?>

        <div class="feed">
            <div class="feed-wraper">
                <div class="feed-form">
                    <form method="post">
                        <textarea required name="post_content"
                            placeholder="No que você está pensando, <?php echo $_SESSION['nome']; ?>?" cols="30"
                            rows="10"></textarea>
                        <input type="hidden" name="post_feed">
                        <input type="submit" name="acao" value="Postar">
                    </form>
                </div><!--feed-form-->

                <?php
                $retrievePosts = \Classes\Models\HomeModel::retrieveFriendsPosts();
                foreach ($retrievePosts as $key => $value) {


                    ?>

                    <div class="feed-single-post">
                        <div class="feed-single-post-author">
                            <div class="img-single-post-author">
                                <?php
                                if (!isset($value['me']) && $value['img'] == '') {
                                    ?>
                                    <img src="<?php echo INCLUDE_PATH_STATIC ?>images/images.png">
                                <?php } else if (!isset($value['me'])) { ?>
                                        <img src="<?php echo INCLUDE_PATH ?>uploads/<?php echo $value['img'] ?>">
                                <?php } ?>

                                <?php
                                if (isset($value['me']) && $_SESSION['img'] == '') {
                                    ?>
                                    <img src="<?php echo INCLUDE_PATH_STATIC ?>images/images.png">
                                <?php } else if (isset($value['me'])) { ?>
                                        <img src="<?php echo INCLUDE_PATH ?>uploads/<?php echo $_SESSION['img'] ?>">
                                <?php } ?>

                            </div><!--img-single-post-author-->
                            <div class="feed-single-post-author-info">
                                <?php if (isset($value['me'])) { ?>
                                    <h2>
                                        <?php echo $_SESSION['nome']; ?>
                                        (eu)
                                    </h2>
                                <?php } else { ?>
                                    <h2>
                                        <?php echo $value['usuario'] ?>
                                    </h2>
                                <?php } ?>
                                <p>
                                    <?php echo date('d/m/Y H:i:s', strtotime($value['data'])) ?>
                                </p>
                            </div><!--feed-single-post-author-info-->
                        </div><!--feed-single-post-author-->
                        <div class="feed-single-post-content">
                            <?php echo $value['conteudo'] ?>
                        </div><!--feed-single-post-content-->
                    </div><!--feed-single-post-->

                <?php } ?>

            </div><!--feed-wraper-->
            <div class="friends-request-feed">
                <h4>Solicitações de Amizade</h4>

                <?php
                foreach (\Classes\Models\UsuariosModel::listarAmizadesPendentes() as $key => $value) {
                    $usuarioInfo = \Classes\Models\UsuariosModel::getUsuarioById($value['enviou']);

                    ?>
                    <div class="friends-request-single">
                        <img src="<?php echo INCLUDE_PATH_STATIC ?>images/images.png">
                        <div class="friends-request-single-info">
                            <h3>
                                <?php echo $usuarioInfo['nome'] ?>
                            </h3>
                            <p><a
                                    href="<?php echo INCLUDE_PATH ?>?aceitarAmizade=<?php echo $usuarioInfo['id'] ?>">Aceitar</a>
                                | <a
                                    href="<?php echo INCLUDE_PATH ?>?recusarAmizade=<?php echo $usuarioInfo['id'] ?>">Recusar</a>
                            </p>
                        </div><!--friends-single-info-->
                    </div><!--friends-request-single-->

                <?php } ?>
            </div><!--friend-request-feed-->
        </div><!--feed-->
    </Section><!--main-feed-->
</body>

</html>