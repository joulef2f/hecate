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


    $.ajax(
      route,
      {
        method:'GET',

      }
    ).done(function(data){

      $(evt.target).parent().parent().prev(".card-body").append(`<li class="sp_${data.profil} px-1 my-1">${data.name}</li>`)
      app.howManyITook();
      app.checkNeeds()
    })
  },
  removeUser:function(evt){
    var id = $(evt.target).closest('.card').data('id')
    var route = Routing.generate('removeUser',{ id : id })


    $.ajax(
      route,
      {
        method:'GET',

      }
    ).done(function(data){

      $('.card[data-id='+id+']>.card-body> li:contains('+data.name+')').remove();
      app.howManyITook();
      app.checkNeeds()
    })
  },
  checkNeeds:function(){
    $(".card > .card-header").each(function(){


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
    var name = $("#username").text().toLowerCase()
    console.log(name);
    var nb = $('.card-body > div:contains('+ name +') ').length
    console.log(nb);
    $('#atTake').text(nb)
  }
}
$(app.init)
