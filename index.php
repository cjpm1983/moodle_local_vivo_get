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



$PAGE->set_url($url);
$PAGE->set_context($systemcontext);
$strtitle=get_string('title','local_vivo_get');
$PAGE->set_title($strtitle);
$PAGE->set_pagelayout('standard');
$PAGE->set_heading($strtitle);

 echo $OUTPUT->header();
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

 /*
 $query="";
    if ($fromform = $mform->get_data()) {

        if ($fromform->query) {

            $query = $fromform->query;
        }
    } else {
        $query = 'SELECT ?s ?p ?o WHERE {?s ?p ?o} LIMIT 5';
        
        //primeropidopor orcid o campo vinculante con moodle
        
        //luego pido los datos delindividuo
        //$query = 'SELECT ?s ?p ?o WHERE { <http://elinf-vivo.sceiba.org/individual/n1462> ?p ?o }';
    }
    */
    
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
        ?academic_article vivo:dateTimeValue ?dtv .
        ?dtv vivo:dateTime ?dt .
        BIND(SUBSTR(str(?dt),1,4) AS ?year)
        FILTER(contains(STR(?orcid), '".$orcid."')) 
    }";

    //carlos orcid '0000-0002-1282-5507'
    //orcid belllo '0000-0001-5567-2638'
 //echo "Current query = $query <br><br><br>";
$r=null;
$columnas;
 try {

   
    
    echo "<br><br>";
    //print_r(call_api($query)->results->bindings[0]->orcid->value);
    //print_r(call_api($query)->results->bindings);
    $r = call_api($query);
    foreach ($r->results->bindings as $key => $value) {
        echo "<br>";
        echo "<a target='_blank' href='".$bodytag = str_replace("http:", "https:", $value->academic_article->value)."'><i class='icon fa fa-graduation-cap fa-fw' aria-hidden='true'></i>".$value->academic_label->value." - ".$value->year->value."</a>";
        
    }



        
        //echo "</div>";
    //}

//}




    
    //$endpointquery = $query.'&'.'email='.$username.'&'.'password='.$password;
    
    //$data=sparqlQuery($query,$endpoint,$username,$password);
    //print "Retrieved data:\n" . json_encode($data);
    


    //die();
    
 } catch (\Throwable $th) {
    throw $th;
 }
 
$tablef = new flexible_table('uniqueaid22');

if (!$tablef->is_downloading()){
            $tablef->define_baseurl($url);
            $tablef->define_columns(array('article','year'));
            $tablef->define_headers(array('Article','Year'));

            $tablef->setup();
            //Hay que ver elarbol de categorias mayor y en dependencia poner columnas a la tabla
            //$MayorArbolSize = 0;
            //print_r($r->results->bindings[0]);
            array_push($columnas,"lolo","fufu");
            foreach($r->results->bindings as $re){
                    //$columnas = getCategorias($r->id, $r->category);
                    
                    //array_push($columnas,$re->academic_article->value,$re->academic_label->value);  
                    array_push($columnas,"lolo","fufu");
        
                    $tablef->add_data(array($re->academic_article->value,$re->academic_label->value));//$columnas);

                    /*
                    if (count($columnas)>$MayorArbolSize){
                        $MayorArbolSize=count($columnas);
                        
                    }*/
                    // echo $r->nombre.", ";
                }
                //$tablef->add_data($columnas);

                /*
                $tablef->set_control_variables(
                    array(
                        TABLE_VAR_SORT=>'ssort',
                        TABLE_VAR_IFIRST=>'sifirst',
                        TABLE_VAR_ILAST=>'silast',
                        TABLE_VAR_PAGE=>'sPAGE',
                    )
                );
                */
                

            // $tablef->out(40,true);

            //$tablef->print_html();
            $tablef->finish_output();

            }


 if (!$tablef->is_downloading()){
    echo $OUTPUT->footer();
}

//echo $OUTPUT->footer();

?>
