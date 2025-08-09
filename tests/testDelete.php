<?php

require_once "../includes/connection.php";
require_once "../classes/Contact.php";

Contact::setConnection($conn);

$result = Contact::findAll();
foreach($result as $contact) {
    $contact->delete();
}