<?php

App::uses('AppModel', 'Model');

/**
 * BusinessTiming Model
 *
 * @property Business $Business
 */
class BusinessTiming extends AppModel {
    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Business' => array(
            'className' => 'Business',
            'foreignKey' => 'business_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

}
