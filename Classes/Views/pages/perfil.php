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
            <div class="editar-perfil">
                <h2>Editando perfil!</h2>
                <?php
                if (isset($_SESSION['img']) && $_SESSION['img'] == '') {
                    echo ' <img src="' . INCLUDE_PATH_STATIC . 'images/images.png" />';
                } else {
                    echo ' <img src="' . INCLUDE_PATH . 'uploads/' . $_SESSION['img'] . '" />';
                }
                ?>
                <form method="post" enctype="multipart/form-data">
                    <label for="nome">Mudar nome</label>
                    <input type="text" name="nome" value="<?php echo $_SESSION['nome'] ?>">
                    <label for="senha">Mudar senha</label>
                    <input type="password" name="senha" placeholder="Sua nova Senha">
                    <label for="file">Mudar sua foto de perfil</label>
                    <input type="file" name="file">
                    <input type="hidden" name="atualizar" value="atualizar">
                    <input type="submit" name='acao' value='Salvar'>
                </form>
            </div><!--editar-perfil-->
        </div><!--feed-->
    </Section><!--main-feed-->
</body>

</html>