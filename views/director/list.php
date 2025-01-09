<?php
    require_once('../../controllers/DirectorController.php');
    require_once('../../assets/scripts/alertSystem.php');
?>

<!DOCTYPE html>
<html>
<head>
    <script src="../../assets/scripts/shared.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<header>
    <a href="../../index.html">
        <img src="/images/house-solid.svg" alt="home" style="margin:20px; width: 40px; height: 40px;">
    </a>
</header>
<body>
    <div class="container">
        <div class="row">
            <h1>Listado de directores</h1>
        </div>
        <div class="text-start mb-4 mt-4">
            <a class="btn btn-primary" href="createEdit.php?action=create" role="button">
                <i class="fas fa-plus"></i> Crear director
            </a>
        </div>
        <div class="row">
            <div class="col">
                <?php 
                    $directorList = listDirectors();
                    if(count($directorList) > 0) {
                ?>
                <table class="table">
                    <thead>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Fecha nacimiento</th>
                        <th>Nacionalidad</th>
                        <th>Acciones</th>
                    </thead>
                    <tbody>
                        <?php 
                            foreach($directorList as $director){
                        ?>   
                        <tr>
                            <td>
                                <?php echo $director->getId(); ?>
                            </td>
                            <td>
                                <?php echo $director->getName(); ?>
                            </td>
                            <td>
                                <?php echo $director->getSurnames(); ?>
                            </td>
                            <td>
                                <?php echo date('d/m/Y', strtotime($director->getBirthdate())); ?>
                            </td>
                            <td>
                                <?php echo $director->getNationality(); ?>
                            </td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a class="btn btn-success mr-2" href="createEdit.php?action=edit&id=<?php echo $director->getId();?>">Editar</a>

                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmDeleteModal_<?php echo $director->getId(); ?>">
                                        Borrar
                                    </button>
                                    
                                 <?php 
                                      AlertSystem::showDeleteConfirmationModal($director->getId(), 'Eliminar director', '¿Estás seguro de eliminar el director? ');
                                 ?>                         
                            </td>
                        </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
                <?php
                    } else {   
                ?>
                <div class="alert alert-warning" role="alert">Aún no existen directores.</div>
                <?php 
                    }       
                ?>
            </div>
        </div>
    </div>

    <script>
        function deleteItem(directorId) {
            window.location.href = 'delete.php?directorId=' + directorId;
        }
    </script>
</body>
</html>
