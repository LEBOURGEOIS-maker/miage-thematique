$(document).on("click", function() {
  $('[data-toggle="tooltip"]').tooltip()
});
$(document).ready(function() {
  $('#tableauListe thead tr').clone(true).appendTo( '#tableauListe thead' );
  $('#tableauListe thead tr:eq(1) th').each( function (i) {
      var title = $(this).text();
      $(this).html( '<input class="form-control form-control-sm" type="text" placeholder="Filtrer" />' );

      $( 'input', this ).on( 'keyup change', function () {
          if ( table.column(i).search() !== this.value ) {
              table
                  .column(i)
                  .search( this.value )
                  .draw();
          }
      } );
  } );
  var table = $('#tableauListe').DataTable( {
      // dom: '<lf<t>ip>',
      orderCellsTop: true,
      fixedHeader: true,
      dom: 'lBtip',
      lengthMenu: [
          [ -1, 10, 25, 50, 100 ],
          [ 'Voir tout', '10', '25', '50', '100' ]
      ],
      buttons: [
        // {
        //   extend:     'pageLength',
        //   className:  'shadow-sm mr-2',
        // },
        {
          extend:     'pdf',
                    exportOptions: {
            columns: [ 0, 1 ]
        },
          text:       '<i class="fas fa-download"></i> PDF',
          className:  'shadow-sm',
        },
        {
          extend:     'csv',
          exportOptions: {
            columns: [ 0, 1]
        },
          text:       '<i class="fas fa-download"></i> CSV',
          className:  'shadow-sm',
        },
      ],
      // scrollY:        "300px",
      // scrollX:        true,
      // scrollCollapse: true,
      // paging:         true,
      /*order: [[ 0, "desc" ], [ 1, "desc" ]],
      columnDefs: [ {
        "targets": 0,
        "searchable": false
      } ],*/
      language: {
        "sEmptyTable":     "Aucune donnée disponible dans le tableau",
        "sInfo":           "Affichage de l'élément _START_ à _END_ sur _TOTAL_ éléments",
        "sInfoEmpty":      "Affichage de l'élément 0 à 0 sur 0 élément",
        "sInfoFiltered":   "(filtré à partir de _MAX_ éléments au total)",
        "sInfoPostFix":    "",
        "sInfoThousands":  ",",
        "sLengthMenu":     "Afficher _MENU_ éléments",
        "sLoadingRecords": "Chargement...",
        "sProcessing":     "Traitement...",
        "sSearch":         "Rechercher :",
        "sZeroRecords":    "Aucun élément correspondant trouvé",
        "oPaginate": {
          "sFirst":    "Premier",
          "sLast":     "Dernier",
          "sNext":     "<i class='fas fa-arrow-right'></i>",
          "sPrevious": "<i class='fas fa-arrow-left'></i>"
        },
        "oAria": {
          "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
          "sSortDescending": ": activer pour trier la colonne par ordre décroissant"
        },
        "select": {
                "rows": {
                  "_": "%d lignes sélectionnées",
                  "0": "Aucune ligne sélectionnée",
                  "1": "1 ligne sélectionnée"
                }
        }
      },
  } );
});
