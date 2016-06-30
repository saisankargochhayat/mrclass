<?php

App::uses('AppModel', 'Model');

/**
 * BusinessBooking Model
 *
 * 
 * 
 */
class BusinessBooking extends AppModel {

    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => array('BusinessBooking.user_id = User.id')
        ),
        'Business' => array(
            'className' => 'Business',
            'foreignKey' => 'business_id',
            'conditions' => array('BusinessBooking.business_id = Business.id')
        )
    );
    public $hasMany = array(
        'BusinessBookingDetail' => array(
            'className' => 'BusinessBookingDetail',
            'foreignKey' => 'booking_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
    );

}
