<?php

            session_start();
            unset($_SESSION["id_account"]);
            unset($_SESSION["nome_utente"]);
            unset($_SESSION["indirizzo_mail"]);
            unset($_SESSION["tipologia"]);

header('Location: ../../');

exit();

