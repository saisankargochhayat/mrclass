<?php

App::uses('AppModel', 'Model');

/**
 * BusinessGallery Model
 *
 */
class BusinessFacility extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    //public $displayField = 'media';
    public $belongsTo = array(
        'Business' => array(
            'className' => 'Business',
            'foreignKey' => 'business_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Facility' => array(
            'className' => 'Facility',
            'foreignKey' => 'facility_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    /**
     * Validation rules
     *
     * @var array
     */
}
