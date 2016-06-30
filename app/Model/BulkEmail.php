<?php

App::uses('AppModel', 'Model');

/**
 * BusinessGallery Model
 *
 */
class BulkEmail extends AppModel {

	public $hasMany = array(
        'BulkEmailReceiver' => array(
            'className' => 'BulkEmailReceiver',
            'foreignKey' => 'bulk_email_id',
            'dependent'=>true,
            'exclusive'=>true
        ),
        'BulkEmailAttachment' => array(
            'className' => 'BulkEmailAttachment',
            'foreignKey' => 'bulk_email_id',
            'dependent'=>true,
            'exclusive'=>true
        )
    );
}