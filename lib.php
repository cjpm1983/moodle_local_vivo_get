<?php
//namespace local_vivo_get\vivo_get;

 function call_api($query)
     {

    $endpoint = get_config('local_vivo_get')->serverurl;
    $username = get_config('local_vivo_get')->serveruser;
    $password = get_config('local_vivo_get')->serverpass;
    

   
    
    $endpointquery = $endpoint.'?query='.urlencode($query).'&'.'email='.urlencode($username).'&'.'password='.urlencode($password);
    //print_r($endpointquery);

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

    return json_decode($data); 
     }

function checkuser(){
    global $USER;
    $set = get_config('local_vivo_get');
    print_r($set->serverurl);
    
    print_r($USER->profile['orcid']);
}

?>