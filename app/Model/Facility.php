<?php

App::uses('AppModel', 'Model');

/**
 * Facility Model
 *
 */
class Facility extends AppModel {

    public $name = 'Facility';
    public $actsAs = array('Containable');

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'name' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Please enter name.',
            //'allowEmpty' => false,
            //'required' => true,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            /*'alphaOnly' => array(
                'rule' => '/^[a-z][a-z ]*$/i',
                'message' => 'Only Letters and Spaces are allowed.'
            ),*/
            'unique' => array(
                'rule' => array('isUniqueName'),
                'message' => 'Facility with this name already exists.',
            //'on' => 'create'
            )
        ),
    );

    /* Before isUniqueName
     * @param array $options
     * @return boolean
     */

    function isUniqueName($check) {
        $Facility = $this->find('first', array('fields' => array('Facility.id'), 'conditions' => array('Facility.name' => $check['name'])));
        
        if (!empty($Facility)) {
            return (!empty($this->data[$this->alias]['id']) && $this->data[$this->alias]['id'] == $Facility['Facility']['id']); # ? true : false;
        } else {
            return true;
        }
    }

}
