<?php
require_once('../../controllers/PlatformController.php');
require_once('../../controllers/LanguageController.php');
require_once('../../controllers/DirectorController.php');
require_once('../../controllers/ActorController.php');
require_once('../../controllers/SerieController.php');
require_once('../../controllers/ActorsSeriesController.php');
require_once('../../controllers/LanguageSeriesAudioController.php');
require_once('../../controllers/LanguageSeriesSubtitlesController.php');
require_once('../../assets/scripts/showMessage.php');
require_once('../../assets/scripts/validations.php');
?>

<!DOCTYPE html>
<html>

<head>

    <script src="../../assets/scripts/shared.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>

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
        $fieldsToValidate = ['itemTitle', 'itemPlatformId', 'itemDirectorId'];

        // Editar serie
        if ($action === 'edit') {
            $idSeries = $_GET['id'];
            
            $seriesObject = getSeriesData($idSeries);       

            $languagesAudioSeriesObject = getLanguageAudioDataForSeries($idSeries);
            $languagesSubtitlesSeriesObject = getLanguageAudioDataForSeries($idSeries);

            $seriesEdited = false;
            if (isset($_POST['buttonCreateEdit'])) {
                $sendData = true;
            }
            if ($sendData) {
                if (isset($_POST['itemTitle'])) {
                    $validationResult = validateFields($_POST, $fieldsToValidate);

                    $errors = $validationResult['errors'];
                    $errorsEmptyFields = $validationResult['errorsEmptyFields'];
                    $errorMessage = $validationResult['errorMessage'];
                    $incorrectFields = $validationResult['incorrectFields'];

                    if (!empty($errorsEmptyFields) || !empty($errors)) {
                         AlertSystem::showError("La serie no se ha editado correctamente." . $errorMessage, $incorrectFields, 'list.php', 'Volver al listado de series');
                    } else {
                        $seriesEdited = updateSeries($_POST['itemId'], $_POST['itemTitle'], $_POST['itemPlatformId'], $_POST['itemDirectorId']);
                    }
                }
            }
        }
        // Crear serie
        else if ($action === 'create') {
            $seriesCreated = false;
            if (isset($_POST['buttonCreateEdit'])) {
                $sendData = true;
            }
            if ($sendData) {
                if (isset($_POST['itemTitle'])) {
                    $validationResult = validateFields($_POST, $fieldsToValidate);

                    $errors = $validationResult['errors'];
                    $errorsEmptyFields = $validationResult['errorsEmptyFields'];
                    $errorMessage = $validationResult['errorMessage'];
                    $incorrectFields = $validationResult['incorrectFields'];

                    if (!empty($errorsEmptyFields) || !empty($errors)) {
                         AlertSystem::showError("La serie no se ha creado correctamente." . $errorMessage, $incorrectFields, 'list.php', 'Volver al listado de series');
                    } else {
                        $seriesCreated = storeSeries($_POST['itemTitle'], $_POST['itemPlatformId'], $_POST['itemDirectorId'], 
                                                    $_POST['itemActorId'],$_POST['itemLanguageAudioId'],$_POST['itemLanguageSubtitlesId']);
                    }
                }
            }
        }
        if (!$sendData) {
        ?>

            <div class="row">
                <div class="col-12">
                    <h1><?php echo ($action === 'create') ? 'Crear serie' : 'Editar serie'; ?></h1>
                </div>
                <div class="col-12">
                    <form name="create_series" action="" method="POST">

                        <div class="row">
                            <div class="col-6">
                                <label for="itemTitle" class="form-label">Título: </label>
                                <input id="itemTitle" name="itemTitle" type="text" placeholder="Introduce el título" class="form-control" required value="<?php if (isset($seriesObject)) echo $seriesObject->getTitle(); ?>" />
                                <?php
                                if ($action === 'edit') {
                                ?>
                                    <input type="hidden" name="itemId" value="<?php echo $idSeries; ?>" />
                                <?php
                                }
                                ?>
                            </div>
                            <div class="col-6">
                                <label for="itemPlatformId" class="form-label">Plataforma:</label>
                                <select id="itemPlatformId" name="itemPlatformId" class="form-control" required>
                                    <?php
                                    $platformsList = listPlatforms();
                                    foreach ($platformsList as $platform) {
                                        $selected = (isset($seriesObject) && $seriesObject->getPlatformId() == $platform->getId()) ? 'selected' : '';
                                        echo "<option value='{$platform->getId()}' {$selected}>{$platform->getName()}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label for="itemDirectorId" class="form-label">Director: </label>
                                <select id="itemDirectorId" name="itemDirectorId" class="form-control" required>
                                    <?php
                                    $directorsList = listDirectors();
                                    foreach ($directorsList as $director) {
                                        $selected = (isset($seriesObject) && $seriesObject->getDirectorId() == $director->getId()) ? 'selected' : '';
                                        echo "<option value='{$director->getId()}' {$selected}>{$director->getName()} {$director->getSurnames()}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-6">
                                <label for="itemActorId" class="form-label">Actor: </label>
                                <select id="itemActorId" name="itemActorId[]" class="chosen-select form-control" multiple required value="<?php if (isset($actorsSeriesObject)) echo $actorsSeriesObject->getName() . ' '.  getSurnames(); ?>" />
                                    <?php
                                    $actorsList = listActors();
                                    foreach ($actorsList as $actor) {
                                        $selected = (isset($seriesObject) && in_array($actor->getId(), $seriesObject->getActorId())) ? 'selected' : '';
                                        echo "<option value='{$actor->getId()}' {$selected}>{$actor->getName()} {$actor->getSurnames()}</option>";
                                    }
                                    ?>
                                </select>
                                <?php
                                if ($action === 'edit') {
                                ?>
                                    <input type="hidden" name="itemId" value="<?php echo $idSeries; ?>" />
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                    <label for="itemLanguageAudioId" class="form-label">Idiomas audio: </label>
                                    <select id="itemLanguageAudioId" name="itemLanguageAudioId[]" class="chosen-select form-control" multiple required>
                                        <?php
                                        $languagesList = listLanguages();
                                        foreach ($languagesList as $language) {
                                            $selected = (isset($seriesObject) && in_array($language->getId(), $seriesObject->getLanguageId())) ? 'selected' : '';
                                            echo "<option value='{$language->getId()}' {$selected}>{$language->getName()} </option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label for="itemLanguageSubtitlesId" class="form-label">Idiomas subtítulos: </label>
                                    <select id="itemLanguageSubtitlesId" name="itemLanguageSubtitlesId[]" class="chosen-select form-control" multiple required>
                                        <?php
                                        $languagesList = listLanguages();
                                        foreach ($languagesList as $language) {
                                            $selected = (isset($seriesObject) && in_array($language->getId(), $seriesObject->getLanguageId())) ? 'selected' : '';
                                            echo "<option value='{$language->getId()}' {$selected}>{$language->getName()} </option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <input type="submit" style="margin-left: 15px;" value="<?php echo ($action === 'create') ? 'Crear' : 'Editar' ?>" class="btn btn-primary" name="buttonCreateEdit" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        <?php
        } else {
            if ($action === 'create') {
                if ($seriesCreated) {
                     AlertSystem::showSucces('Serie creada correctamente.', 'list.php', 'Volver al listado de series');
                }
            }
            if ($action === 'edit') {
                if ($seriesEdited) {
                     AlertSystem::showSucces('Serie editada correctamente.', 'list.php', 'Volver al listado de series');
                }
            }
        }
        ?>
    </div>
    <script>
        // Inicializar Chosen en tu select
        $(document).ready(function(){
            $(".chosen-select").chosen();
        });
    </script>
</body>

</html>
