var appSort = {
  crenData : {},
  init:function(){

    $('.card-body').sortable({
      connectWith: '.card-body',
      update: appSort.update,
      stop: appSort.sort
    }).disableSelection()
    $('.card-body').selectable()

  },
  update:function(evt, ui){

    var id = $(evt.target).closest('.card').data('id')
    var data = {} ;

    // j'en suis la je n'arrive pas encore à récuperer toutes les "li"
    data[id] = []
    $(this).find('li').each(function(){
      data[id].push($(this).text())
    })

    appSort.crenData[id] = (data[id])

  },
  sort:function(evt, ui){
    console.log(appSort.crenData);

    var route = Routing.generate('updateAll')
    $.ajax(
      route,
      {
        method:'POST',
        data:{
          tab : JSON.stringify(appSort.crenData)
        }

      }
    ).done(function(data){

      console.log(data);
    })
  }
}

$(appSort.init)
