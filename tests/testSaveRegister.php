<?php

require_once '../includes/connection.php';
require_once '../classes/Contact.php';
require_once '../helpers/Generators.php';

Contact::setConnection($conn);

$contacts = [];
for ($i = 0; $i < 10; $i++) {
    $contacts[] = new Contact;
    $contacts[$i]->name = Generators::generateFullName();
    $contacts[$i]->phoneNumber = Generators::generatePhoneNumber();
    $contacts[$i]->email = Generators::generateEmail();
}

foreach ($contacts as $c) {
    $c->save();
    echo $c . "<br>";
}