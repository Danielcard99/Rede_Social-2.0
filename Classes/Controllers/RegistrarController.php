<?php

namespace Classes\Controllers;



class RegistrarController
{
    public function index()
    {
        if (isset($_POST['registrar'])) {
            $nome = $_POST['nome'];
            $email = $_POST['email'];
            $senha = $_POST['senha'];

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                \Classes\Utilidades::alerta('E-mail inválido!');
                \Classes\Utilidades::redirect(INCLUDE_PATH . 'registrar');
            } else if (strlen($senha) < 6) {
                \Classes\Utilidades::alerta('Sua senha é muito curta!');
                \Classes\Utilidades::redirect(INCLUDE_PATH . 'registrar');
            } else if (\Classes\Models\UsuariosModel::emailExists($email)) {
                \Classes\Utilidades::alerta('Este email já existe no banco de dados');
                \Classes\Utilidades::redirect(INCLUDE_PATH);
            } else {
                // Registrar usuário
                $senha = \Classes\Bcrypt::hash($senha);
                $registro = \Classes\Mysql::connect()->prepare("INSERT INTO usuarios VALUES (null,?,?,?,'')");
                $registro->execute(array($nome, $email, $senha));

                \Classes\Utilidades::alerta('Registrado com sucesso!');
                \Classes\Utilidades::redirect(INCLUDE_PATH);
            }
        }

        \Classes\Views\MainView::render("registrar");
    }
}


