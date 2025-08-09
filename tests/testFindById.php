<?php

require_once "../includes/connection.php";
require_once "../classes/Contact.php";

Contact::setConnection($conn);

$result = Contact::findById(1);

echo $result;