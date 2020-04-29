<?php


namespace App\Models;


class AssociationTools
{
    private $databaseTools;
    private $conducteurTools;
    private $vehiculeTools;

    public function __construct($databaseTools)
    {
        $this->databaseTools = $databaseTools;
        $this->conducteurTools = new ConducteurTools($databaseTools);
        $this->vehiculeTools = new VehiculeTools($databaseTools);
    }

    function hydrateAss($association, $datas){
        $association->setId($datas['id_association']);
        return $association;
    }
    function hydrateAssPlusConPlusVeh(){
        $association = new Association();
        $association = $this->hydrateAss($association, $result);
        $conducteur = new Conducteur();
        $conducteur = $this->conducteurTools->hydrateCon($conducteur, $result);
        $association->setConducteur($conducteur);
        $vehicule = new Vehicule();
        $vehicule = $this->vehiculeTools->hydrateVeh($vehicule, $result);
        $association->setVehicule($vehicule);
        return $association;
    }

    public function getAllAssociation(){
        $results = $this->databaseTools->executeQuery('SELECT  association_vehicule_conducteur.id_association, association_vehicule_conducteur.id_vehicule, vehicule.marque,vehicule.modele,
 
conducteur.id_conducteur, conducteur.prenom, conducteur.nom 

 FROM association_vehicule_conducteur inner join vehicule
 on vehicule.id_vehicule = association_vehicule_conducteur.id_vehicule
 inner join conducteur on conducteur.id_conducteur = association_vehicule_conducteur.id_conducteur');
        $associations = [];
        foreach ($results as $result) {
            $association = $this->hydrateAssPlusConPlusVeh();
            array_push($associations, $association);
        }
        return $associations;
    }

    public function getAssById($assId) {
        $results = $this->databaseTools->executeQuery("SELECT * FROM association_vehicule_conducteur inner  join 

conducteur  on association_vehicule_conducteur.id_conducteur = conducteur.id_conducteur inner  join 
vehicule on association_vehicule_conducteur.id_vehicule = vehicule.id_vehicule
 WHERE id_association = $assId");
        foreach ($results as $result){
            $association = $this->hydrateAssPlusConPlusVeh();
        }
        return $association;
    }

    public function addNewAss($vehicule, $conducteur) {
        if(empty($vehicule) || empty($conducteur)){
            header('Location: /association?msg=Vehicule and Conducteur are require');
            exit();
        }
        $params =[[":vehicule"=> $vehicule, ":conducteur" => $conducteur]];
        $this->databaseTools->sqlQuery("INSERT INTO association_vehicule_conducteur (id_vehicule, id_conducteur)
 VALUES (:vehicule, :conducteur)",$params);
        header('Location: /association?msg=Inserted successfully');

    }

    public function deleteAss($deletedid) {
        $params =[[":deleteid"=> $deletedid]];
        $this->databaseTools->sqlQuery("DELETE FROM association_vehicule_conducteur where id_association = :deleteid",$params);
        header('Location: /association?msg=Deleted successfully');
    }

    public function updateAss($updateid,$vehicule, $conducteur) {
        if(empty($vehicule) || empty($conducteur)){
            header('Location: /association?msg=Prenom and Nom are require');
            exit();
        }
        $params =[[":vehicule"=> $vehicule, ":conducteur" => $conducteur ,":editid" => $updateid]];
        $this->databaseTools->sqlQuery("UPDATE association_vehicule_conducteur SET  id_vehicule = :vehicule, id_conducteur = :conducteur
 where id_association = :editid",$params);
        header('Location: /association?msg=Updated successfully');

    }
}
