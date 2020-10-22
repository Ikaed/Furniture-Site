<?php

class AdminModel {

    private function getPDOConnection() {
$db_host = '127.0.0.1';
       $db_name = 'db-h17miklu';
        $db_user = 'root';
        $db_pass = '';

   //          $db_host = 'edu-mysql.du.se';
    //    $db_name = 'db-h17miklu';
   //     $db_user = 'h17miklu';
   //     $db_pass = 'ueSY5FcqtHKNQ839';


        $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
        try {
            $pdoConnection = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass, $options);
        } catch (PDOException $exp) {
            echo 'Något gick fel. Försök igen.', $exp->getMessage();
            $pdoConnection = NULL;
            die();
        }
        return $pdoConnection;
    }

    //Hämtar alla events med en stored procedure och retunerar som en array

    public function getFurniture() {
        try {
            $pdoCon = $this->getPDOConnection();
            $pdoStatement = $pdoCon->prepare('CALL h17miklu_getAllFurnitures()');
            $pdoStatement->execute();
            $events = $pdoStatement->fetchAll(PDO::FETCH_OBJ);
            $pdoCon = NULL;
            return $events;
        } catch (PDOException $pdoexp) {
            $pdoCon = NULL;
            throw new Exception('Databasfel. Det gick inte att hämta möbler!');
        }
    }

    //Lägger till ett ny möbel med en stored procedure

    public function addFurniture($furniture) {
        try {
            $pdoCon = $this->getPDOConnection();
            $pdoStatement = $pdoCon->prepare("CALL h17miklu_addFurniture('{$furniture->namn}',' {$furniture->info}',' {$furniture->bild}')");
            $pdoStatement->execute();
            $pdoCon = NULL;
        } catch (PDOException $pdoexp) {
            $pdoCon = NULL;
            throw new Exception('Databasfel. Det gick inte att lägga till möbel!');
        }
    }

    //Lägger till en ny kommentar med en stored procedure

    public function addComm($comm) {
        try {
            $pdoCon = $this->getPDOConnection();
            $pdoStatement = $pdoCon->prepare("CALL h17miklu_AddComm('{$comm->mobelNamn}','{$comm->mobelID}','{$comm->namn}',' {$comm->kommentar}')");
            $pdoStatement->execute();
            $pdoCon = NULL;
        } catch (PDOException $pdoexp) {
            $pdoCon = NULL;
            throw new Exception('Databasfel. Det gick inte att kommentera!');
        }
    }

    public function deleteFurniture($idx) {
        try {
            $pdoCon = $this->getPDOConnection();
            $pdoStatement = $pdoCon->prepare("CALL h17miklu_deleteFurniture('{$idx}')");
            $pdoStatement->execute();
            $pdoCon = NULL;
        } catch (PDOException $pdoexp) {
            $pdoCon = NULL;
            throw new Exception('Databasfel. Det gick inte att radera möbel!');
        }
    }
    
     public function updateFurniture($furniture) {
        try { 
          $pdoCon = $this->getPDOConnection();
          print_r($furniture);
          $pdoStatement = $pdoCon->prepare("CALL h17miklu_updateFurniture('{$furniture->mobelID}',' {$furniture->namn}',' {$furniture->info}')");
          $pdoStatement->execute();
          $pdoCon=NULL;
     } catch (PDOException $pdoexp) {
          $pdoCon = NULL;
          throw new Exception ('Databasfel. Det gick inte att uppdatera möbel!');
        } 
        
    }

    //Hämtar alla kommentarer och returnar dom som en array

    public function getAllComments() {
        try {
            $pdoCon = $this->getPDOConnection();
            $pdoStatement = $pdoCon->prepare("CALL h17miklu_getAllComments()");
            $pdoStatement->execute();
            $signed = $pdoStatement->fetchAll(PDO::FETCH_OBJ);
            $pdoCon = NULL;
            return $signed;
        } catch (PDOException $pdoexp) {
            $pdoCon = NULL;
            throw new Exception('Databasfel. Det gick inte att hämta kommentarer!');
        }
    }

    //Hämtar data om en möbel till kommentarsformuläret och returnerar en array.

    public function getCommByID($idx) {
        try {
            $pdoCon = $this->getPDOConnection();
            $pdoStatement = $pdoCon->prepare("CALL h17miklu_getCommByID('{$idx}')");
            $pdoStatement->execute();
            $furniture = $pdoStatement->fetchAll(PDO::FETCH_OBJ);
            $pdoCon = NULL;
            return $furniture;
        } catch (PDOException $pdoexp) {
            $pdoCon = NULL;
            throw new Exception('Databasfel. Det gick inte att hämta kommentar!');
        }
    }
    
       public function getAllCommByID($idx) {
        try {
            $pdoCon = $this->getPDOConnection();
            $pdoStatement = $pdoCon->prepare("CALL h17miklu_getAllCommentsByID('{$idx}')");
            $pdoStatement->execute();
            $furniture = $pdoStatement->fetchAll(PDO::FETCH_OBJ);
            $pdoCon = NULL;
            return $furniture;
        } catch (PDOException $pdoexp) {
            $pdoCon = NULL;
            throw new Exception('Databasfel. Det gick inte att hämta kommentarer!');
        }
    }
    
      public function getSortBy() {
        try {
            $pdoCon = $this->getPDOConnection();
            $pdoStatement = $pdoCon->prepare('CALL h17miklu_sortByMobelNamn()');
            $pdoStatement->execute();
            $events = $pdoStatement->fetchAll(PDO::FETCH_OBJ);
            $pdoCon = NULL;
            return $events;
        } catch (PDOException $pdoexp) {
            $pdoCon = NULL;
            throw new Exception('Databasfel. Det gick inte att sortera möbler!');
        }
    }

}

?>
