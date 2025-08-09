<?php

class Contact {
    private static $conn;
    private $data;
    
    // Método para estalecer conexão
    public static function setConnection(PDO $conn) {
        self::$conn = $conn;
    }
    
    // Métodos mágicos para manipulação de dados
    public function __set($prop, $value) {
        $this->data[$prop] = $value;
    }
    public function __get($prop) {
        return $this->data[$prop];
    }
    
    // Outros métodos mágicos
    public function __toString() {
        return "<table border>" .
            "<tr>" .
                "<th colspan='4'>Contato</th>" .
            "</tr>" .
            "<tr>" .
                "<th>Id</th>" .
                "<th>Name</th>" .
                "<th>Phone Number</th>" .
                "<th>E-mail</th>" .
            "</tr>" .
            "<tr>" .
                "<td>" .@$this->id . "</td>" .
                "<td>{$this->name}</td>" .
                "<td>{$this->getFormatedPhoneNumber()}</td>" .
                "<td>{$this->email}</td>" .
            "</tr>" .
        "</table>";    
    }
    public function __debugInfo() {
        return [
            "id" => @$this->id,
            "name" => $this->name,
            "phoneNumber" => $this->phoneNumber,
            "email" => $this->email
        ];
    }
    public function __isset($prop) {
        return isset($this->data[$prop]);
    }
    public function __empty($prop) {
        return empty($this->data[$prop]);
    }
    
    // Métodos para realizar buscas no banco de dados
    public static function findAll() {
        $query = "SELECT * FROM tbContacts";
        
        $stmt = self::$conn->query($query);
        
        $result = $stmt->fetchAll(PDO::FETCH_CLASS, __CLASS__);
        
        return $result;
    }
    public static function findById($id) {
        $query = "SELECT * FROM tbContacts WHERE id = :id";
        
        $stmt = self::$conn->prepare($query);
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        
        $result = $stmt->fetchObject(__CLASS__);
        
        return $result;
    }
    public static function findByFilter(...$filters) {
        $query = "SELECT * FROM tbContacts WHERE ";
        
        foreach ($filters as $filter) {
            $query .= $filter . ",";
        }
        $query[strlen($query)-1] = ' ';
        
        $stmt = self::$conn->query($query);
        
        $result = $stmt->fetchAll(PDO::FETCH_CLASS, __CLASS__);
        
        return $result;
    }
    
    // Métodos para manipular registros no banco de dados
    public function save() {
        if (!isset($this->id)) {
            $cmd = "INSERT INTO tbContacts(id, name, phoneNumber, email) " .
                "VALUES (:id, :name, :phoneNumber, :email)";
        
            $this->id = self::getLastId()+1;
                    
            $stmt = self::$conn->prepare($cmd);
            $stmt->bindValue(":id", $this->id);
            $stmt->bindValue(":name", $this->name);
            $stmt->bindValue(":phoneNumber", $this->phoneNumber);
            $stmt->bindValue(":email", $this->email);

            $stmt->execute();
        } else {
            $cmd = "UPDATE tbContacts " .
                "SET name = :name, " .
                "phoneNumber = :phoneNumber, " .
                "email = :email " .
                "WHERE id = :id";
            
            $stmt = self::$conn->prepare($cmd);
            $stmt->bindValue(":name", $this->name);
            $stmt->bindValue(":phoneNumber", $this->phoneNumber);
            $stmt->bindValue(":email", $this->email);
            $stmt->bindValue(":id", $this->id);
            
            $stmt->execute();
        }
    }
    public function alterColumn($column, $value) {
        $cmd = "UPDATE tbContacts SET $column = :value WHERE id = :id";

        $this->$column = $value;
        
        $stmt = self::$conn->prepare($cmd);
        $stmt->bindValue(":value", $value);
        $stmt->bindValue(":id", $this->id);
        
        $stmt->execute();
    }
    public function delete() {
        $cmd = "DELETE FROM tbContacts WHERE id = :id";
        
        $stmt = self::$conn->prepare($cmd);
        $stmt->bindValue(":id", $this->id);
        
        $stmt->execute();
    }
    
    // Métodos auxiliares
    public static function getLastId() {
        $query = "SELECT id FROM tbContacts ORDER BY id DESC LIMIT 1";
        
        $stmt = self::$conn->query($query);
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result ? $result["id"] : 0;
    }
    public function getFormatedPhoneNumber() {
        $number = $this->phoneNumber;
        return "(" . substr($number, 0, 2) . ") " . substr($number, 2, 5) . "-" . substr($number, 7);
    }
    public function getData() {
        return $this->data;
    }
}