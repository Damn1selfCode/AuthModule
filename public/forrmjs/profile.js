$(document).ready(function() {
    $('#confirmation_checkbox').on('change', function() {
        if ($(this).is(':checked')) {
            $('#deleteAccountButton').prop('disabled', false);
        } else {
            $('#deleteAccountButton').prop('disabled', true);
        }
    });

    $('#deleteAccountButton').on('click', function() {
        // Mostrar el modal de confirmación
        $('#confirmDeleteModal').modal('show');
    });

    // Agregar un manejador para enviar la solicitud DELETE cuando se confirma la eliminación
    $('#confirmDeleteModal').on('hidden.bs.modal', function() {
        $('#deleteAccountForm').submit();
    });
});