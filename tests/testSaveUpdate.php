<?php

require_once '../includes/connection.php';
require_once '../classes/Contact.php';
require_once '../helpers/Generators.php';

Contact::setConnection($conn);

$c = new Contact;
$c->name = "Paulo Sócrates";
$c->phoneNumber = Generators::generatePhoneNumber();
$c->email = "paulo@email.com";
$c->save();

echo "<b>Old record</b><br>";
print $c . "<br>";

$c->name = "Paulo Sócrates de Souza Pinheiro";
$c->save();

echo "<b>New record</b><br>";
print $c;