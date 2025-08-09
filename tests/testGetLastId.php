<?php

require_once "../includes/connection.php";
require_once "../classes/Contact.php";

Contact::setConnection($conn);

echo "Último id inserido na tabela: " . Contact::getLastId();