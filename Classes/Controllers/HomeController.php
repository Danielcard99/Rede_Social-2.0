<?php

namespace Classes\Controllers;

class HomeController
{
    public function index()
    {
        if (isset($_GET["logout"])) {
            session_unset();
            session_destroy();
            \Classes\Utilidades::redirect(INCLUDE_PATH);
        }


        if (isset($_SESSION["login"])) {
            //Renderiza a home do usuário

            // Existe pedido de amizade?
            if (isset($_GET['recusarAmizade'])) {
                $idEnviou = (int) $_GET['recusarAmizade'];
                \Classes\Models\UsuariosModel::atualizarPedidoAmizade($idEnviou, 0);
                \Classes\Utilidades::alerta('Amizade Recusada!');
                \Classes\Utilidades::redirect(INCLUDE_PATH);
            } else if (isset($_GET['aceitarAmizade'])) {
                $idEnviou = (int) $_GET['aceitarAmizade'];
                if (\Classes\Models\UsuariosModel::atualizarPedidoAmizade($idEnviou, 1)) {
                    \Classes\Utilidades::alerta('Amizade Aceita!');
                    \Classes\Utilidades::redirect(INCLUDE_PATH);
                } else {
                    \Classes\Utilidades::alerta('Oops.. Um erro ocorreu!');
                    \Classes\Utilidades::redirect(INCLUDE_PATH);
                }

            }

            // Existe postagem no feeed

            if (isset($_POST['post_feed'])) {

                if ($_POST['post_content'] == '') {
                    \Classes\Utilidades::alerta('Não permitimos posts vazios :(');
                    \Classes\Utilidades::redirect(INCLUDE_PATH);
                }

                \Classes\Models\HomeModel::postFeed($_POST['post_content']);
                \Classes\Utilidades::alerta('Post feito com sucesso!');
                \Classes\Utilidades::redirect(INCLUDE_PATH);
            }



            \Classes\Views\MainView::render("home");
        } else {
            if (isset($_POST['login'])) {
                $login = $_POST['email'];
                $senha = $_POST['senha'];

                $verifica = \Classes\Mysql::connect()->prepare('SELECT * FROM usuarios WHERE email = ?');
                $verifica->execute(array($login));

                if ($verifica->rowCount() == 0) {
                    \Classes\Utilidades::alerta('Não existe usuário com esse email!');
                    \Classes\Utilidades::redirect(INCLUDE_PATH);
                } else {
                    $dados = $verifica->fetch();
                    $senhaBanco = $dados['senha'];
                    if (\Classes\Bcrypt::check($senha, $senhaBanco)) {
                        // Usuário logado com sucesso
                        $_SESSION['login'] = $dados['email'];
                        $_SESSION['id'] = $dados['id'];
                        $_SESSION['nome'] = explode(' ', $dados['nome'])[0];
                        $_SESSION['img'] = $dados['img'];
                        \Classes\Utilidades::redirect(INCLUDE_PATH);

                    } else {
                        \Classes\Utilidades::alerta('Senha incorreta!');
                        \Classes\Utilidades::redirect(INCLUDE_PATH);
                    }
                }
            }
            \Classes\Views\MainView::render("login");
        }
    }
}

