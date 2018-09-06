var appParam = {

  init:function(){
    $('#removePoj').on('click',appParam.removePoj);
    $('#addPoj').on('click',appParam.addPoj);
    //"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""
    $( function() {
  $( "#datepicker" ).datepicker({
altField: "#datepicker",
closeText: 'Fermer',
prevText: 'Précédent',
nextText: 'Suivant',
currentText: 'Aujourd\'hui',
monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
monthNamesShort: ['Janv.', 'Févr.', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil.', 'Août', 'Sept.', 'Oct.', 'Nov.', 'Déc.'],
dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
dayNamesShort: ['Dim.', 'Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.'],
dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
weekHeader: 'Sem.',
dateFormat: 'dd-mm-yy'
});
} );

  },

  removePoj:function(){

    var route = Routing.generate('updatePoj', {param:'remove'});


        $.ajax(
          route,
          {
            method:'GET',

          }
        ).done(function(data){
          $('#removePoj').next().text(data.val)

        })
      },
  addPoj:function(){

    var route = Routing.generate('updatePoj', {param:'add'});


        $.ajax(
          route,
          {
            method:'GET',

          }
        ).done(function(data){
          $('#removePoj').next().text(data.val)

        })
      },

  }

$(appParam.init)
