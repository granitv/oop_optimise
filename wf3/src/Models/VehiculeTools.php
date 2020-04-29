<?php


namespace App\Models;
use PDO;

class VehiculeTools
{

    private $databaseTools;

    public function __construct($databaseTools)
    {
        $this->databaseTools = $databaseTools;
    }

    function hydrateVeh($vehicule, $datas){
        $vehicule->setId_vehicule($datas['id_vehicule']);
        $vehicule->setMarque($datas['marque']);
        $vehicule->setModele($datas['modele']);
        $vehicule->setCouleur($datas['couleur']);
        $vehicule->setImmatriculation($datas['immatriculation']);
        return $vehicule;
    }

    public function getAllVehicules(){
        $results = $this->databaseTools->executeQuery('SELECT * FROM vehicule');
        $vehicules = [];
        foreach ($results as $result) {
            $vehicule = new Vehicule();
            $vehicule = $this->hydrateVeh($vehicule, $result);
            array_push($vehicules, $vehicule);
        }
        return $vehicules;
    }

    public function getConById($vehId) {
        $results = $this->databaseTools->executeQuery("SELECT * FROM vehicule WHERE id_vehicule = $vehId");
        foreach ($results as $result){
            $vehicule = new Vehicule();
            $vehicule = $this->hydrateVeh($vehicule, $result);
        }
        return $vehicule;
    }

    public function addNewVeh($marque, $modele,$couleur,$immatriculation) {
        if(empty($marque) || empty($modele) || empty($couleur) || empty($immatriculation)){
            header('Location: /vehicule?msg=Marque, Model, Couleur and Immatriculation are require');
            exit();
        }
        $params =[[":marque"=> $marque, ":modele" => $modele, ":couleur" => $couleur, ":immatriculation" => $immatriculation]];
        $this->databaseTools->sqlQuery("INSERT INTO vehicule (marque, modele, couleur,immatriculation )
 VALUES (:marque, :modele, :couleur,:immatriculation )",$params);
        header('Location: /vehicule?msg=Inserted successfully');

    }

    public function deleteVeh($deletedid) {
        $params =[[":deleteid"=> $deletedid]];
        $this->databaseTools->sqlQuery("DELETE FROM vehicule where id_vehicule = :deleteid",$params);
        header('Location: /vehicule?msg=Deleted successfully');
    }

    public function updateCon($updateid,$marque, $modele,$couleur,$immatriculation) {
        if(empty($marque) || empty($modele) || empty($couleur) || empty($immatriculation)){
            header('Location: /vehicule?msg=Marque, Model, Couleur and Immatriculation are require');
            exit();
        }
        $params =[[":marque"=> $marque, ":modele" => $modele, ":couleur" => $couleur, ":immatriculation" => $immatriculation,":editid" => $updateid]];
        $this->databaseTools->sqlQuery("UPDATE vehicule SET  
 marque = :marque, modele = :modele,couleur = :couleur,immatriculation = :immatriculation 
 where id_vehicule = :editid",$params);
        header('Location: /vehicule?msg=Updated successfully');

    }
}
