<?php

class AdminController2{
	private $model;
  
    public function __construct()
    {
		$this->model=new AdminModel();
      
    }
    
     //För sorteringsknappen som hämtar från modellens funktion getSortBy som anropar databasen

     public function getSortBy() {

        $jsonSorted = json_encode($this->model->getSortBy());
        return $jsonSorted;
    }
    
    //Hämtar alla och gör om arrayen till JSON
    
    public function getFurniture() {
         
        $jsonDatan = json_encode($this->model->getFurniture());
        return $jsonDatan;
       
    }
    
   
    
    //Lägger till en ny och skickar tillbaka ett svar om det gick bra

        public function addComm(){
         
          $comm = new stdClass();
           $comm->mobelNamn = filter_var($_REQUEST['mobelNamn'], FILTER_SANITIZE_STRING);
           $comm->mobelID = filter_var($_REQUEST['mobelID'], FILTER_SANITIZE_NUMBER_INT);
           $comm->namn = filter_var($_REQUEST['namn'], FILTER_SANITIZE_STRING);
           $comm->kommentar = filter_var($_REQUEST['kommentar'], FILTER_SANITIZE_STRING);
          $this->model->addComm($comm);
          return json_encode(array("Svar" => "Din kommentar har tagits emot!"));

}    
    
    //Lägger till ett nytt och skickar tillbaka ett svar om det gick bra
    
        public function addFurniture(){
         
          $furniture = new stdClass();
           $furniture->namn = filter_var($_REQUEST['namn'], FILTER_SANITIZE_STRING);
           $furniture->info = filter_var($_REQUEST['info'], FILTER_SANITIZE_STRING);
           $furniture->bild = filter_var($_REQUEST['bild'], FILTER_SANITIZE_URL);
          $this->model->addFurniture($furniture);
          return json_encode(array("Svar" => "Lagts till i DB!"));

}
//Tar bort-funktion

  public function deleteFurniture() {
          $furniture = new stdClass();
       $furniture->mobelID = filter_var($_REQUEST['mobelID'], FILTER_SANITIZE_NUMBER_INT);
     
        $this->model->deleteFurniture($furniture->mobelID);

       return json_encode(array("Svar" => "Möbel togs bort!"));
    }
    
     //Hämtar data till formuläret, returnar JSON

    
        public function updateFurniture() {
        $furniture = new stdClass();
        $furniture->mobelID = filter_var($_REQUEST['mobelID'], FILTER_SANITIZE_NUMBER_INT);
        $furniture->namn = filter_var($_REQUEST['namn'], FILTER_SANITIZE_STRING);
        $furniture->info = filter_var($_REQUEST['info'], FILTER_SANITIZE_STRING);
        $this->model->updateFurniture($furniture);
        return json_encode(array("Svar" => 'Möbel blev uppdaterad!'));
    }
 
    //Hämtar alla, returnerar JSON
    
    public function getAllComments() {
        return json_encode($this->model->getAllComments());
    
    }
    
     
    public function getAllCommentsByID($idx) {
        return json_encode($this->model->getAllCommByID($idx));
    
    }
    
    //Hämtar data till formuläret, returnar JSON
   
        public function getCommByID($idx) {
        return json_encode($this->model->getCommByID($idx));
    
    }

    }

?>
