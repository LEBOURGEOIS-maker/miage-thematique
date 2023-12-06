$(document).ready(function() {
  //Custom recherche depuis le premier caractère
  function rechercheParPremierCaractere(params, data) {
    params.term = params.term || '';
    if (data.text.toUpperCase().indexOf(params.term.toUpperCase()) == 0) {
        return data;
    }
    return false;
  }

  //Placeholder de l'input de recherche
  (function($) {
      var Defaults = $.fn.select2.amd.require('select2/defaults');
      $.extend(Defaults.defaults, {
          searchInputPlaceholder: ''
      });
      var SearchDropdown = $.fn.select2.amd.require('select2/dropdown/search');
      var _renderSearchDropdown = SearchDropdown.prototype.render;
      SearchDropdown.prototype.render = function(decorated) {
          var $rendered = _renderSearchDropdown.apply(this, Array.prototype.slice.apply(arguments));
          this.$search.attr('placeholder', this.options.get('searchInputPlaceholder'));
          return $rendered;
      };
  })(window.jQuery);


  //Init Select2
  $('#pointage_cours').select2({
    placeholder: "Cours",
    searchInputPlaceholder: 'Rechercher un cours',
    allowClear: true,
  });
  //Init Select2
  $('#pointage_plageHoraire').select2({
    placeholder: "Plage horaire",
    searchInputPlaceholder: 'Rechercher une plage horaire',
    allowClear: true,
    matcher: function(params, data) {
        return rechercheParPremierCaractere(params, data);
    },
  });
});
