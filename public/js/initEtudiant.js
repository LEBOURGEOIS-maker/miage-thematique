$(document).ready(function() {
    $('#tableauEtudiant').DataTable( {
        // dom: 'lBfrtip',
        //   colReorder: true,
        //   stateSave: true,
        //   buttons: [
        //     'csv', 'excel'
        // ],
        scrollY: '45vh',
        scrollX: false,
        scrollCollapse: true,
        scroller: true,
        paging: true,
        order: [[ 0, "desc" ], [ 2, "desc" ]],
        columnDefs: [
          { orderable: false, targets: [1,2,3,4,6,7,8] },
          { searchable: false, targets: [1,2,3] },
          {
              targets: 5, //colonne tps de présence
              render: function ( data, type, row ) {
                d = Number(data);
                var h = Math.floor(d / 3600);
                var m = Math.floor(d % 3600 / 60);
                var s = Math.floor(d % 3600 % 60);

                var hDisplay = h > 0 ? h + (h == 1 ? "h" : "h") : "";
                var mDisplay = m > 0 ? m + (m == 1 ? "min" : "min") : "";
                var sDisplay = s > 0 ? s + (s == 1 ? "s" : "s") : "";
                return hDisplay + mDisplay + sDisplay;
              }
          },
          {
              targets: 6,
              render: function ( data, type, row ) {
                return data > 0 ? "<span class='badge badge-warning'>Retard</span>" : "";
              },
          },
          {
              targets: 7,
              render: function ( data, type, row ) {
                return data == 1 ? "<span class='badge badge-danger'>Sortie en avance</span>" : "";
              },
          },
        ],
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
            "sNext":     "Suivant",
            "sPrevious": "Précédent"
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
        initComplete: function () {
            this.api().columns([0,4]).every( function () {
                var column = this;
                var title = $(column.footer()).text();
                var select = $('<select><option value="">'+title+'</option></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
        },
    } );
} );
