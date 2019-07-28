$(function(){
  let user_result;
  let show_data = true;
  let page_actual;
  InitialState();

  function Search (search_value, show_data, page_actual){
    $.ajax({
      url:"search.php",
      type:"POST",
      dataType : 'json',
      data: {
        search : search_value,
        show : show_data, // muestra todos los ucuarios si es true
        page : page_actual,
      },
      success:function(msg){
        showDataObt(msg,show_data);
      },
    });
  }

  function InitialState(){
    Search(0,true,1);
  };

  function showDataObt(data_show,show_data){
    html = "";
    if(show_data){
      data_show.forEach(function(key) {
        html +=
        '<div class="card" style="width: 12rem;">'+
              '<img class="card-img-top" src="'+key.avatar+'" alt="Card image cap">'+
              '<div class="card-body">'+
                '<h5 class="card-title">'+key.first_name+'</h5>'+
                '<h6 class="card-subtitle mb-2">'+key.last_name+'</h6>'+
                '<p class="card-text">'+key.email+'</p>'+
              '</div>'+
        '</div>';
      });
    }else{
      data_show.data.forEach(function(key){
        html +=
        '<div class="card" style="width: 12rem;">'+
              '<img class="card-img-top" src="'+key.avatar+'" alt="Card image cap">'+
              '<div class="card-body">'+
                '<h5 class="card-title">'+key.first_name+'</h5>'+
                '<h6 class="card-subtitle mb-2">'+key.last_name+'</h6>'+
                '<p class="card-text">'+key.email+'</p>'+
              '</div>'+
        '</div>';
      });
    }
    $('#dataShow').html(html); 
  };
  
  
  $('#show_button').on('click',function(){
    show_data = !show_data;
    if( show_data ){
    $('#show_button').val('Show por page');
    Search(0,show_data,1);
  }else{
    $('#show_button').val('Show all users');
    Search(0,show_data,1);
  }
  });
  
  $("#button_search").on("click", function(e){ //para hacer la busqueda por pagina
    e.preventDefault();
    let search_value = $('#miBusqueda').val();
    if(search_value != null){
      user_result = Search(search_value,false,page_actual);
    }else{
      $("#dataShow").html("NO HAY NADA")
    }  
  });

});