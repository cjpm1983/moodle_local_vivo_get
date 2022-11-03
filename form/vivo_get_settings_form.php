<?php
require_once(dirname(__FILE__) . '/../../../config.php');
require_once($CFG->libdir.'/formslib.php');

/**
 * Filter form
 *
 * @author Carlos Palacios
 * @package local_vivo_get
 */
class vivo_get_settings_form extends moodleform {

    /*
    * Al finalno se uso este formulario,en su lugar se usaron settings
    */

    function definition() {
        $mform =& $this->_form;

        //$mform->addElement('header', 'filterheader', get_string('QueryHeader'));

        /*
            * @param    string     $element       Form element name
            * @param    string     $message       Message to display for invalid data
            * @param    string     $type          Rule type, use getRegisteredRules() to get types
            * @param    string     $format        (optional)Required for extra rule data
            * @param    string     $validation    (optional)Where to perform validation: "server", "client"
            * @param    boolean    $reset         Client-side validation: reset the form element to its original value if there is an error?
            * @param    boolean    $force         Force the rule to be applied, even if the target form element does not exist
        */


        $mform->addElement('static','label2','',get_string('labelQuery','local_vivo_get'));
        $mform->addElement('text','query');
        $mform->setType('query', PARAM_TEXT);
        //$mform->addRule('user',  get_string('errorRequired'),  'required',  'client',  false,  false);


        //$mform->addElement('submit','save','salvar');


        $this->add_submit_buttons($mform);
    }

    /**
     * @param MoodleQuickForm $mform
     */
    function add_submit_buttons($mform) {
        $buttons = array();
        $buttons[] = &$mform->createElement('submit', 'submitbutton', get_string('save'));
        $mform->addGroup($buttons, 'buttons', '', array(' '), false);

        $mform->registerNoSubmitButton('reset');
    }
}
