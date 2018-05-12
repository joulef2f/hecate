var app = {
  init:function(){

    $('.in').on('click',app.addUser)
    $('.out').on('click',app.removeUser)
    app.checkNeeds();
    app.howManyITook();
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
      app.howManyITook();
      app.checkNeeds()
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
      $('.card[data-id='+id+']>.card-body> div:contains('+data.name+')').remove();
      app.howManyITook();
      app.checkNeeds()
    })
  },
  checkNeeds:function(){
    $(".card > .card-header").each(function(){
      console.log($(this).next(".card-body").children(".sp_CATEPL").length);

      if ($(this).next(".card-body").children().hasClass("sp_CATE") || $(this).next(".card-body").children().hasClass("sp_CATEPL") ) {
        $(this).children().children(".sp_CATE").remove();
      }

      if ($(this).next(".card-body").children().hasClass("sp_PL") ||
        $(this).next(".card-body").children(".sp_CATEPL").length >= 2 ||
        $(this).next(".card-body").children("sp_CAPL") &&
        $(this).next(".card-body").children("sp_CA") ||
        $(this).next(".card-body").children().hasClass("sp_CATE") &&
        $(this).next(".card-body").children().hasClass("sp_CATEPL")){
          $(this).children().children(".sp_PL").remove();
        }

      if ($(this).next(".card-body").children().hasClass("sp_CATE") || $(this).next(".card-body").children().hasClass("sp_CATEPL") ) {
        $(this).children().children(".sp_CATE").remove();
      }


    })
  },
  howManyITook:function(){
    var name = $("#username").text()
    var nb = $('.card-body > div:contains('+ name +') ').length
    $('#atTake').text(nb)
  }
}
$(app.init)
