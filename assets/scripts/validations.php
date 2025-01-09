<?php

function validateFields($postData, $fieldsToValidate)
{
    $errors = array();
    $errorsEmptyFields = array();

    foreach ($fieldsToValidate as $fieldName) {
        // Verificar si el campo está presente en $postData
        if (!array_key_exists($fieldName, $postData)) {
            continue; // Saltar la validación si el campo no está presente
        }

        // Validar campos no vacíos
        if (empty($postData[$fieldName])) {
            $errorsEmptyFields[] = $fieldName;
        }

        if (!empty($postData[$fieldName])) {
            switch ($fieldName) {
                case 'itemName':
                    if (!preg_match('/^[A-Za-zÁ-Úá-ú\s]{1,100}$/', $postData[$fieldName])) {
                        $errors[] = 'nombre';
                    }
                    break;

                case 'itemSurnames':
                    if (!preg_match('/^[A-Za-zÁ-Úá-ú\s]{1,200}$/', $postData[$fieldName])) {
                        $errors[] = 'apellidos';
                    }
                    break;

                case 'itemBirthdate':
                    if (preg_match('/^(((0[1-9])|([12][0-9])|(3[01]))-((0[0-9])|(1[012]))-((20[012]\d|19\d\d)|(1\d|2[0123])))$/', $postData[$fieldName])) {
                        $errors[] = 'fecha nacimiento';
                    }
                    break;                   
                    
                case 'itemNationality':
                    if (!preg_match('/^[A-Za-zÁ-Úá-ú\s]{1,30}$/', $postData[$fieldName])) {
                        $errors[] = 'nacionalidad';
                    }
                    break;
                
                case 'itemISOCode':
                    if (!preg_match('/^[a-z]{2}$/', $postData[$fieldName])) {
                        $errors[] = 'código ISO';
                    }
                    break;

                default:
                    break;
            }
        }
    }

    $validationResult = array(
        'errors' => $errors,
        'errorsEmptyFields' => $errorsEmptyFields,
        'errorMessage' => '',
        'incorrectFields' => ''
    );

    if (!empty($errorsEmptyFields) || !empty($errors)) {
        $errorMessage = '';
        $incorrectFields = '';

        if (!empty($errorsEmptyFields)) {
            $errorMessage .= ' Todos los campos obligatorios deben ser completados.';
        }
        if (!empty($errors)) {
            if (count($errors) > 1) {
                $errorMessage .= ' Los siguientes campos tienen un formato incorrecto: ';
            } else {
                $errorMessage .= ' El siguiente campo tiene un formato incorrecto: ';
            }
            $incorrectFields = implode(', ', $errors);
        }

        $validationResult['errorMessage'] = $errorMessage;
        $validationResult['incorrectFields'] = $incorrectFields;
    }

    return $validationResult;
}

?>



