<?php

require_once './includes/connection.php';
require_once './classes/Contact.php';

Contact::setConnection($conn);
header("Content-Type: application/json");

$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case "POST":
        $contact = new Contact;
        
        $contact->name = htmlspecialchars(trim(@$_POST["name"]));
        $contact->phoneNumber = substr(htmlspecialchars(trim(@$_POST["phoneNumber"])), 0, 11);
        $contact->email = htmlspecialchars(trim(@$_POST["email"]));
        
        if (!(isset($contact->name) && isset($contact->phoneNumber))) {
            http_response_code(400);
            echo json_encode([
                "error" => "400 Bad Request - null value informed"
            ]);
            die();
        }
        
        if (!ctype_digit($contact->phoneNumber)) {
            http_response_code(400);
            echo json_encode([
                "error" => "400 Bad Request - 'phoneNumber' can only contain numbers"
            ]);
            die();
        }
        if (!empty($contact->email) && !filter_var($contact->email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo json_encode([
                "error" => "400 Bad Request - 'email' is not in a valid format"
            ]);
            die();
        }
        if (!empty(Contact::findByFilter("phoneNumber=$contact->phoneNumber"))) {
            http_response_code(409);

            echo json_encode([
                "error" => "409 Conflict - 'phoneNumber' already exists"
            ]);
            
            die();
        }
        
        $contact->save();
        http_response_code(201);
        echo json_encode([
            "success" => "201 Created - contact created"
        ]);
        
        die();
        break;
    
    case "GET":
        $id = @$_GET["id"];
        
        if(!empty($id)) {
            $contact = Contact::findById($id);
            
            if (empty($contact)) {
                http_response_code(404);
                echo json_encode([
                    "error" => "404 Not Found - Contact with this id not exists"
                ]);
                die();
            }
            
            http_response_code(200);
            echo json_encode($contact->getData());
        } else {
            $contacts = Contact::findAll();
            
            $result = [];
            foreach($contacts as $c) {
                $result[] = $c->getData();
            }
            
            http_response_code(200);
            echo json_encode($result);
        }
        
        die();
        break;
    
    case "PUT":
        parse_str(file_get_contents("php://input"), $put_vars);
        
        $contact = new Contact;
        
        $contact->id = htmlspecialchars(trim(@$put_vars["id"]));
        $contact->name = htmlspecialchars(trim(@$put_vars["name"]));
        $contact->phoneNumber = substr(htmlspecialchars(trim(@$put_vars["phoneNumber"])), 0, 11);
        $contact->email = htmlspecialchars(trim(@$put_vars["email"]));
        
        if (!(isset($contact->name) && isset($contact->phoneNumber) && isset($contact->id))) {
            http_response_code(400);
            echo json_encode([
                "error" => "400 Bad Request - null value informed"
            ]);
            die();
        }
        
        if (!ctype_digit($contact->phoneNumber)) {
            http_response_code(400);
            echo json_encode([
                "error" => "400 Bad Request - 'phoneNumber' can only contain numbers"
            ]);
            die();
        }
        if (!empty($contact->email) && !filter_var($contact->email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo json_encode([
                "error" => "400 Bad Request - 'email' is not in a valid format"
            ]);
            die();
        }
        
        if (empty(Contact::findById($contact->id))) {
            http_response_code(404);
            echo json_encode([
                "error" => "404 Not Found - not exists a contact with this id"
            ]);
            die();
        }
        if (!empty(Contact::findByFilter("phoneNumber=$contact->phoneNumber"))) {
            if (!(Contact::findByFilter("phoneNumber=$contact->phoneNumber")[0]->id == $contact->id)) {
                http_response_code(400);
                echo json_encode([
                    "error" => "400 Bad request - already exists a contacts with this number"
                ]);
                die();
            }
        }
        
        $contact->save();
        http_response_code(200);
        echo json_encode([
            "success" => "200 OK - contact atualized"
        ]);

        die();
        break;
    
    case "PATCH":
        parse_str(file_get_contents("php://input"), $patch_vars);
        
        $id = htmlspecialchars(trim($patch_vars["id"]));
        $column = htmlspecialchars(trim($patch_vars["column"]));
        $value = htmlspecialchars(trim($patch_vars["value"]));
        
        if (!(isset($id) && isset($column) && isset($value))) {
            http_response_code(400);
            echo json_encode([
                "error" => "400 Bad Request - null value informed"
            ]);
            die();
        }
        if (!in_array($column, ["name", "phoneNumber", "email"])) {
            http_response_code(400);
            echo json_encode([
                "error" => "400 Bad Request - column '$column' not exists"
            ]);
            die();
        }

        if (empty(Contact::findById($id))) {
            http_response_code(404);
            echo json_encode([
                "error" => "404 Not Found - not exists a contact with this id"
            ]);
            die();
        }      
        if ($column === "phoneNumber") {
            if (!empty(Contact::findByFilter("phoneNumber=$value"))) {
                if (!(Contact::findByFilter("phoneNumber=$value")[0]->id == $id)) {
                    http_response_code(400);
                    echo json_encode([
                        "error" => "400 Bad request - already exists a contacts with this number"
                    ]);
                    die();
                }
            }
        }
        
        $contact = Contact::findById($id);
        
        $contact->$column = $value;
        $contact->save();
        http_response_code(200);
        echo json_encode([
            "success" => "200 OK - contact atualized"
        ]);
        
        die();
        break;
    
    case "DELETE":
        parse_str(file_get_contents("php://input"), $delete_vars);
        
        $contact = new Contact;
        
        $contact->id = htmlspecialchars(trim($delete_vars["id"]));
        
        if (!isset($contact->id)) {
            http_response_code(400);
            echo json_encode([
                "error" => "400 Bad Request - null value informed"
            ]);
            die();
        }
        
        if (empty(Contact::findById($contact->id))) {
            http_response_code(404);
            echo json_encode([
                "error" => "404 Not Found - not exists a contact with this id"
            ]);
            die();
        }
        
        $contact->delete();
        http_response_code(200);
        echo json_encode([
            "success" => "200 OK - contact deleted"
        ]);

        die();
        break;
        
    case "OPTIONS":
        header("Allow: POST, GET, PUT, PATCH, DELETE, OPTIONS");
        http_response_code(204);
        die();
        break;
    
    default:
        http_response_code(501);
        echo json_encode([
            "error" => "501 Method Not Implemented - the method $request_method not was implemented"
        ]);
        die();
        
        break;
}