<?php

App::uses('AppModel', 'Model');

/**
 * User Model
 *
 */
class BusinessFavorite extends AppModel {

    public $name = 'BusinessFavorite';
    
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id'
        ),
        'Business' => array(
            'className' => 'Business',
            'foreignKey' => 'business_id'
        ),
    );
}
