<?php
App::uses('AppModel', 'Model');
/**
 * Question Model
 *
 * @property QuestionCategory $QuestionCategory
 */
class Question extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'QuestionCategory' => array(
			'className' => 'QuestionCategory',
			'foreignKey' => 'question_category_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
