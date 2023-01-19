<?php
//namespace local_vivo_get\vivo_get;

 function call_api($query)
     {

    $endpoint = get_config('local_vivo_get')->serverurl;
    $username = get_config('local_vivo_get')->serveruser;
    $password = get_config('local_vivo_get')->serverpass;
    

   
    
    $endpointquery = $endpoint.'?query='.urlencode($query).'&'.'email='.urlencode($username).'&'.'password='.urlencode($password);
    print_r($endpointquery);

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
    
    print_r($data);

    return json_decode($data); 
     }

function checkuser(){
    global $USER;
    $set = get_config('local_vivo_get');
    print_r($set->serverurl);
    
    print_r($USER->profile['orcid']);
}

function local_vivo_get_myprofile_navigation(core_user\output\myprofile\tree $tree, $user, $iscurrentuser, $course){
    $category = new core_user\output\myprofile\category('research', 'Research', null);
    $tree->add_category($category);
    
    $url = new moodle_url('/mod/forum/user.php', array('id' => 7, 'mode' => 'discussions'));
    $string = "Cadenita con enlacito";
    $node = new core_user\output\myprofile\node('research', 'cosita', $string, null, $url);  
    
    $tree->add_node($node);
}

?>