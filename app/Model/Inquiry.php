<?php

App::uses('AppModel', 'Model');

/**
 * Inquiry Model
 *
 * @property Category $Category
 * @property SubCategory $SubCategory
 */
class Inquiry extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';


    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Category' => array(
            'className' => 'Category',
            'foreignKey' => 'category_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'SubCategory' => array(
            'className' => 'Category',
            'foreignKey' => 'sub_category_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

}
