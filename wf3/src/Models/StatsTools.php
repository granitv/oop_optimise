<?php


namespace App\Models;


class StatsTools
{
    private $databaseTools;
    private $conducteurTools;
    private $vehiculeTools;
    private $association;


    public function __construct($databaseTools)
    {
        $this->databaseTools = $databaseTools;
        $this->conducteurTools = new ConducteurTools($databaseTools);
        $this->vehiculeTools = new VehiculeTools($databaseTools);
        $this->association = new AssociationTools($databaseTools);
    }

    function hydrateVeh($car, $result){
        $car->setId_vehicule($result['id_vehicule']);
        $car->setMarque($result['marque']);
        $car->setModele($result['modele']);
        $car->setCouleur($result['couleur']);
        $car->setImmatriculation($result['immatriculation']);
        return $car;
    }

    function hydrateStats($stats, $result){
        $stats->setCar($result['modele']);
        $stats->setName($result['prenom']);
        return $stats;
    }

    public function usedVeh(){
        $results = $this->databaseTools->executeQuery("select v.id_vehicule, v.marque, v.modele, v.couleur, v.immatriculation from 
    vehicule v inner join association_vehicule_conducteur a
    on a.id_vehicule = v.id_vehicule group by v.id_vehicule");
    $stats1=[];
    foreach ($results as $result){
    $car = new Vehicule();
        $car = $this->hydrateVeh($car, $result);
    $stats1[] =  $car;
}
        return $stats1;
    }



    public function conInWork(){
        $results = $this->databaseTools->executeQuery("select * from conducteur c inner join association_vehicule_conducteur a
on c.id_conducteur = a.id_conducteur");
        $stats1=[];
        foreach ($results as $datas){
            $conducteur = new Conducteur();
            $conducteur->setId($datas['id_conducteur']);
            $conducteur->setNom($datas['nom']);
            $conducteur->setPrenom($datas['prenom']);

            $stats1[] =  $conducteur;
        }
        return $stats1;
    }

    public function carParConName($name){
    $results = $this->databaseTools->executeQuery("select * from conducteur c 
inner join association_vehicule_conducteur a
on c.id_conducteur = a.id_conducteur
 and c.prenom LIKE '%$name%' inner join vehicule v on a.id_vehicule = v.id_vehicule");

        $stats1=[];
        foreach ($results as $result){
            $car = new Vehicule();
            $car = $this->hydrateVeh($car, $result);

            $stats1[] =  $car;
        }
        return $stats1;
    }
    public function selectAllNameMcars(){
        $results = $this->databaseTools->executeQuery("select c.prenom, v.modele from conducteur c

LEFT JOIN association_vehicule_conducteur a on c.id_conducteur = a.id_conducteur
LEFT JOIN vehicule v on v.id_vehicule = a.id_vehicule");
        $stats1=[];
        foreach ($results as $result){
            $stats = new Stats();
            $stats = $this->hydrateStats($stats, $result);
            $stats1[] =  $stats;
        }
        return $stats1;
    }


    public function selectAllCarsMname(){
        $results = $this->databaseTools->executeQuery("select v.modele, c.prenom from vehicule v  

LEFT JOIN association_vehicule_conducteur a on v.id_vehicule = a.id_vehicule
LEFT JOIN conducteur c on v.id_vehicule = a.id_vehicule and c.id_conducteur = a.id_conducteur");
        $stats1=[];
        foreach ($results as $result){
            $stats = new Stats();
            $stats = $this->hydrateStats($stats, $result);
            $stats1[] =  $stats;
        }
        return $stats1;
    }
    public function allCarPlusAllNames(){
        $results = $this->databaseTools->executeQuery("select v.modele, c.prenom from vehicule v  

LEFT JOIN association_vehicule_conducteur a on v.id_vehicule = a.id_vehicule
LEFT JOIN conducteur c on v.id_vehicule = a.id_vehicule and c.id_conducteur = a.id_conducteur
union 
select v.modele, c.prenom  from conducteur c

LEFT JOIN association_vehicule_conducteur a on c.id_conducteur = a.id_conducteur
LEFT JOIN vehicule v on v.id_vehicule = a.id_vehicule");
        $stats1=[];
        foreach ($results as $result){
            $stats = new Stats();
            $stats = $this->hydrateStats($stats, $result);
            $stats1[] =  $stats;
        }
        return $stats1;
    }
}
