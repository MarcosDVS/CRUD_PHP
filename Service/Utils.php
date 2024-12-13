<?php
function formatPhoneNumber($phone) {
    // Formatear el número de teléfono
    return preg_replace('/^(\d{3})(\d{3})(\d{4})$/', '($1) $2-$3', $phone);
}
?>