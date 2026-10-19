<?php

            session_start();
            unset($_SESSION["punto_di_venditaID"]);
            unset($_SESSION["nome_punto_di_vendita"]);
            unset($_SESSION["mail_punto_di_vendita"]);

header('Location: ../../amministratore');

exit();

