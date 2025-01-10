<?php 
    require_once('../../controllers/LanguageController.php'); 
      require_once('../../assets/scripts/alertSystem.php');
    require_once('../../assets/scripts/validations.php'); 
?>
<!DOCTYPE html>
<html>
    <head>
        <script src="../../assets/scripts/shared.js"></script>
    </head>
    <header>
        <a href="../../index.html">
            <img src="/images/house-solid.svg" alt="home" style="margin:20px; width: 40px; height: 40px;">
        </a>
    </header>
    <body>
        <div class="container">
            <?php
                $fieldsToValidate = ['itemName', 'itemISOCode'];
                $sendData = false;
                $action = isset($_GET['action']) ? $_GET['action'] : 'create';

                //Editar plataforma
                if ($action === 'edit') {
                    $idLanguage = $_GET['id']; 
                    $languageObject = getLanguageData($idLanguage); 

                    $languageEdited = false;  
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
                                 AlertSystem::showError("El idioma no se ha editado correctamente." . $errorMessage, $incorrectFields, 'list.php', 'Volver al listado de directors');
                            }
                            else {
                                $languageEdited =  updateLanguage($_POST['itemId'], $_POST['itemName'], $_POST['itemISOCode']); 
                                if (!$languageEdited) {
                                    AlertSystem::showError("El lenguaje ya existe.". 
                                    $errorMessage, $incorrectFields, 'list.php', 'Volver atrás');
                                }
                            }               
                        }                        
                    }
                } 
                //Crear plataforma
                else if ($action === 'create') {
                    $languageCreated = false;  
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
                                 AlertSystem::showError("El idioma no se ha creado correctamente." . $errorMessage, $incorrectFields, 'createEdit.php', 'Volver a intentarlo');
                            }
                            else {
                                $languageCreated = storeLanguage($_POST['itemName'], $_POST['itemISOCode']);
                                if (!$languageCreated) {
                                    AlertSystem::showError("El lenguaje ya existe.". 
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
                    <h1>Crear Idioma</h1>
                </div>
                <div class="col-12">
                    <form name="create_language" action="" method="POST">
                    <div class="row">
                        <div class="col-6">
                            <label for="itemeName" class="form-label">Nombre idioma</label>
                            <input id="itemName" name="itemName" type="text" placeholder="Introduce el nombre del idioma" class="form-control" required value="<?php if(isset($languageObject)) echo $languageObject->getName(); ?>"/>
                            <?php 
                                if ($action === 'edit') {
                            ?>                           
                                <input type="hidden" name="itemId" value="<?php echo $idLanguage; ?>"/>
                            <?php 
                            }
                            ?>
                        </div>
                        <div class="col-6">
                            <label for="itemISOCode" class="form-label">Código ISO:</label>
                            <input id="itemISOCode" name="itemISOCode" type="text" placeholder="Introduce el idioma" class="form-control" required value="<?php if(isset($languageObject)) echo $languageObject->getISOCode(); ?>"/>
                            <?php 
                                if ($action === 'edit') {
                            ?>                           
                                <input type="hidden" name="itemId" value="<?php echo $idLanguage; ?>"/>
                            <?php 
                               }
                            ?>
                        </div>   
                    </div>
                        <input type="submit" value="<?php echo ($action === 'create') ? 'Crear' : 'Editar' ?>" class="btn btn-primary" name="buttonCreateEdit"/>
                    </form>
                </div>
            </div>

            <?php 
               } else {
                    if ($action === 'create') {
                        if ($languageCreated) {
                             AlertSystem::showSuccess('Idioma creado correctamente.', 'list.php', 'Volver al listado de plataformas');
                        } 
                    }
                    if ($action === 'edit') {
                        if ($languageEdited) {
                             AlertSystem::showSuccess('Idioma editado correctamente.', 'list.php', 'Volver al listado de plataformas');
                        } 
                    }
                }
                ?>
        </div>
    </body>
</html>
