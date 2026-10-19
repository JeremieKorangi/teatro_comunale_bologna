<?php

            session_start();
            unset($_SESSION["controlloreID"]);
            unset($_SESSION["nome_controllore"]);
            unset($_SESSION["mail_controllore"]);

header('Location: ../../amministratore');

exit();

