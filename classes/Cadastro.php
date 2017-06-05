<?php

require_once 'PessoaFisica.php';
require_once 'Controle.php';
require_once 'Usuario.php';

class Cadastro {

    public static function Incluir_PessoFisica($nome, $email, $renda, $dataNasc, $sexo) {
        $pf = new PessoaFisica();
        $pf->setNome($nome);
        $pf->setEmail($email);
        $pf->setRenda($renda);
        $pf->setDataNasc($dataNasc);
        $pf->setSexo($sexo);
        $ctr = new Controle($pf);
        if ($ctr->Incluir_PessoFisica() == 1) {
            echo "Successful insertion.";
        } else {
            echo "Error insertion.";
        }
    }

    public static function Editar_PessoFisica($codigo, $nome, $email, $renda, $dataNasc, $sexo) {
        $pf = new PessoaFisica();
        $pf->setCodigo($codigo);
        $pf->setNome($nome);
        $pf->setEmail($email);
        $pf->setRenda($renda);
        $pf->setDataNasc($dataNasc);
        $pf->setSexo($sexo);
        $ctr = new Controle($pf);
        if ($ctr->Editar_PessoFisica() == 1) {
            echo "Successful edition.";
        } else {
            echo "Error edition.";
        }
    }

    public static function Excluir_PessoFisica($codigo) {
        $pf = new PessoaFisica();
        $pf->setCodigo($codigo);
        $ctr = new Controle($pf);
        if ($ctr->Excluir_PessoFisica() == 1) {
            echo "Successful delete.";
        } else {
            echo "Error delete.";
        }
    }

    public static function Buscar_PessoaFisicaPorNome($nome) {
        $pf = new PessoaFisica();
        $pf->setNome($nome);
        $ctr = new Controle($pf);
        return $ctr->Buscar_PessoaFisicaPorNome();
    }

    public static function Buscar_PessoaFisicaPorCodigo($codigo) {
        $pf = new PessoaFisica();
        $pf->setCodigo($codigo);
        $ctr = new Controle($pf);
        return $ctr->Buscar_PessoaFisicaPorCodigo();
    }

    public static function Efetuar_Login($login, $senha) {
        $usu = new Usuario();
        $usu->setLogin($login);
        $usu->setSenha($senha);
        $ctr = new Controle("");
        $ctr->setUsuario($usu);
        return $ctr->Efetuar_Login();
    }
}

?>
