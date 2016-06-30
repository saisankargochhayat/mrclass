<?php

App::uses('AppModel', 'Model');

/**
 * Event Model
 *
 * @property User $User
 * @property City $City
 * @property Locality $Locality
 */
class Event extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';
    public $actsAs = array(
        'Upload.Upload' => array(
            'banner' => array(
                'fields' => array(
                    'dir' => 'logo_dir'
                )
            )
        ), 'Containable'
    );
    public $validate = array(
        'banner' => array(
            'isValidExtension' => array(
                'rule' => array('isValidExtension', array('jpg', 'png', 'jpeg', 'gif', 'bmp'), array(), false),
                'message' => 'Please upload proper image.',
                'allowEmpty' => true,
                'required' => false
            )
        ),
        'user_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Please select user',
            ),
        ),
        'name' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Please enter event name',
            ),
        ),
        'city_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                'message' => 'Please select city',
            ),
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Please select city',
            ),
        ),
        'pincode' => array(
            'postal' => array(
                'rule' => array('postal'),
                'message' => 'Please enter proper postal code',
            ),
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Please enter postal code',
            ),
        ),
        'contact_person' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Please enter contact person name',
            )
        ),
        'phone' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Please enter proper phone number',
            ),
            'phone' => array(
                'rule' => array('phone'),
                'message' => 'Please enter proper phone number',
            ),
        ),
        'email' => array(
            'email' => array(
                'rule' => array('email'),
                'message' => 'Please enter proper email address',
            ),
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Please enter email address',
            ),
        ),
        'locality_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                'message' => 'Please select locality',
            ),
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Please select locality',
            ),
        ),
        'address' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Please enter event address',
            ),
        )
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

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
        ),
        'City' => array(
            'className' => 'City',
            'foreignKey' => 'city_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Locality' => array(
            'className' => 'Locality',
            'foreignKey' => 'locality_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

}
