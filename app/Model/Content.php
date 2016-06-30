<?php

App::uses('AppModel', 'Model');

/**
 * Feedback Model
 *
 */
class Content extends AppModel {

    public $name = 'Content';
    public $actsAs = array('Captcha' => array(
            'field' => array('refer_security_code'),
            'error' => 'Incorrect captcha code value'
        )
    );

}
