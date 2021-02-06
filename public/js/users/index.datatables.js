// Call the dataTables jQuery plugin
$(document).ready(function() {
  $('#dataTable').DataTable({
        language: {
            //processing:    "Traitement en cours...",
            search:        "Buscar:",
            lengthMenu:    "Mostrar _MENU_ registros",
            info:           "Mostrando _START_ hasta _END_ de _TOTAL_ registros",
            infoEmpty:      "",
            infoFiltered:   "(filtrado de un total de _MAX_ entradas)",
            infoPostFix:    "",
            loadingRecords: "Cargando registros...",
            //zeroRecords:    "No existen registros para mostrar",
            emptyTable:     "No existen registros para mostrar",
            paginate: {
                first:      "Primer",
                previous:   "Anterior",
                next:       "Siguiente",
                last:       "Último"
            },
            aria: {
                //sortAscending:  ": activer pour trier la colonne par ordre croissant",
                //sortDescending: ": activer pour trier la colonne par ordre décroissant"
            }
        },
        columnDefs: [ {
                "targets": 'no-sort',
                "orderable": false,
        } ]
    });
});
