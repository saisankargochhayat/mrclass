<?php

App::uses('AppModel', 'Model');

/**
 * BusinessRating Model
 *
 */
class BusinessRating extends AppModel {

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
        ),
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    public $hasMany = array(
        'BusinessRatingReply' => array(
            'className' => 'BusinessRatingReply',
            'foreignKey' => 'rating_id'
        )
    );

}
