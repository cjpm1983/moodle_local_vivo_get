<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Event observer.
 *
 * @package    local_vivo_get
 * @copyright ELINF 2022 - cjpm1983@gmail.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

//namespace local_vivo_get\vivo_get;

//defined('MOODLE_INTERNAL') || die();

require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->dirroot.'/local/vivo_get/lib.php');
require_once($CFG->dirroot.'/local/vivo_get/form/vivo_get_settings_form.php');
//require_once('lib.php');
require_once($CFG->dirroot.'/user/profile/lib.php');
require_once($CFG->libdir.'/tablelib.php');
$url=new moodle_url('/local/vivo_get/index.php');

$systemcontext= context_system::instance();//get_system_context();

$download = optional_param('download', '', PARAM_ALPHA);

$tablef = new flexible_table('uniqueaid22');
$tablef->is_downloading($download, 'test',
                    'testing123');



if (isset($_GET['vivo'])){
    $vivo = $_GET['vivo'];

    $orcid = $_GET['orcid'];

    if ($vivo==1){
        $query="
        PREFIX vivo:     <http://vivoweb.org/ontology/core#>
        PREFIX foaf:     <http://xmlns.com/foaf/0.1/>
        
        select ?author
        WHERE {
        ?author a foaf:Person .
        ?author vivo:orcidId ?orcid.
        #?author vivo:eRACommonsId ?orcid.
    
            FILTER(contains(STR(?orcid), '$orcid'))
        }
        LIMIT 100
        ";
    
        $uri=call_api($query)->results->bindings[0]->author->value;
    
        header("Location: $uri");
    }
}else{
    //$orcid = '0000-0000-0000-0000';
}


if (!$tablef->is_downloading()) {
    $PAGE->set_url($url);
    $PAGE->set_context($systemcontext);
    $strtitle=get_string('title','local_vivo_get');
    $PAGE->set_title($strtitle);
    $PAGE->set_pagelayout('standard');
    $PAGE->set_heading($strtitle);

    echo $OUTPUT->header();
}
 //echo $OUTPUT->heading('Publications');
/*
 $mform = new vivo_get_settings_form();
 $mform->display();
 */
 if (isset($_GET['orcid'])){
     $orcid = $_GET['orcid'];




 }else{
    $orcid = '0000-0000-0000-0000';
 }

    
    //$query = 'SELECT ?s ?p ?o WHERE { ?s ?p <http://orcid.org/0000-0002-1282-5507> } LIMIT 10';
    //$query = 'SELECT ?s ?p ?o WHERE { <http://elinf-vivo.sceiba.org/individual/n5412> ?p ?o }';
    $query="PREFIX vivo:     <http://vivoweb.org/ontology/core#>
    PREFIX bibo:     <http://purl.org/ontology/bibo/>
    PREFIX rdfs:     <http://www.w3.org/2000/01/rdf-schema#>
    PREFIX foaf:     <http://xmlns.com/foaf/0.1/>
    SELECT ?orcid ?author_label ?academic_label ?academic_article ?year
    WHERE {
        ?author vivo:relatedBy ?authorship . 
        ?author a foaf:Person. 
        ?authorship a vivo:Authorship. 
        ?author rdfs:label ?author_label. 
        ?academic_article a bibo:AcademicArticle. 
        ?academic_article rdfs:label ?academic_label. 
        ?authorship vivo:relates ?academic_article . 
        ?author vivo:orcidId ?orcid. 
        #?author vivo:eRACommonsId ?orcid.

        ?academic_article vivo:dateTimeValue ?dtv .
        ?dtv vivo:dateTime ?dt .
        BIND(SUBSTR(str(?dt),1,4) AS ?year)
        
        FILTER(contains(STR(?orcid), '".$orcid."')) 
        #FILTER(contains(STR(?orcid), '0000-0001-5567-2638'))
    }";

    //carlos orcid '0000-0002-1282-5507'
    //orcid belllo '0000-0001-5567-2638'
    //echo "Current query = $query <br><br><br>";
$r=array();
$columnas=array();

///******************REMOVE THIS***************************** */
if (!$tablef->is_downloading()) {
   print_r(call_api($query));




 try {

   
    
    //echo "<br><br>";
    //print_r(call_api($query)->results->bindings[0]->orcid->value);
    //print_r(call_api($query)->results->bindings);
    $r = call_api($query);
    //$temp = $r->results->bindings;
    
    foreach ($r->results->bindings as $key => $value) {
        //echo "<br>";
        //echo "<a target='_blank' href='".$bodytag = str_replace("http:", "https:", $value->academic_article->value)."'><i class='icon fa fa-graduation-cap fa-fw' aria-hidden='true'></i>".$value->academic_label->value." - ".$value->year->value."</a>";
        
    }
    /*
    if (!$tablef->is_downloading()) {
        echo "<b>helo world</b><br>";
     }
    */

    
    //$endpointquery = $query.'&'.'email='.$username.'&'.'password='.$password;
    
    //$data=sparqlQuery($query,$endpoint,$username,$password);
    //print "Retrieved data:\n" . json_encode($data);
    


    //die();
    
 } catch (\Throwable $th) {
    throw $th;
 }

} 


if (!$tablef->is_downloading()){
            $tablef->define_baseurl($url);
            $tablef->define_columns(array('article','year'));
            $tablef->define_headers(array(get_string('article','local_vivo_get'),get_string('year','local_vivo_get')));

            $tablef->setup();
            
            //print_r($r->results->bindings[0]);
            foreach($r->results->bindings as $re){
                    //$columnas = getCategorias($r->id, $r->category);
                    
                    //array_push($columnas,$re->academic_article->value,$re->academic_label->value);  
                    //array_push($columnas,"lolo","fufu");
        
                    $tablef->add_data(array("<a target='_blank' href='".$bodytag = str_replace("http:", "https:", $re->academic_article->value)."'><i class='icon fa fa-graduation-cap fa-fw' aria-hidden='true'></i>".$re->academic_label->value."</a>",$re->year->value));//$columnas);

                }
                //$tablef->add_data($columnas);

                
                $tablef->set_control_variables(
                    array(
                        TABLE_VAR_SORT=>'ssort',
                        TABLE_VAR_IFIRST=>'sifirst',
                        TABLE_VAR_ILAST=>'silast',
                        TABLE_VAR_PAGE=>'sPAGE',
                    )
                );
                
                
            $tablef->finish_output();

            }


if (!$tablef->is_downloading()){
    echo $OUTPUT->footer();
}

?>
