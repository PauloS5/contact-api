<?php

class Generators {
    public static function generatePhoneNumber($formated=false) {
        $number = (string)rand(10, 99) . "9" . self::generateNumber("00000000");

        if($formated) {
            $number = "(" . substr($number, 0, 2) . ") " . substr($number, 2, 5) . "-" . substr($number, 7);
        }

        return $number;
    }

    public static function generateCpf($formated=false) {
        $pattern = $formated ? "000.000.000-00" : "00000000000";

        return self::generatePhoneNumber($pattern);
    }

    public static function generateSimpleName() {
        $names = ["Ana", "João", "Maria", "Pedro", "Lucas", "Helena", "Miguel", "Laura", "Rafael", "Beatriz", "Sofia", "Gabriel", "Isabella", "Gustavo", "Camila", "Matheus", "Vitória", "Eduardo", "Mariana", "Felipe", "Luiza", "Thiago", "Juliana", "Daniel", "Alice", "Leonardo", "Bruna", "André", "Larissa", "Rodrigo", "Fernanda", "Bruno", "Clara", "Vinícius", "Patrícia", "Alexandre", "Yasmin", "Carlos", "Bianca", "Marcelo", "Gabriela", "Samuel", "Cecília", "Diego", "Renata", "Guilherme", "Aline", "Murilo", "Tainá", "Roberto", "Ingrid", "Fabrício", "Elis", "Emerson", "Mirela", "Fábio", "Lorena", "Otávio", "Rafaela", "Hugo", "Simone", "Wellington", "Isadora", "Sérgio", "Milena", "Kleber", "Alana", "Tales", "Eduarda", "Severino", "Nádia", "Caio", "Lúcia", "Álvaro", "Olívia", "Érico", "Cíntia", "Valter", "Salomé", "Enzo", "Penélope", "Raul", "Talita", "Jerônimo", "Zuleica", "Plínio", "Maricota", "Adélia", "Ulisses", "Teodora", "Benício", "Eloá", "Levi", "Ofélia", "Crisóstomo", "Quirino", "Arminda", "Bartolomeu", "Efigênia", "Apolinário"];

        return $names[array_rand($names)];
    }

    public static function generateFullName() {
        $surname = ["Silva", "Santos", "Oliveira", "Souza", "Rodrigues", "Ferreira", "Alves", "Pereira", "Lima", "Gomes", "Costa", "Ribeiro", "Martins", "Carvalho", "Almeida", "Lopes", "Soares", "Fernandes", "Vieira", "Rocha", "Araújo", "Cardoso", "Teixeira", "Barros", "Moraes", "Cunha", "Castro", "Pinto", "Monteiro", "Nascimento", "Batista", "Andrade", "Farias", "Reis", "Tavares", "Freitas", "Campos", "Sales", "Menezes", "Moreira", "Brito", "Fonseca", "Maciel", "Pires", "Borges", "Xavier", "Guimarães", "Porto", "Neves", "Barreto", "Cordeiro", "Paiva", "Dutra", "Antunes", "Amaral", "Azevedo", "Figueiredo", "Brandão", "Valentim", "Milhomem", "Assis", "Damasceno", "Bonfim", "Siqueira", "Cavalcante", "Beltrão", "Toscano", "Bastos", "Sabino", "Simões", "Anjos", "Salgado", "Gouvêa", "Vilela", "Caldeira", "Parente", "Chaves", "Viana", "Cintra", "Malta", "Mascarenhas", "Sarmento", "Teles", "Penha", "Prudente", "Seabra", "Peçanha", "Vilhena", "Pedrosa", "Bulhões", "Magalhães", "Lacerda", "Botelho", "Roriz", "Quintanilha", "Furtado", "Corrêa", "Travassos", "Queiroz", "Drummond"];

        return self::generateSimpleName() . " " . $surname[array_rand($surname)];
    }

    public static function generateEmail() {
        $name = self::generateFullname();

        $name = trim($name);
        $name = iconv("UTF-8", "ASCII//TRANSLIT", $name);
        $name = strtolower($name);
        $name = str_replace(
            ['\'', '^', '~'], 
            '', $name
        );

        $p = rand(0, 1);
        $q = rand(0, 1);
        $r = rand(0, 1);
        $isInversed = $p && $q && $r;
        $explodedName = explode(' ', $name);
        if ($isInversed) {
            $name = $explodedName[1] . ' ' . $explodedName[0];
        } else {
            $name = $explodedName[0] . ' ' . $explodedName[1];
        }

        $p = rand(0, 1);
        $q = rand(0, 1);    
        $withUndeline = $p && $q;
        $name = str_replace(
            ' ',
            ($withUndeline ? '_' : ''), 
            $name
        );

        $number = '';
        $p = rand(0, 1);
        $q = rand(0, 1);
        $withNumber = $p || $q;
        if ($withNumber) {
            if (rand(0, 1)) {
                $number = $withNumber ? rand(1, 999): "";
            } else {
                $number = (int)date("Y") - rand(1, 99);
            }
        }

        $email = $name . $number . "@email.com";

        return $email;
    }

    public static function generateNumber($pattern) {
        $number = $pattern;

        for ($i = 0; $i < strlen($number); $i++) {
            if ($number[$i] === "0") {
                $number[$i] = (string)rand(0, 9);
            }
        }

        return $number;
    }
}