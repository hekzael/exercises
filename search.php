<?php

$search_value = (isset($_POST["search"]))? $_POST["search"] : 0;
$page_actual = (isset($_POST["page"]))? $_POST["page"] : 1 ;
$show_select = (isset($_POST["show"]))? $_POST["show"] : false;
$search_value = ((int)$search_value);
$page_actual = ((int)$page_actual);
//obtengo toda la data el endpoint
  function Get_Data ( $pageSearch ) {
    $url = "https://reqres.in/api/users".$pageSearch;
    //  Iniciamos curl
    $curl = curl_init();
    // Desactivamos verificación SSL
    curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, 0 );
    // Devuelve respuesta aunque sea falsa
    curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
    // Especificamo los MIME-Type que son aceptables para la respuesta.
    curl_setopt( $curl, CURLOPT_HTTPHEADER, [ 'Accept: application/json' ] );
    // Establecemos la URL
    curl_setopt( $curl, CURLOPT_URL, $url );
    // Ejecutmos curl
    $json = curl_exec( $curl );
    // Cerramos curl
    curl_close( $curl );
    $respuestas = json_decode( $json, true );
    if($respuestas == null){
      die;
    }else{
      return $respuestas;
    };    
  }

  $pages_users = array();
  $users_all = array();
  $data = array();
  $urlSearch = '?page=';
  $valor = 0;
  $count = 0;
  do{
    $data[$valor] = Get_Data( $urlSearch. ($valor+1) );
    $count = $data[$valor]['total_pages']; 
    $valor++;
  }while($valor < $count);
 
function All_Users($data){ // devuelve todos los usuarios en un array
  foreach( $data as $value){ 
    foreach($value['data'] as $value1){   
      $result[] = $value1; 
    };
  };
  return $result;
}  

function For_Page($data){ //devuelve todas las paginas en un array
  foreach( $data as $value){ 
    $result[] = $value;
  };
  return $result;
};

function Search ($page_actual,$pages){ // recive el dato pagina actual y las paginas
  if($page_actual > count($pages)){
    return "<p><strong>No more pages</p></strong>";
  }else{
    return $pages[$page_actual];
  }
};

function ShowPages($data,$page_actual,$show_select,$search_value){ //renderisa toda la informacion (data ,page-actual, show-select)
/*   var_dump($page_actual);
  var_dump($show_select);
  var_dump($search_value); */
  if( $show_select == 'true' ){ // si es true muesta todos los usuarios
    $results = All_Users($data);
  }else{
    $for_page = For_Page($data); // retorna un arra con toda la info de las paginas
    if($search_value > 0){
      $results = Search($search_value-1,$for_page);
      $search_value = '';
    }else{
      $results = Search($page_actual-1,$for_page);
    }
  }
  return $results;
}


$result = ShowPages($data,$page_actual,$show_select,$search_value);

echo json_encode($result);





/* echo json_encode($result); */



/* "<p><strong>Nombre:</strong> ' . $search_value . '<br></p>"; */
  
/*   echo('<pre>');
  print_r($pages_users);
  echo('</pre>'); */



