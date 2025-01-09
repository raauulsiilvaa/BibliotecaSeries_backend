<?php 
    require_once('../../controllers/PlatformController.php'); 
    require_once('../../assets/scripts/alertSystem.php');
    require_once('../../assets/scripts/validations.php'); 
?>
<!DOCTYPE html>
<html>
    <head>
        <script src="../../assets/scripts/shared.js"></script> 
    </head>
    <style>
        .row {
            margin-top: 25px;    
        }  
        label{
            margin-top: 10px;   
        }
        
    </style>
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
                $fieldsToValidate = ['itemName'];

                //Editar plataforma
                if ($action === 'edit') {
                    $idPlatform = $_GET['id']; 
                    $platformObject = getPlatformData($idPlatform); 

                    $platformEdited = false;  
                    if(isset($_POST['buttonCreateEdit'])){ 
                        $sendData = true; 
                    }

                    if($sendData){
                        if (isset($_POST['itemName'])) {
                            $validationResult = validateFields($_POST, $fieldsToValidate);

                            $errors = $validationResult['errors'];
                            $errorsEmptyFields = $validationResult['errorsEmptyFields'];
                            $errorMessage = $validationResult['errorMessage'];
                            $incorrectFields = $validationResult['incorrectFields'];
                        
                            if (!empty($errorsEmptyFields) || !empty($errors)) {
                                AlertSystem::showError("La plataforma no se ha editado correctamente." . 
                                $errorMessage, $incorrectFields, 'list.php', 'Volver al listado de plataformas');
                            }
                            else {
                                $platformEdited =  updatePlatform($_POST['platformId'], $_POST['itemName']); 
                                if (!$platformEdited) {
                                    AlertSystem::showError("La plataforma ya existe.". 
                                    $errorMessage, $incorrectFields, 'list.php', 'Volver atrás');
                                }
                            }               
                        }                        
                    }
                } 
                //Crear plataforma
                else if ($action === 'create') {
                    $platformCreated = false;  
                    if(isset($_POST['buttonCreateEdit'])){ 
                        $sendData = true; 
                    }
                    if($sendData){
                        if (isset($_POST['itemName'])) {
                            $validationResult = validateFields($_POST, $fieldsToValidate);

                            $errors = $validationResult['errors'];
                            $errorsEmptyFields = $validationResult['errorsEmptyFields'];
                            $errorMessage = $validationResult['errorMessage'];
                            $incorrectFields = $validationResult['incorrectFields'];
                        
                            if (!empty($errorsEmptyFields) || !empty($errors)) {
                                AlertSystem::showError("La plataforma no se ha creado correctamente." . 
                                $errorMessage, $incorrectFields, 'createEdit.php', 'Volver a intentarlo');
                            }
                            else {
                                $platformCreated = storePlatform($_POST['itemName']); 
                                if (!$platformCreated) {
                                    AlertSystem::showError("La plataforma ya existe.". 
                                    $errorMessage, $incorrectFields, 'list.php', 'Volver atrás');
                                }
                            }               
                        } 
                    }
                }
                if(!$sendData) {

            ?>
    
            <div class="row">
                <div class="col-12">
                    <?php 
                        if ($action === 'create'){
                        ?>
                            <h1>Crear plataforma</h1>
                        <?php 
                            } else {
                        ?>                    
                        <h1>Editar plataforma</h1> 
                        <?php 
                            }
                    ?>
                </div>
                <div class="col-12">
                    <form name="create_platform" action="" method="POST">
                        <div class="mb-3">
                            <label for="itemName" class="form-label">Nombre plataforma</label>
                            <input id="itemName" name="itemName" type="text" placeholder="Introduce el nombre de la plataforma" class="form-control" required value="<?php if(isset($platformObject)) echo $platformObject->getName(); ?>"/>
                            <?php 
                                if ($action === 'edit') {
                            ?>                           
                                <input type="hidden" name="platformId" value="<?php echo $idPlatform; ?>"/>
                            <?php 
                                }
                            ?>
                        </div>
                        <input type="submit" value="<?php echo ($action === 'create') ? 'Crear' : 'Editar' ?>" class="btn btn-primary" name="buttonCreateEdit"/>
                    </form>
                </div>
            </div>

            <?php 
                } else {
                    if ($action === 'create') {
                        if ($platformCreated) {
                            AlertSystem::showSuccess('Plataforma creada correctamente.','list.php', 'Volver al listado de plataformas');
                        } 
                    }
                    if ($action === 'edit') {
                        if ($platformEdited) {
                            AlertSystem::showSuccess('Plataforma editada correctamente.', 'list.php', 'Volver al listado de plataformas');
                        } 
                    }
                }
                ?>
        </div>
    </body>
</html>
