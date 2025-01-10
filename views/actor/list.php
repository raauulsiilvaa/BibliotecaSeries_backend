<?php
    require_once('../../controllers/ActorController.php');
    require_once('../../assets/scripts/alertSystem.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Gestión de Actores</title>
        <meta charset="UTF-8">
        <script src="../../assets/scripts/shared.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    </head>
<body>
    <header>
        <a href="../../index.html">
            <img src="/images/house-solid.svg" alt="home" style="margin:20px; width: 40px; height: 40px;">
        </a>
    </header>
    <div class="container">
        <h1>Gestión de Actores</h1>
        <div class="text-start mb-4 mt-4">
            <a href="createEdit.php?action=create" class="btn btn-primary px-4 py-2">+ Crear Actor</a>
        </div>

        <?php 
            $actorList = listActors();
            if (count($actorList) > 0) {
        ?>
        <table class="table w-100">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Fecha de Nacimiento</th>
                    <th>Nacionalidad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($actorList as $actor) { ?>
                <tr>
                    <td><?php echo $actor->getId(); ?></td>
                    <td><?php echo $actor->getName(); ?></td>
                    <td><?php echo $actor->getSurnames(); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($actor->getBirthdate())); ?></td>
                    <td><?php echo $actor->getNationality(); ?></td>
                    <td>
                        <a href="createEdit.php?action=edit&id=<?php echo $actor->getId(); ?>" class="btn btn-success btn-sm">Editar</a>
                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirmDeleteModal_<?php echo $actor->getId(); ?>">
                            Borrar
                        </button>
                        <?php 
                            AlertSystem::showDeleteConfirmationModal(
                                $actor->getId(), 
                                'Eliminar Actor', 
                                '¿Estás seguro de eliminar al actor?'
                            );
                        ?>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php } else { ?>
        <div class="alert alert-warning">No hay actores registrados.</div>
        <?php } ?>
    </div>

    <script>
        function deleteItem(actorId) {
            window.location.href = 'delete.php?actorId=' + actorId;
        }
    </script>
</body>
</html>
