<?php

use App\Models\ConducteurTools;
use App\Models\VehiculeTools;
use App\Tools\DatabaseTools;

$dbTools = new DatabaseTools("mysql", "vtc", "root", "root");
$vehTools = new VehiculeTools($dbTools);

if(isset($_POST['buttonA'])){
    $marque = $_POST['marque'];
    $modele = $_POST['modele'];
    $couleur = $_POST['couleur'];
    $immatriculation = $_POST['immatriculation'];
    $vehTools->addNewVeh($marque, $modele,$couleur,$immatriculation);
}
if(isset($_POST['deleteB'])){
    $deleteId = $_POST['deleteid'];
    $vehTools->deleteVeh($deleteId);
}
$editid = $_GET['editId'];
 
if(isset($_POST['buttonEdit'])){
    $marque = $_POST['marque'];
    $modele = $_POST['modele'];
    $couleur = $_POST['couleur'];
    $immatriculation = $_POST['immatriculation'];
    $vehTools->updateCon($editid,$marque, $modele,$couleur,$immatriculation);

}
$vehicules = $vehTools->getAllVehicules();
$msg = htmlspecialchars($_GET['msg']);
?>
<div class="row col-md-12 justify-content-center mt-4">
    <?php if(!empty($msg)){ echo '<h1 class="col-md-12 text-center alert alert-info" role="alert">'.$msg.'</h1>'; } ?>
    <table class="table col-md-10">
        <thead class="thead-dark text-center">
        <tr >
            <th scope="col">Id</th>
            <th scope="col">Marque</th>
            <th scope="col">Modele</th>
            <th scope="col">Couleur</th>
            <th scope="col">Immatriculation</th>
            <th scope="col">Modification</th>
            <th scope="col">Suppression</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($vehicules as $vehicule){ ?>
            <tr class="text-center">
                <th scope="row"><?= $vehicule->getId_vehicule() ?></th>
                <td><?= $vehicule->getMarque() ?></td>
                <td><?= $vehicule->getModele() ?></td>
                <td><?= $vehicule->getCouleur() ?></td>
                <td><?= $vehicule->getImmatriculation() ?></td>
                <td><a  href="?editId=<?= $vehicule->getId_vehicule() ?>">
                        <i style="cursor:pointer;" class="fas fa-edit text-info"></i></a> </td>
                <td><form method="post"><input hidden name="deleteid" value="<?= $vehicule->getId_vehicule() ?>">
                        <button onclick="return confirm('Are you sure you wanna delete this?')" name="deleteB" style="border: none; background: none">
                            <i  style="cursor:pointer;" class="fas fa-trash-alt text-info"></i>
                        </button>
                    </form></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php if(empty($editid)){?>
        <form method="post" class="col-md-12">
            <label>Marque</label>
            <input class="form-control" type="text" name="marque" placeholder="marque" required>
            <label>Modele</label>
            <input class="form-control" type="text" name="modele" placeholder="modele" required>
            <label>Couleur</label>
            <input class="form-control" type="text" name="couleur" placeholder="couleur" required>
            <label>Immatriculation</label>
            <input class="form-control" type="text" name="immatriculation" placeholder="immatriculation" required>
            <input class="btn btn-success mt-2" type="submit" name="buttonA" value="Ajuter ce vehicule">
        </form>
    <?php } else {
        $edit = $vehTools->getConById($editid);
        ?>
        <h1 class="col-md-12 text-center">Edit: <?= $edit->getMarque() ?></h1>
        <form method="post" class="col-md-12">
            <label>Marque</label>
            <input class="form-control" type="text" name="marque" placeholder="marque" value="<?= $edit->getMarque()?>" required>
            <label>Modele</label>
            <input class="form-control" type="text" name="modele" placeholder="modele" value="<?= $edit->getModele()?>"  required>
            <label>Couleur</label>
            <input class="form-control" type="text" name="couleur" placeholder="couleur" value="<?= $edit->getCouleur()?>"  required>
            <label>Immatriculation</label>
            <input class="form-control" type="text" name="immatriculation" placeholder="immatriculation" value="<?= $edit->getImmatriculation()?>"  required>
            <input class="btn btn-info mt-2" type="submit" name="buttonEdit" value="Edit">
        </form>
    <?php } ?>
</div>

