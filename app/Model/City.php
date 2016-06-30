<?php

App::uses('AppModel', 'Model');

/**
 * City Model
 *
 */
class City extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';
    public $hasMany = array(
        'Locality' => array(
            'className' => 'Locality',
            'foreignKey' => 'city_id',
            'order' => 'Locality.created ASC'
        )
    );
    public $belongsTo = array(
        'State' => array(
            'className' => 'State',
            'foreignKey' => 'state',
            'conditions' => array('City.state=State.id')
        ),
        'Dist' => array(
            'className' => 'Dist',
            'foreignKey' => 'dist',
            'conditions' => array('City.dist = Dist.id')
        )
    );

}
