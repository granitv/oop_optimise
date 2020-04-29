<?php


use App\Models\AssociationTools;
use App\Models\ConducteurTools;
use App\Models\VehiculeTools;
use App\Tools\DatabaseTools;

$dbTools = new DatabaseTools("mysql", "vtc", "root", "root");
$assTools = new AssociationTools($dbTools);
$vehTools = new VehiculeTools($dbTools);
$conTools = new ConducteurTools($dbTools);

if(isset($_POST['buttonA'])){
    $vehicule = $_POST['vehicule'];
    $conducteur = $_POST['conducteur'];
    $assTools->addNewAss($vehicule, $conducteur);
}
if(isset($_POST['deleteB'])){
    $deleteId = $_POST['deleteid'];
    $assTools->deleteAss($deleteId);
}

$editid = $_GET['editId'];

if(isset($_POST['buttonEdit'])){
    $vehicule = $_POST['vehicule'];
    $conducteur = $_POST['conducteur'];
    $assTools->updateAss($editid,$vehicule, $conducteur);

}
$conducteurs = $conTools->getAllConducteurs();
$vehicules = $vehTools->getAllVehicules();
$associations = $assTools->getAllAssociation();
$msg = htmlspecialchars($_GET['msg']);
?>
<div class="row col-md-12 justify-content-center mt-4">
    <?php if(!empty($msg)){ echo '<h1 class="col-md-12 text-center alert alert-info" role="alert">'.$msg.'</h1>'; } ?>
    <table class="table col-md-10">
        <thead class="thead-dark text-center">
        <tr >
            <th scope="col">Id</th>
            <th scope="col">Conducteur</th>
            <th scope="col">Vehicule</th>
            <th scope="col">Modification</th>
            <th scope="col">Suppression</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($associations as $association){ ?>
            <tr class="text-center">
                <th scope="row"><?= $association->getId() ?></th>
                <td><?= $association->getConducteur()->getPrenom().' '.$association->getConducteur()->getNom().'<br> '.$association->getConducteur()->getId() ?></td>
                <td><?= $association->getVehicule()->getMarque().' '.$association->getVehicule()->getModele().'<br>'.$association->getVehicule()->getId_vehicule() ?></td>
                <td><a  href="?editId=<?= $association->getId() ?>">
                        <i style="cursor:pointer;" class="fas fa-edit text-info"></i></a> </td>
                <td><form method="post"><input hidden name="deleteid" value="<?= $association->getId() ?>">
                        <button onclick="return confirm('Are you sure you wanna delete this?')" name="deleteB" style="border: none; background: none">
                            <i  style="cursor:pointer;" class="fas fa-trash-alt text-info"></i>
                        </button>
                    </form></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <div class="row col-md-12 justify-content-start">
    <?php if(empty($editid)){?>

            <form method="post" >
                <label>Conducteur</label>
                <select class="form-control" name="conducteur">
                    <?php foreach ($conducteurs as $conducteur){  ?>
                    <option value="<?= $conducteur->getId() ?>"><?= $conducteur->getPrenom() ?></option>
                    <?php } ?>

                </select>
                <label>Vehicule</label>
                <select class="form-control" name="vehicule">
                    <?php foreach ($vehicules as $vehicule){  ?>
                        <option value="<?= $vehicule->getId_vehicule() ?>"><?= $vehicule->getMarque() ?></option>
                    <?php } ?>

                </select>
                <input class="btn btn-success mt-2" type="submit" name="buttonA" value="Ajuter ce association">
            </form>

    <?php } else {
        $edit = $assTools->getAssById($editid);
        ?>
        <h1 class="col-md-12 text-center">Edit: <?= $edit->getConducteur()->getPrenom() ?></h1>
        <form method="post" >
            <label>Conducteur</label>
            <select class="form-control" name="conducteur">
                <?php foreach ($conducteurs as $conducteur){  ?>
                    <option value="<?php echo $conducteur->getId().'"'; if($conducteur->getId() == $edit->getConducteur()->getId()){ echo'selected'; } ?>><?= $conducteur->getPrenom() ?></option>
                <?php } ?>

            </select>
            <label>Vehicule</label>
            <select class="form-control" name="vehicule">
                <?php foreach ($vehicules as $vehicule){  ?>
                    <option value="<?php echo $vehicule->getId_vehicule().'"'; if($vehicule->getId_vehicule() == $edit->getVehicule()->getId_vehicule()){ echo'selected'; }?>><?= $vehicule->getMarque() ?></option>
                <?php } ?>

            </select>
            <input class="btn btn-info mt-2" type="submit" name="buttonEdit" value="Edit">
        </form>
    <?php } ?>
    </div>
</div>

