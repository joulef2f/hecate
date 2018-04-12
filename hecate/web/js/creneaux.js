app = {
  init:function(){

    $('.in').on('click',app.addUser)
    $('.out').on('click',app.removeUser)

  },
  addUser:function(evt){
    var id = $(evt.target).closest('.card').data('id')
    var route = Routing.generate('addUser',{ id : id })
    console.log(route);

    $.ajax(
      route,
      {
        method:'GET',

      }
    ).done(function(data){

      $(evt.target).parent().parent().prev(".card-body").append(`<div class="sp_${data.profil} px-1 my-1">${data.name}</div>`)
    })
  },
  removeUser:function(evt){
    var id = $(evt.target).closest('.card').data('id')
    var route = Routing.generate('removeUser',{ id : id })
    console.log(route);

    $.ajax(
      route,
      {
        method:'GET',

      }
    ).done(function(data){
      console.log($('.card[data-id='+id+']>.card-body> div:contains('+data.name+')'));
      $('.card[data-id='+id+']>.card-body> div:contains('+data.name+')').remove()
    })
  }
}
$(app.init)
