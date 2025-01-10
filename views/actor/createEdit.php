<?php 
    require_once('../../controllers/ActorController.php'); 
    require_once('../../assets/scripts/alertSystem.php');
    require_once('../../assets/scripts/validations.php'); 
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
    <script src="../../assets/scripts/shared.js"></script> 
    <title>Gestión de Actores</title>
</head>
<header>
    <a href="../../index.html">
        <img src="/images/house-solid.svg" alt="home" style="margin:20px; width: 40px; height: 40px;">
    </a>
</header>
<body>
    <div class="container">
        <?php
            $sendData = false;
            $action = isset($_GET['action']) ? $_GET['action'] : 'create';
            $fieldsToValidate = ['itemName', 'itemSurnames', 'itemBirthdate', 'itemNationality'];

            if ($action === 'edit') {
                $idActor = $_GET['id'];
                $actorObject = getActorData($idActor);
                $actorEdited = false;

                if (isset($_POST['buttonCreateEdit'])) { 
                    $sendData = true; 
                }

                if ($sendData) {
                    $validationResult = validateFields($_POST, $fieldsToValidate);

                    if (!empty($validationResult['errors']) || !empty($validationResult['errorsEmptyFields'])) {
                        AlertSystem::showError(
                            "El actor no se ha editado correctamente. " . $validationResult['errorMessage'], 
                            $validationResult['incorrectFields'], 
                            "createEdit.php?action=edit&id=$idActor", 
                            'Intentar nuevamente'
                        );
                    } else {
                        $actorEdited = updateActor(
                            $_POST['itemId'], 
                            $_POST['itemName'], 
                            $_POST['itemSurnames'], 
                            $_POST['itemBirthdate'], 
                            $_POST['itemNationality']
                        );
                        if (!$actorEdited) {
                            AlertSystem::showError("El actor ya existe.". 
                            $errorMessage, $incorrectFields, 'list.php', 'Volver atrás');
                        }
                    }
                }
            } else if ($action === 'create') {
                $actorCreated = false;

                if (isset($_POST['buttonCreateEdit'])) { 
                    $sendData = true; 
                }

                if ($sendData) {
                    $validationResult = validateFields($_POST, $fieldsToValidate);

                    if (!empty($validationResult['errors']) || !empty($validationResult['errorsEmptyFields'])) {
                        AlertSystem::showError(
                            "El actor no se ha creado correctamente. " . $validationResult['errorMessage'], 
                            $validationResult['incorrectFields'], 
                            'createEdit.php', 
                            'Intentar nuevamente'
                        );
                    } else {
                        $actorCreated = storeActor(
                            $_POST['itemName'], 
                            $_POST['itemSurnames'], 
                            $_POST['itemBirthdate'], 
                            $_POST['itemNationality']
                        );
                        if (!$actorCreated) {
                            AlertSystem::showError("El actor ya existe.". 
                            $errorMessage, $incorrectFields, 'list.php', 'Volver atrás');
                        }
                    }
                }
            }

            if (!$sendData) {
        ?>
        <h1><?php echo $action === 'create' ? 'Crear Actor' : 'Editar Actor'; ?></h1>
        <form method="POST" action="">
            <div class="form-group">
                <label for="itemName">Nombre:</label>
                <input type="text" id="itemName" name="itemName" class="form-control" 
                        value="<?php echo isset($actorObject) ? $actorObject->getName() : ''; ?>" required>
                <?php if ($action === 'edit') { ?>
                    <input type="hidden" name="itemId" value="<?php echo $idActor; ?>">
                <?php } ?>
            </div>
            <div class="form-group">
                <label for="itemSurnames">Apellidos:</label>
                <input type="text" id="itemSurnames" name="itemSurnames" class="form-control" 
                        value="<?php echo isset($actorObject) ? $actorObject->getSurnames() : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="itemBirthdate">Fecha de Nacimiento:</label>
                <input type="date" id="itemBirthdate" name="itemBirthdate" class="form-control" 
                        value="<?php echo isset($actorObject) ? $actorObject->getBirthdate() : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="itemNationality">Nacionalidad:</label>
                <input type="text" id="itemNationality" name="itemNationality" class="form-control" 
                        value="<?php echo isset($actorObject) ? $actorObject->getNationality() : ''; ?>" required>
            </div>
            <button type="submit" name="buttonCreateEdit" class="btn btn-primary">
                <?php echo $action === 'create' ? 'Crear' : 'Editar'; ?>
            </button>
        </form>
        <?php
            } else {
                if ($action === 'create' && $actorCreated) {
                    AlertSystem::showSuccess('Actor creado exitosamente.', 'list.php', 'Volver al listado');
                } elseif ($action === 'edit' && $actorEdited) {
                    AlertSystem::showSuccess('Actor editado exitosamente.', 'list.php', 'Volver al listado');
                }
            }
        ?>
    </div>
</body>
</html>
