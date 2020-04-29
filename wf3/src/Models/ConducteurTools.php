<?php


namespace App\Models;
use PDO;

class ConducteurTools
{
    private $databaseTools;
    public function __construct($databaseTools)
    {
        $this->databaseTools = $databaseTools;
    }

    function hydrateCon($conducteur, $datas){
        $conducteur->setId($datas['id_conducteur']);
        $conducteur->setNom($datas['nom']);
        $conducteur->setPrenom($datas['prenom']);
        return $conducteur;
    }

    public function getAllConducteurs(){
        $results = $this->databaseTools->executeQuery('SELECT * FROM conducteur');
        $conducteurs = [];
        foreach ($results as $result) {
            $conducteur = new Conducteur();
            $conducteur = $this->hydrateCon($conducteur, $result);
            array_push($conducteurs, $conducteur);
        }
        return $conducteurs;
    }

    public function getConById($conId) {
        $results = $this->databaseTools->executeQuery("SELECT * FROM conducteur WHERE id_conducteur = $conId");
        foreach ($results as $result){
            $conducteur = new Conducteur();
            $conducteur = $this->hydrateCon($conducteur, $result);
        }
        return $conducteur;
    }

    public function addNewCon($prenom, $nom) {
        if(empty($prenom) || empty($nom)){
            header('Location: /conducteur?msg=Prenom and Nom are require');
            exit();
        }
            $params =[[":prenom"=> $prenom, ":nom" => $nom]];
            $this->databaseTools->sqlQuery("INSERT INTO conducteur (prenom, nom) VALUES (:prenom, :nom)",$params);
        header('Location: /conducteur?msg=Inserted successfully');

    }

    public function deleteCon($deletedid) {
        $params =[[":deleteid"=> $deletedid]];
        $this->databaseTools->sqlQuery("DELETE FROM conducteur where id_conducteur = :deleteid",$params);
        header('Location: /conducteur?msg=Deleted successfully');
    }

    public function updateCon($updateid,$prenom, $nom) {
        if(empty($prenom) || empty($nom)){
            header('Location: /conducteur?msg=Prenom and Nom are require');
            exit();
        }
        $params =[[":prenom"=> $prenom, ":nom" => $nom ,":editid" => $updateid]];
        $this->databaseTools->sqlQuery("UPDATE conducteur SET  prenom = :prenom, nom = :nom where id_conducteur = :editid",$params);
        header('Location: /conducteur?msg=Updated successfully');

    }
}
