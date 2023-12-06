//changer couleurquand il y a un changement de option
//<//script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>

$(document).on("click", function() {
  $('[data-toggle="tooltip"]').tooltip()
});

$(document).ready(function() {
  $.fn.dataTable.ext.errMode = 'none';
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  });
  $('#tableauAdmin thead tr').clone(true).appendTo( '#tableauAdmin thead' );
  $('#tableauAdmin thead tr:eq(1) th').each( function (i) {
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
  var table = $('#tableauAdmin').DataTable( {
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
            columns: [ 0, 1, 2, 3, 4, 5, 7 ]
        },
          text:       '<i class="fas fa-download"></i> PDF',
          className:  'shadow-sm',
        },
        {
          extend:     'csv',
          exportOptions: {
            columns: [ 0, 1, 2, 3, 4, 5, 7 ]
        },
          text:       '<i class="fas fa-download"></i> CSV',
          className:  'shadow-sm',
        },
      ],
      // scrollY:        "300px",
      // scrollX:        true,
      // scrollCollapse: true,
      // paging:         true,
      /* order: [[ 1, "desc" ], [ 3, "desc" ]],
      columnDefs: [
        { orderable: false, targets: [0,1,2,3,4,5,6,7] },
        { searchable: false, targets: [2,3] },
        { visible: false, targets: [12] },
        { className: 'dt-right', targets: [4, 5] },
        { className: 'dt-center', targets: [6, 7] },
        {
            targets: 7,
            render: function ( data, type, row ) {
              return data > 0 ? "<span class='badge badge-warning'>Retard</span>" : "";
            },
        },
        {
            targets: 9,
            render: function ( data, type, row ) {
              return data == 1 ? "<span class='badge badge-danger'>Sorti en avance</span>" : "";
            },
        },
        {
            targets: 11,
            render: function ( data, type, row ) {
              return data == 1 ? "<span class='btn btn-sm bg-success rounded-pill text-white'><i class='fas fa-check'></i></span>" : "";
            },
        },
        {
            targets: 12,
            data: null,
            render: function ( data, type, row ) {
              if(row[7]!=0 || row[9]==1 || row[11]==1){
                if(row[11]==1){
                  //return "<button class='btn btn-success btn-sm rounded-circle'><i class='fas fa-check'></i></button><button class='btn btn-success btn-sm rounded-circle'><i class='fas fa-check'></i></button>";
                } else {
                  //return "<button class='btn btn-primary btn-sm rounded-circle'><i class='fas fa-check fa-1x'></i></button><button class='btn btn-danger btn-sm rounded-circle'><i class='fas fa-times fa-lg'></i></button>";
                }
              }
            },
        },
      ],*/
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
} );
