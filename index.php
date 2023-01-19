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

$url=new moodle_url('/local/vivo_get/index.php');

$systemcontext= context_system::instance();//get_system_context();



$PAGE->set_url($url);
$PAGE->set_context($systemcontext);
$strtitle=get_string('title','local_vivo_get');
$PAGE->set_title($strtitle);
$PAGE->set_pagelayout('standard');
$PAGE->set_heading($strtitle);

 echo $OUTPUT->header();
 echo $OUTPUT->heading(get_string('title','local_vivo_get'));

 $mform = new vivo_get_settings_form();
 $mform->display();

$url = new moodle_url('/mod/forum/user.php', array('id' => 3, 'mode' => 'discussions'));
$string = "Nuevo";
$node = new core_user\output\myprofile\node('miscellaneous', 'forumdiscussionss', $string, null, $url);

 $query="";
    if ($fromform = $mform->get_data()) {

        if ($fromform->query) {

            $query = $fromform->query;
        }
    } else {
        $query = 'SELECT ?s ?p ?o WHERE {?s ?p ?o} LIMIT 5';
        
        //primeropidopor orcid o campo vinculante con moodle
        //$query = 'SELECT ?s ?p ?o WHERE { ?s ?p <http://orcid.org/0000-0002-1282-5507> } LIMIT 10';
        //luego pido los datos delindividuo
        //$query = 'SELECT ?s ?p ?o WHERE { <http://elinf-vivo.sceiba.org/individual/n1462> ?p ?o }';
    }
    
 //$query = 'SELECT ?s ?p ?o WHERE {?s ?p ?o} LIMIT 5';
 echo "Current query = $query <br><br><br>";
 try {
    
    print_r(call_api($query));
    //print_r("cañandonga");
    die();
    //print_r(call_api($query)->results->bindings[0]);
 } catch (\Throwable $th) {
    throw $th;
 }
 


echo $OUTPUT->footer();

?>
