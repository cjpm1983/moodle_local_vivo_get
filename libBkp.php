<?php
//namespace local_vivo_get\vivo_get;



function sparqlQuery($query, $baseURL,$email,$password, $format="application/json")

{
  $params=array(
      //"default-graph" =>  "",
      //"should-sponge" =>  "soft",
      "query" =>  $query,
      "email" => $email,
      "password" => $password,
      //"debug" =>  "on",
      //"timeout" =>  "",
      "format" =>  $format,
      //"save" =>  "display",
      //"fname" =>  ""
  );

  $querypart="?";	
  //$header = "-H 'Accept: application/sparql-results+json'";
   
  foreach($params as $name => $value) 
{
      $querypart=$querypart . $name . '=' . urlencode($value) . "&";
  }
  
  $sparqlURL=$baseURL . $querypart ;//. urlencode($header);
  
  //return json_decode(file_get_contents($sparqlURL));
    
};




 function call_api($query)
     {

    $endpoint = get_config('local_vivo_get')->serverurl;
    $username = get_config('local_vivo_get')->serveruser;
    $password = get_config('local_vivo_get')->serverpass;
    
   
    $endpointquery = $endpoint.'?query='.urlencode($query).'&'.'email='.urlencode($username).'&'.'password='.urlencode($password);

    //$endpointquery = $endpoint.'?query='.urlencode($query);
    //print_r($endpointquery);

    //$endpointquery = "-d 'email=epriveron@uclv.cu' -d 'password=Vivo2022*' -d 'query=SELECT ?s ?p ?o WHERE {?s ?p ?o} LIMIT 5' 'https://elinf-vivo.sceiba.org/api/sparqlQuery'";

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $endpointquery);
    curl_setopt($ch, CURLOPT_VERBOSE, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/sparql-results+json'));
    //0curl_setopt($ch, CURLOPT_POST, 1);
    //curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
    //curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    //curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string );
    $data = curl_exec($ch);
    curl_close($ch);
    
    //print_r($data);
    //print_r('thats it');
    //die();

    return json_decode($data); 
     }

function checkuser(){
    global $USER;
    $set = get_config('local_vivo_get');
    print_r($set->serverurl);
    
    print_r($USER->profile['orcid']);
    //die();
}



function local_vivo_get_myprofile_navigation(core_user\output\myprofile\tree $tree, $user, $iscurrentuser, $course){
    global $DB;
    global $USER;

    //creating category
    $category = new core_user\output\myprofile\category('research', 'Research', null);
    $tree->add_category($category);
    
    //getting orcid
    $userObj = $DB->get_record('user',array('id'=>$user->id));

    //get the id of the orcid custom field
    $registro_user_info_fields = $DB->get_record_sql('SELECT * FROM {user_info_field} WHERE shortname = :param1', array('param1'=>'orcid') );
    
    $parametros1=array('param1'=>$user->id,'param2'=>$registro_user_info_fields->id) ;
        
    $registro_user_info_data = $DB->get_record_sql('SELECT * FROM {user_info_data} WHERE userid=:param1 AND fieldid=:param2',$parametros1 );
    //$registro_user_info_data = $DB->get_record_sql('SELECT * FROM {user_info_data}');
     
    $orcid=$registro_user_info_data->data;



    //building new profile node Categoria Científica

    $query="PREFIX vivo:     <http://vivoweb.org/ontology/core#>
    PREFIX rdfs:     <http://www.w3.org/2000/01/rdf-schema#>
    PREFIX foaf:     <http://xmlns.com/foaf/0.1/>
    PREFIX ciecuba:  <https://ciecuba.cris.cu/>
    
    SELECT ?cat_academicc ?cat_cientific 
    WHERE {
    ?author a foaf:Person.
    ?author vivo:orcidId ?orcid.
     
    ?author ciecuba:ostentalacategoriade ?category_cientific.
    ?category_cientific rdfs:label ?cat_cientific.
     
    ?author ciecuba:ostenta ?category_academicc.
    ?category_academicc rdfs:label ?cat_academicc.
     
         
    FILTER(contains(STR(?orcid), '$orcid'))
    }";

    //carlos orcid '0000-0002-1282-5507'
    //orcid belllo '0000-0001-5567-2638'
    //echo "Current query = $query <br><br><br>";

    try {
  
        
        echo "<br><br>";
        //print_r(call_api($query)->results->bindings[0]->orcid->value);
        print_r(call_api($query));
        die();
        $r = call_api($query);
        $catac=$r->results->bindings[0]->cat_academicc->value;
        $catcient=$r->results->bindings[0]->cat_cientific->value;

        
    } catch (\Throwable $th) {
        throw $th;
    }


    if ($catac!="") {
        $string = "<b>Categoria Académica:</b> $catac";
        $node = new core_user\output\myprofile\node('research', 'researchd', $string, null, null);  
        }else{
        $string = "No se ha encontrado la categoría académica";
        $node = new core_user\output\myprofile\node('research', 'researchcd', $string, null, null);  
    }
    $tree->add_node($node);

    if ($catcient!="") {
        $string = "<b>Categoria Científica:</b> $catcient";
        $node = new core_user\output\myprofile\node('research', 'researche', $string, null, null);  
        }else{
        $string = "No se ha encontrado la categoría científica";
        $node = new core_user\output\myprofile\node('research', 'researchce', $string, null, null);  
    }
    $tree->add_node($node);


    // if orcid exists we get metadata from vivo Articles
    if ($orcid!="") {


        //building new profile node
        
        $url = new moodle_url('/local/vivo_get/index.php', array('orcid' => $orcid));
        $string = "<i class='icon fa fa-graduation-cap fa-fw' aria-hidden='true'></i> Academics Articles";
        $node = new core_user\output\myprofile\node('research', 'research', $string, null, $url);  
        }else{
        $string = "ORCID must be provided in order to show research";
        $node = new core_user\output\myprofile\node('research', 'research', $string, null, null);  
    }
    $tree->add_node($node);
    

    //print("elid del orcid es".$registro_user_info_fields);    
    //print_r($userObj);
    //print_r($DB);
    //die();

    //print_r($user->profile['orcid']);
    //die();
    //checkuser();

    //TODO hacer la consulta e vivo
    /**
     * curl -i -d 'email=epriveron@uclv.cu' -d 'password=Vivo2022*' -d 'query=SELECT ?s ?p ?o WHERE { ?s ?p <http://orcid.org/0000-0001-5567-2638>}' -H 'Accept: application/sparql-results+json' 'https://elinf-vivo.sceiba.org/api/sparqlQuery'
     * 
     * tomas del response
     * "s": { "type": "uri" , "value": "http://elinf-vivo.sceiba.org/individual/n6203" 
     * limpias y cambias http: por https:
     * 
     { 
     "head": {
      "vars": [ "s" , "p" , "o" ]
            } ,
            "results": {
                "bindings": [
                { 
                    "s": { "type": "uri" , "value": "http://elinf-vivo.sceiba.org/individual/n6203" } ,
                    "p": { "type": "uri" , "value": "http://vivoweb.org/ontology/core#orcidId" }
                }
                ]
            }
            }

     */

}

?>