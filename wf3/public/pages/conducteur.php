<?php

use App\Models\ConducteurTools;
use App\Tools\DatabaseTools;

$dbTools = new DatabaseTools("mysql", "vtc", "root", "root");
$conTools = new ConducteurTools($dbTools);

if(isset($_POST['buttonA'])){
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $conTools->addNewCon($prenom, $nom);
}

if(isset($_POST['deleteB'])){
    $deleteId = $_POST['deleteid'];
    $conTools->deleteCon($deleteId);
}
$editid = $_GET['editId'];

if(isset($_POST['buttonEdit'])){
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
   $conTools->updateCon($editid,$prenom,$nom);

}
$conducteurs = $conTools->getAllConducteurs();
$msg = htmlspecialchars($_GET['msg']);
?>
   <div class="row col-md-12 justify-content-center mt-4">
       <?php if(!empty($msg)){ echo '<h1 class="col-md-12 text-center alert alert-info" role="alert">'.$msg.'</h1>'; } ?>
       <table class="table col-md-10">
           <thead class="thead-dark text-center">
           <tr >
               <th scope="col">Id</th>
               <th scope="col">Prenom</th>
               <th scope="col">Nom</th>
               <th scope="col">Modification</th>
               <th scope="col">Suppression</th>
           </tr>
           </thead>
           <tbody>
           <?php foreach ($conducteurs as $conducteur){ ?>
               <tr class="text-center">
                   <th scope="row"><?= $conducteur->getId() ?></th>
                   <td><?= $conducteur->getPrenom() ?></td>
                   <td><?= $conducteur->getNom() ?></td>
                   <td><a  href="?editId=<?= $conducteur->getId() ?>">
                           <i style="cursor:pointer;" class="fas fa-edit text-info"></i></a> </td>
                   <td><form method="post"><input hidden name="deleteid" value="<?= $conducteur->getId() ?>">
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
               <label>Prenom</label>
               <input class="form-control" type="text" name="prenom" placeholder="prenom" required>
               <label>Nom</label>
               <input class="form-control" type="text" name="nom" placeholder="nom" required>
               <input class="btn btn-success mt-2" type="submit" name="buttonA" value="Ajuter ce conducteur">
           </form>
       <?php } else {
           $edit = $conTools->getConById($editid);
           ?>
           <h1 class="col-md-12 text-center">Edit: <?= $edit->getPrenom() ?></h1>
           <form method="post" class="col-md-12">
               <label>Prenom</label>
               <input class="form-control" type="text" name="prenom" placeholder="prenom" value="<?= $edit->getPrenom()?>">
               <label>Nom</label>
               <input class="form-control" type="text" name="nom" placeholder="nom" value="<?= $edit->getNom() ?>">
               <input class="btn btn-info mt-2" type="submit" name="buttonEdit" value="Edit">
           </form>
       <?php } ?>
   </div>

