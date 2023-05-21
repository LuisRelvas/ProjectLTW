<?php
    declare(strict_types = 1);
    require_once(dirname(__DIR__).'/classes/session.class.php');

    function valid_name(String $attemp) : bool {
        if (!preg_match ("/^[a-zA-Z\s]+$/", $attemp)) {
            $session = new Session();
            $session->addMessage('warning', "Formato de nome inválido");
            return false;
        }
        return true;
    }

    function valid_answer(String $attemp) : bool {
        if (!preg_match("/^[\p{L}A-Za-z0-9\s\?\.,!]+$/u", $attemp))
        {
            $session = new Session();
            $session->addMessage('warning', "Formato de resposta inválido");
            return false;
        }
        return true;
    }

    function valid_email(String $attemp) : bool {
        if (filter_var($attemp, FILTER_VALIDATE_EMAIL) == NULL) {
            $session = new Session();
            $session->addMessage('warning', "Formato de email inválido");
            return false;
        }
        return true;
    }

    function valid_password(String $attemp) : bool {

        $uppercase = preg_match('@[A-Z]@', $attemp);
        $lowercase = preg_match('@[a-z]@', $attemp);
        $number = preg_match('@[0-9]@', $attemp);

        if (!$uppercase || !$lowercase || !$number || strlen(($_POST['password2'])) < 8) {
            $session = new Session();
            $session->addMessage('warning', "A nova palavra passe deve conter pelo menos 8 caracteres, ter uma letra maiúscula, uma letra minúscula e um número");
            return false; 
        }
        return true;
    }

    function valid_CSRF(String $attemp) : bool {
        if ($_SESSION['csrf'] !== $attemp) {
            $session = new Session();
            $session->addMessage('error', "Operação inválida");
            return false;
        }
        return true;
    }

    function filter_text(String $text) : String {
        return preg_replace ("/[^a-zA-Z0-9\s]/", '', $text);
    }
?>