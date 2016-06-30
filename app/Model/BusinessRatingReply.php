<?php

App::uses('AppModel', 'Model');

/**
 * BusinessRating Model
 *
 */
class BusinessRatingReply extends AppModel {

    public $virtualFields = array(
        'user_name' => '(SELECT User.name FROM users as User WHERE BusinessRatingReply.user_id=User.id)',
        'user_photo' => '(SELECT User.photo FROM users as User WHERE BusinessRatingReply.user_id=User.id)',
    );

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    

}
