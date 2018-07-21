var appParam = {

  init:function(){
    $('#removePoj').on('click',appParam.removePoj);
    $('#addPoj').on('click',appParam.addPoj);

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
