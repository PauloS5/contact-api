<?php

require_once "../includes/connection.php";
require_once "../classes/Contact.php";

Contact::setConnection($conn);

$result = Contact::findByFilter("id>5");

foreach($result as $contact) {
    echo $contact;
}