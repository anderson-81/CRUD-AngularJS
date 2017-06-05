<?php

require './classes/Cadastro.php';


error_reporting(0);
session_start();

if (isset($_SESSION['login'])) {
    $post = json_decode(file_get_contents("php://input"));
    $opcao = htmlspecialchars(addslashes(trim($post->opcao)));
    $hash = htmlspecialchars(addslashes(trim($post->token)));

    if (isset($opcao)) {
        if ($opcao == 1) {
            if ($_SESSION['_token'] == $hash) {
                if (($post->nome != "") && ($post->email != "") && ($post->renda != "") && ($post->dataNasc != "") && ($post->sexo != "")) {
                    $nome = htmlspecialchars(addslashes(trim($post->nome)));
                    $email = htmlspecialchars(addslashes(trim($post->email)));
                    $renda = htmlspecialchars(addslashes(trim($post->renda)));
                    $dataNasc = htmlspecialchars(addslashes(trim($post->dataNasc)));
                    $sexo = htmlspecialchars(addslashes(trim($post->sexo)));
                    echo Cadastro::Incluir_PessoFisica($nome, $email, $renda, $dataNasc, $sexo);
                } else {
                    echo "There Required Fields for insertion empty.";
                }
            } else {
                die('Fail.');
            }
        }

        if ($opcao == 2) {
            if ($_SESSION['_token'] == $hash) {
                if (($post->codigo != "") && ($post->nome != "") && ($post->email != "") && ($post->renda != "") && ($post->dataNasc != "") && ($post->sexo != "")) {
                    $codigo = htmlspecialchars(addslashes(trim($post->codigo)));
                    $nome = htmlspecialchars(addslashes(trim($post->nome)));
                    $email = htmlspecialchars(addslashes(trim($post->email)));
                    $renda = htmlspecialchars(addslashes(trim($post->renda)));
                    $dataNasc = htmlspecialchars(addslashes(trim($post->dataNasc)));
                    $sexo = htmlspecialchars(addslashes(trim($post->sexo)));
                    echo Cadastro::Editar_PessoFisica($codigo, $nome, $email, $renda, $dataNasc, $sexo);
                } else {
                    echo "There Required Fields for edition empty.";
                }
            } else {
                die('Fail.');
            }
        }

        if ($opcao == 3) {
            if ($_SESSION['_token'] == $hash) {
                if ($post->codigo != "") {
                    $codigo = htmlspecialchars(addslashes(trim($post->codigo)));
                    echo Cadastro::Excluir_PessoFisica($codigo);
                } else {
                    echo "Code was not informed for deletion.";
                }
            } else {
                die('Fail.');
            }
        }

        if ($opcao == 4) {
            if ($_SESSION['_token'] == $hash) {
                $dado = htmlspecialchars(addslashes(trim($post->dado)));
                echo json_encode(Cadastro::Buscar_PessoaFisicaPorNome($dado));
            } else {
                die('Fail.');
            }
        }

        if ($opcao == 5) {
            if ($_SESSION['_token'] == $hash) {
                $dado = htmlspecialchars(addslashes(trim($post->dado)));
                echo json_encode(Cadastro::Buscar_PessoaFisicaPorCodigo($dado));
            } else {
                die('Fail.');
            }
        }

        if ($opcao == 7) {
            echo VerificarSessao();
        }

        if ($opcao == 8) {
            session_destroy();
            echo "Session successfully closed.";
        }
    }
} else {
    $post = json_decode(file_get_contents("php://input"));
    $opcao = htmlspecialchars(addslashes(trim($post->opcao)));
    if ($opcao == 6) {
        $hash = htmlspecialchars(addslashes(trim($post->token)));
        if ($_SESSION['_token'] == $hash) {
            $login = htmlspecialchars(addslashes(trim($post->login)));
            $senha = htmlspecialchars(addslashes(trim($post->senha)));

            if (($login != "") && ($senha  != "")) {
                echo json_encode(Cadastro::Efetuar_Login($login, $senha));
            } else {
                echo "There Required Fields for login empty.";
            }
        } else {
            die('Fail.');
        }
    }

    if ($opcao == 7) {
        echo VerificarSessao();
    }
}

function VerificarSessao() {
    if (isset($_SESSION['login'])) {
        return 1;
    } else {
        return 0;
    }
}

?>