<?php

namespace Classes\Controllers;

class PerfilController
{
    public function index()
    {
        if (isset($_SESSION['login'])) {

            if (isset($_POST['atualizar'])) {
                $pdo = \Classes\Mysql::connect();
                $nome = strip_tags($_POST['nome']);
                $senha = $_POST['senha'];

                if ($nome == '' || strlen($nome < 3)) {
                    \Classes\Utilidades::alerta('Você precisa inserir um nome');
                    \Classes\Utilidades::redirect(INCLUDE_PATH . 'perfil');
                }

                if ($senha != '') {
                    $senha = \Classes\Bcrypt::hash($senha);
                    $atualizar = $pdo->prepare("UPDATE usuarios SET nome = ?, senha = ? WHERE id = ?");
                    $atualizar->execute(array($nome, $senha, $_SESSION['id']));
                    $_SESSION['nome'] = $nome;
                } else {
                    $atualizar = $pdo->prepare("UPDATE usuarios SET nome = ? WHERE id = ?");
                    $atualizar->execute(array($nome, $_SESSION['id']));
                    $_SESSION['nome'] = $nome;
                }

                if ($_FILES['file']['tmp_name'] != '') {
                    $file = $_FILES['file'];
                    $fileExt = explode('.', $file['name']);
                    $fileExt = $fileExt[count($fileExt) - 1];
                    if ($fileExt == 'png' || $fileExt == 'jpg' || $fileExt == 'jpeg') {
                        //Formato válido
                        //Validar Tamanho
                        $size = intval($file['size'] / 1024);
                        if ($size <= 300) {
                            $uniqid = uniqid() . '.' . $fileExt;
                            $atualizarImagem = $pdo->prepare("UPDATE usuarios SET img = ? WHERE id = ? ");
                            $atualizarImagem->execute(array($uniqid, $_SESSION["id"]));
                            $_SESSION['img'] = $uniqid;
                            move_uploaded_file($file['tmp_name'], '/home/daniel/www/Rede_Social-2.0/uploads/' . $uniqid);
                            \Classes\Utilidades::alerta('Seu perfil foi atualizado junto com a foto!');
                            \Classes\Utilidades::redirect(INCLUDE_PATH . 'perfil');
                        } else {
                            \Classes\Utilidades::alerta('Erro ao processar seu arquivo!');
                            \Classes\Utilidades::redirect(INCLUDE_PATH . 'perfil');
                        }
                    } else {
                        \Classes\Utilidades::alerta('Erro ao processar seu arquivo!');
                        \Classes\Utilidades::redirect(INCLUDE_PATH . 'perfil');
                    }
                }

                \Classes\Utilidades::alerta('Seu perfil foi atualizado com sucesso!');
                \Classes\Utilidades::redirect(INCLUDE_PATH . 'perfil');
            }

            \Classes\Views\MainView::render('perfil');
        } else {
            \Classes\Utilidades::redirect(INCLUDE_PATH);
        }
    }
}