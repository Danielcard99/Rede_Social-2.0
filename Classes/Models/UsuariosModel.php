<?php

namespace Classes\Models;

class UsuariosModel
{

    public static function emailExists($email)
    {
        $pdo = \Classes\Mysql::connect();
        $verificar = $pdo->prepare("SELECT email FROM usuarios WHERE email = ?");
        $verificar->execute(array($email));

        if ($verificar->rowCount() == 1) {
            //Email existe
            return true;
        } else {
            return false;
        }
    }

    public static function listarComunidade()
    {
        $pdo = \Classes\Mysql::connect();

        $comunidade = $pdo->prepare("SELECT * FROM usuarios");
        $comunidade->execute();

        return $comunidade->fetchAll();
    }

    public static function solicitarAmizade($idPara)
    {
        $pdo = \Classes\Mysql::connect();

        $verificarAmizade = $pdo->prepare("SELECT * FROM amizades WHERE (enviou = ? AND recebeu = ?) OR (enviou = ? AND recebeu = ?) ");

        $verificarAmizade->execute([$_SESSION['id'], $idPara, $idPara, $_SESSION['id']]);

        if ($verificarAmizade->rowCount() == 1) {
            return false;
        } else {
            //Podemos inserir no banco a solicitação
            $insertAmizade = $pdo->prepare("INSERT INTO amizades VALUES (null,?,?,0)");
            if (
                $insertAmizade->execute([$_SESSION["id"], $idPara])
            ) {
                return true;
            }
        }

        return true;
    }

    public static function listarAmizadesPendentes()
    {
        $pdo = \Classes\Mysql::connect();

        $listarAmizadesPendentes = $pdo->prepare("SELECT * FROM amizades WHERE recebeu = ? AND status = 0");

        $listarAmizadesPendentes->execute(array($_SESSION['id']));

        return $listarAmizadesPendentes->fetchAll();
    }

    public static function getUsuarioById($id)
    {
        $pdo = \Classes\Mysql::connect();

        $usuario = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");

        $usuario->execute(array($id));

        return $usuario->fetch();
    }



    public static function existePedidoAmizade($idPara)
    {
        $pdo = \Classes\Mysql::connect();

        $verificarAmizade = $pdo->prepare("SELECT * FROM amizades WHERE (enviou = ? AND recebeu = ?) OR (enviou = ? AND recebeu = ?) ");

        $verificarAmizade->execute([$_SESSION['id'], $idPara, $idPara, $_SESSION['id']]);

        if ($verificarAmizade->rowCount() == 1) {
            return false;
        } else {
            return true;
        }
    }

    public static function atualizarPedidoAmizade($enviou, $status)
    {
        $pdo = \Classes\Mysql::connect();

        if ($status == 0) {
            //Recuse o pedido
            $del = $pdo->prepare("DELETE FROM amizades WHERE enviou = ? AND recebeu = ? AND status = 0");
            $del->execute(array($enviou, $_SESSION['id']));
        } else if ($status == 1) {
            $aceitarPedido = $pdo->prepare('UPDATE amizades SET status = 1 WHERE enviou = ? AND recebeu = ?');

            $aceitarPedido->execute(array($enviou, $_SESSION['id']));

            if ($aceitarPedido->rowCount() == 1) {
                return true;
            } else {
                return false;
            }
        }
    }

    public static function listarAmigos()
    {
        $pdo = \Classes\Mysql::connect();

        $amizades = $pdo->prepare("SELECt * FROM amizades WHERE (enviou = ? AND status = 1) OR (recebeu = ? AND status = 1)");

        $amizades->execute(array($_SESSION["id"], $_SESSION["id"]));

        $amizades = $amizades->fetchAll();
        $amigosConfirmados = array();
        foreach ($amizades as $key => $value) {
            if ($value['enviou'] == $_SESSION['id']) {
                $amigosConfirmados[] = $value['recebeu'];
            } else {
                $amigosConfirmados[] = $value['enviou'];
            }
        }

        $listaAmigos = array();

        foreach ($amigosConfirmados as $key => $value) {
            $listaAmigos[$key]['nome'] = self::getUsuarioById($value)['nome'];
            $listaAmigos[$key]['email'] = self::getUsuarioById($value)['email'];
            $listaAmigos[$key]['img'] = self::getUsuarioById($value)['img'];
        }
        return $listaAmigos;
    }
}