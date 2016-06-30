<?php

App::uses('AppModel', 'Model');

/**
 * Press Model
 *
 */
class Press extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';
    public $actsAs = array(
        'Upload.Upload' => array(
            'preview' => array(
                'fields' => array(
                    'dir' => 'press'
                )
            )
        )
    );
    public $validate = array(
        'preview' => array(
            #'rule' => array('isValidMimeType', array('application/pdf', 'image/png')),
            'rule' => array('isValidExtension', array('jpg', 'png', 'jpeg', 'gif', 'bmp'), array(), false),
            'message' => 'Please upload proper image.',
            'allowEmpty' => true,
            'required' => false
        ),
        'name' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Please enter name.',
            //'allowEmpty' => false,
            //'required' => true,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'source' => array(),
        'published_date' => array(),
        'description' => array(),
        'link' => array(
            'rule' => array('url'),
            'message' => 'Please enter proper website url',
        ),
    );

}
