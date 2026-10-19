<?php

            session_start();
            unset($_SESSION["adminID"]);
            unset($_SESSION["nome_admin"]);
            unset($_SESSION["mail_admin"]);

header('Location: ../../amministratore');

exit();

