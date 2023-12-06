$(document).on("click", function() {
  $('[data-toggle="tooltip"]').tooltip()
});

$('#recherche_pointage_periode_periode').datepicker({
  language: "fr",
  position: "right bottom",
  range: true,
  multipleDatesSeparator: "-",
  clearButton: true,
  todayButton: true,
  autoClose: false,
});

$('#recherche_anomalie_periode_periode').datepicker({
  language: "fr",
  position: "right bottom",
  range: true,
  multipleDatesSeparator: "-",
  clearButton: true,
  todayButton: true,
  autoClose: false,
});

$(document).ready(function() {
  $.fn.dataTable.ext.errMode = 'none';
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  });
  $('#tableauAdmin thead td').each(function () {
      var title = $('#tableauAdmin tfoot th').eq( $(this).index() ).text();
      $(this).html( '<input class="form-control form-control-sm" type="text" placeholder="'+title+'" />'  );
  } );
  var table = $('#tableauAdmin').DataTable( {
      // dom: '<lf<t>ip>',
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
          extend:     'colvis', //columnsToggle //columnVisibility
          text:       'Colonne',
          columns:    [7,8,9,10,11,12],
          className:  'shadow-sm mr-2',
          columnText: function ( dt, idx, title ) {
              if(idx == 8) {
                return 'Justification de retard';
              }
              if(idx == 10) {
                return 'Justification';
              }
              return title;
          },
        },
        {
          extend:     'pdf',
          text:       '<i class="fas fa-download"></i> PDF',
          className:  'shadow-sm',
        },
        {
          extend:     'csv',
          text:       '<i class="fas fa-download"></i> CSV',
          className:  'shadow-sm',
        },
      ],
      // scrollY:        "300px",
      // scrollX:        true,
      // scrollCollapse: true,
      // paging:         true,
      order: [[ 1, "desc" ], [ 3, "desc" ]],
      columnDefs: [
        { orderable: false, targets: [0,1,2,3,4,5,6,7,8,9,10,11] },
        { searchable: false, targets: [2,3,8,10,11,12] },
        { visible: false, targets: [11] },
        { className: 'dt-right', targets: [7,9] },
        { className: 'dt-center', targets: [11,12] },
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
                  return "<button class='btn btn-success btn-sm rounded-circle'><i class='fas fa-check'></i></button>";
                } else {
                  return "<button class='btn btn-primary btn-sm rounded-circle'><i class='fas fa-check'></i></button>";
                }
              }
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
  // Apply the search
    table.columns().every( function () {
      var that = this;

      $( 'input', this.header() ).on( 'keyup change', function () {
          if ( that.search() !== this.value ) {
              that
                  .search( this.value )
                  .draw();
          }
      } );
  } );

  table.buttons().container()
    .appendTo( $('.col-sm-6:eq(0)', table.table().container() ) );

} );
