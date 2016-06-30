<?php

App::uses('AppModel', 'Model');

/**
 * Feedback Model
 *
 */
class Feedback extends AppModel {

    public $name = 'Feedback';
    public $actsAs = array('Captcha' => array(
            'field' => array('refer_security_code'),
            'error' => 'Incorrect captcha code value'
        )
    );

}
