<?php

use App\Models\AssociationTools;
use App\Models\ConducteurTools;
use App\Models\StatsTools;
use App\Models\VehiculeTools;
use App\Tools\DatabaseTools;

$dbTools = new DatabaseTools("mysql", "vtc", "root", "root");
$statsTools = new StatsTools($dbTools);
$assTools = new AssociationTools($dbTools);
$conTools = new ConducteurTools($dbTools);
$vehTools = new VehiculeTools($dbTools);

$conInWork = $statsTools->conInWork();
$allVeh = $vehTools->getAllVehicules();
$allCon = $conTools->getAllConducteurs();
$vehInUse = $statsTools->usedVeh(); //te gjitha qe perdoren
$carPhilip = $statsTools->carParConName('Philippe');
$allNameMcars = $statsTools->selectAllNameMcars();
$allCarsMname = $statsTools->selectAllCarsMname();
$allCarPlusAllNames= $statsTools->allCarPlusAllNames();
?>


<div class="row">
    <div class="col-md-6 my-4">
        <table class="table ">
            <h1 class="text-center text-info">le nombre total de:</h1>
            <thead class="bg-info text-center">
            <tr">
                <th scope="col">conducteur</th>
                <th scope="col"> association</th>
            <th scope="col">vehicule</th>
            </tr>
            </thead>
            <tbody>

            <tr class="text-center  text-info">
                <th scope="row"><?= sizeof($allCon) ?></th>
                <td><?= sizeof($assTools->getAllAssociation()) ?></td>
                <td><?= sizeof($allVeh) ?></td>

            </tr>

            </tbody>
        </table>
    </div>
    <div class="col-md-6 my-4">
        <table class="table ">
            <h1 class="text-center text-info">vehicules n’ayant pas de conducteur:</h1>
            <thead class="bg-info text-center">
            <tr >
                <th scope="col">Id</th>
                <th scope="col">Marque</th>
                <th scope="col">Modele</th>
                <th scope="col">Couleur</th>
                <th scope="col">Immatriculation</th>
            </tr>
            </thead>
            <tbody>
<?php foreach ($allVeh as $vehicule){ if(!in_array($vehicule, $vehInUse)){ ?>
    <tr class="text-center">
        <th scope="row"><?= $vehicule->getId_vehicule() ?></th>
        <td><?= $vehicule->getMarque() ?></td>
        <td><?= $vehicule->getModele() ?></td>
        <td><?= $vehicule->getCouleur() ?></td>
        <td><?= $vehicule->getImmatriculation() ?></td>
            </tr>
<?php }} ?>
            </tbody>
        </table>
    </div>
    <!--table pour conductor-->
    <div class="col-md-6 my-4">
        <table class="table ">
            <h1 class="text-center text-info">conducteurs n’ayant pas de vehicule</h1>
            <thead class="bg-info text-center">
            <tr >
                <th scope="col">Id</th>
                <th scope="col">Prenom</th>
                <th scope="col">Nom</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($allCon as $conducteur){ if(!in_array($conducteur, $conInWork)){ ?>
                <tr class="text-center">
                    <th scope="row"><?= $conducteur->getId() ?></th>
                    <td><?= $conducteur->getPrenom() ?></td>
                    <td><?= $conducteur->getNom() ?></td>
                </tr>
            <?php }} ?>
            </tbody>
        </table>
    </div>
    <!--table pour philip-->
    <div class="col-md-6 my-4">
        <table class="table ">
            <h1 class="text-center text-info">vehicules conduit par « Philippe Pandre »</h1>
            <thead class="bg-info text-center">
            <tr >
                <th scope="col">Id</th>
                <th scope="col">Marque</th>
                <th scope="col">Modele</th>
                <th scope="col">Couleur</th>
                <th scope="col">Immatriculation</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($carPhilip as $carP){  ?>
                <tr class="text-center">
                    <th scope="row"><?= $carP->getId_vehicule() ?></th>
                    <td><?= $carP->getMarque() ?></td>
                    <td><?= $carP->getModele() ?></td>
                    <td><?= $carP->getCouleur() ?></td>
                    <td><?= $carP->getImmatriculation() ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <!--table-->
    <!--table pour driver et cars-->
    <div class="col-md-6 my-4">
        <table class="table ">
            <h1 class="text-center text-info">conducteurs (meme ceux qui n'ont pas de correspondance) ainsi que les vehicules</h1>
            <thead class="bg-info text-center">
            <tr >
                <th scope="col">Modele</th>
                <th scope="col">Prenom</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($allNameMcars as $carP){  ?>
                <tr class="text-center">
                    <th scope="row"><?= $carP->getCar() ?></th>
                    <td><?= $carP->getName() ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <!--table-->
    <!--table pour cars pa driver-->
    <div class="col-md-6 my-4">
        <table class="table ">
            <h1 class="text-center text-info">conducteurs et tous les vehicules (meme ceux qui n'ont pas de correspondance)</h1>
            <thead class="bg-info text-center">
            <tr >
                <th scope="col">Modele</th>
                <th scope="col">Prenom</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($allCarsMname as $carP){  ?>
                <tr class="text-center">
                    <th scope="row"><?= $carP->getCar() ?></th>
                    <td><?= $carP->getName() ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <!--table-->
    <!--table pour cars et pour driver all-->
    <div class="col-md-12 my-4">
        <table class="table ">
            <h1 class="text-center text-info">conducteurs et tous les vehicules, peut importe les correspondances.</h1>
            <thead class="bg-info text-center">
            <tr >
                <th scope="col">Modele</th>
                <th scope="col">Prenom</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($allCarPlusAllNames as $carP){  ?>
                <tr class="text-center">
                    <th scope="row"><?= $carP->getCar() ?></th>
                    <td><?= $carP->getName() ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <!--table-->
</div>
