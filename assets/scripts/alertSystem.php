<?php
class AlertSystem {
    public static function showSuccess($message, $redirectTo, $linkText) {
        echo '<div class="container d-flex align-items-center justify-content-center vh-100">';
        echo '<div class="alert alert-success shadow rounded p-4 text-center" style="max-width: 500px; width: 100%;">';
        echo '<h4 class="mb-3 text-success"><i class="bi bi-check-circle"></i> ¡Correcto!</h4>';
        echo '<p class="mb-4">' . $message . '</p>';
        echo '<a href="' . $redirectTo . '" class="btn btn-outline-success">' . $linkText . '</a>';
        echo '</div>';
        echo '</div>';
    }
    
    public static function showError($message, $incorrectFields, $redirectTo, $linkText) {
        echo '<div class="container d-flex align-items-center justify-content-center vh-100">';
        echo '<div class="alert alert-danger shadow rounded p-4 text-center" style="max-width: 500px; width: 100%;">';
        echo '<h4 class="mb-3 text-danger"><i class="bi bi-exclamation-triangle"></i> Error</h4>';
        echo '<p class="mb-3">' . $message . '</p>';
        echo '<ul class="list-unstyled">';
        foreach ($incorrectFields as $field) {
            echo '<li><strong>' . htmlspecialchars($field) . '</strong></li>';
        }
        echo '</ul>';
        echo '<a href="' . $redirectTo . '" class="btn btn-outline-danger mt-3">' . $linkText . '</a>';
        echo '</div>';
        echo '</div>';
    }

    public static function showDeleteConfirmationModal($platformId, $titulo, $message) {
        echo '<div class="modal fade" id="confirmDeleteModal_' . $platformId . '" tabindex="-1" role="dialog" aria-labelledby="modalLabel_' . $platformId . '" aria-hidden="true">';
        echo '<div class="modal-dialog modal-dialog-centered" role="document">';
        echo '<div class="modal-content">';
        echo '<div class="modal-header bg-danger text-white">';
        echo '<h5 class="modal-title" id="modalLabel_' . $platformId . '"><i class="bi bi-trash"></i> ' . $titulo . '</h5>';
        echo '<button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>';
        echo '</div>';
        echo '<div class="modal-body">';
        echo '<p class="mb-0">' . $message . '</p>';
        echo '<small class="text-muted">Esta acción no se puede deshacer.</small>';
        echo '</div>';
        echo '<div class="modal-footer">';
        echo '<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>';
        echo '<button type="button" class="btn btn-danger" onclick="deleteItem(' . $platformId . ')">Eliminar</button>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';

    }    
}
?>
