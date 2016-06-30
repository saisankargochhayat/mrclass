<?php

App::uses('AppModel', 'Model');

/**
 * Business Model
 *
 * @property BusinessGallery $BusinessGallery
 * @property BusinessRating $BusinessRating
 */
class Business extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';
    public $actsAs = array(
        'Upload.Upload' => array(
            'logo' => array(
                'fields' => array(
                    'dir' => 'logo_dir'
                )
            )
        ), 'Containable'
    );

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'logo' => array(
            #'rule' => array('isValidMimeType', array('application/pdf', 'image/png')),
            'isValidExtension' => array(
                'rule' => array('isValidExtension', array('jpg', 'png', 'jpeg', 'gif', 'bmp'), array(), false),
                'message' => 'Please upload proper image.',
                'allowEmpty' => true,
                'required' => false
            ),
        ),
        'name' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        /* 'unique' => array(
          'rule' => array('isUniqueName'),
          'message' => 'Business with same name exists '
          //'on'=>'update'
          ) */
        ),
        'category_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        /* 'subcategory_id' => array(
          'notBlank' => array(
          'rule' => array('notBlank'),
          //'message' => 'Your custom message here',
          //'allowEmpty' => false,
          //'required' => false,
          //'last' => false, // Stop validation after this rule
          //'on' => 'create', // Limit validation to 'create' or 'update' operations
          ),
          ), */
        'min_age_group' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'maxLength' => array(
                'rule' => array('maxLength', 2),
                'message' => 'Please enter min age below 99',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'max_age_group' => array(
            'greaterThanField' => array(
                'rule' => array('greaterThanField', 'min_age_group'),
                'message' => 'Max age group should be greater than min age group'
            ),
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'maxLength' => array(
                'rule' => array('maxLength', 2),
                'message' => 'Please select max age below 99',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'city_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'notBlank' => array(
                'rule' => array('notBlank'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'locality_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'notBlank' => array(
                'rule' => array('notBlank'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'pincode' => array(
            'postal' => array(
                'rule' => array('postal'),
                'message' => 'Please enter proper postal code',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'notBlank' => array(
                'rule' => array('notBlank'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'contact_person' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            )
        ),
        'phone' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Please enter proper phone number',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'phone' => array(
                'rule' => array('phone'),
                'message' => 'Please enter proper phone number',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'email' => array(
            'email' => array(
                'rule' => array('email'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'notBlank' => array(
                'rule' => array('notBlank'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'price' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                'message' => 'Please enter proper price',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'notBlank' => array(
                'rule' => array('notBlank'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'money' => array(
                'rule' => array('money'),
                'message' => 'Please enter proper price',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'maxLength' => array(
                'rule' => array('maxLength', 10),
                'message' => 'Please select max age below 99,99,99,999'
            )
        ),
        'website' => array(
            'rule' => array('url'),
            'message' => 'Please enter proper website url',
        ),
        'facebook' => array(
            'rule' => array('url'),
            'message' => 'Please enter proper facebook url',
        ),
        'twitter' => array(
            'rule' => array('url'),
            'message' => 'Please enter proper twitter url',
        ),
        'gplus' => array(
            'rule' => array('url'),
            'message' => 'Please enter proper google plus url',
        ),
        'youtube' => array(
            'rule' => array('url'),
            'message' => 'Please enter proper youtube url',
        )
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'BusinessLanguage' => array(
            'className' => 'BusinessLanguage',
            'foreignKey' => 'business_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => 'id,lang_id',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'BusinessGallery' => array(
            'className' => 'BusinessGallery',
            'foreignKey' => 'business_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => 'BusinessGallery.type DESC',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'BusinessRating' => array(
            'className' => 'BusinessRating',
            'foreignKey' => 'business_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'BusinessTiming' => array(
            'className' => 'BusinessTiming',
            'foreignKey' => 'business_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'BusinessKeyword' => array(
            'className' => 'BusinessKeyword',
            'foreignKey' => 'business_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'BusinessFaq' => array(
            'className' => 'BusinessFaq',
            'foreignKey' => 'business_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'BusinessFavorite' => array(
            'className' => 'BusinessFavorite',
            'foreignKey' => 'business_id',
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
            'fields' => array('User.id', 'User.name'),
            'order' => ''
        ),
        'City' => array(
            'className' => 'City',
            'foreignKey' => 'city_id',
            'conditions' => '',
            'fields' => array('City.id', 'City.name'),
            'order' => ''
        ),
        'Locality' => array(
            'className' => 'Locality',
            'foreignKey' => 'locality_id',
            'conditions' => '',
            'fields' => array('Locality.id', 'Locality.name'),
            'order' => ''
        )
    );
    public $hasAndBelongsToMany = array(
        'Facility' => array(
            'className' => 'Facility',
            'joinTable' => 'business_facilities',
            'foreignKey' => 'business_id',
            'associationForeignKey' => 'facility_id',
            'fields' => array('Facility.id', 'Facility.name', 'Facility.image', 'Facility.color')
        ),
        'Category' => array(
            'className' => 'Category',
            'joinTable' => 'business_categories',
            'foreignKey' => 'business_id',
            'associationForeignKey' => 'category_id',
            'fields' => array('Category.id', 'Category.name')
        ),
        'SubCategory' => array(
            'className' => 'Category',
            #'foreignKey' => 'subcategory_id',
            'joinTable' => 'business_subcategories',
            'foreignKey' => 'business_id',
            'associationForeignKey' => 'subcategory_id',
            'fields' => array('SubCategory.id', 'SubCategory.name'),
            'order' => array('SubCategory.name' => 'ASC')
        )
    );

    function greaterThanField($array, $field) {
        return ($this->data[$this->alias][key($array)] > $this->data[$this->alias][$field]);
    }

    /**
     * Before isUniqueName
     * @param array $options
     * @return boolean
     */
    function isUniqueName($check) {
        $name = strtolower(trim($check['name']));
        $business = $this->find('first', array('fields' => array('Business.id'), 'conditions' => array('Business.name' => $name)));

        if (!empty($business)) {
            if (!empty($this->data[$this->alias]['id']) && $this->data[$this->alias]['id'] == $business['Business']['id']) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    function beforeDelete($cascade = true) {
        #return true;
        $business_id = $this->id;
        if ($business_id > 0) {
            $Business = $this->find("first", array('conditions' => array('Business.id' => $business_id)));
            if (is_array($Business) && count($Business) > 0) {

                $folder_path = BUSINESS_LOGO_DIR . "logo" . DS . $Business['Business']['id'] . DS;
                $file_path = $folder_path . $Business['Business']['logo'];
                @unlink($file_path);
                @rmdir($folder_path);

                $select = "SELECT * FROM `business_galleries` BusinessGallery WHERE `business_id` = $business_id AND `type` = 'image' ";
                $gallery = $this->query($select);
                if (is_array($gallery) && count($gallery) > 0) {
                    foreach ($gallery as $value) {
                        $file_path = BUSINESS_GALLERY_DIR . $business_id . DS . $value['BusinessGallery']['media'];
                        $folder_path = BUSINESS_GALLERY_DIR . $business_id . DS;
                        @unlink($file_path);
                        @rmdir($folder_path);
                    }
                }

                $sql = array(
                    "DELETE FROM `business_galleries` WHERE `business_galleries`.`business_id` = $business_id",
                    "DELETE FROM `business_booking_details` WHERE `business_booking_details`.`booking_id` IN (SELECT id FROM `business_bookings` WHERE `business_id` = $business_id)",
                    "DELETE FROM `business_bookings` WHERE `business_bookings`.`business_id` = $business_id",
                    "DELETE FROM `business_facilities` WHERE `business_facilities`.`business_id` = $business_id",
                    "DELETE FROM `business_keywords` WHERE `business_keywords`.`business_id` = $business_id",
                    "DELETE FROM `business_languages` WHERE `business_languages`.`business_id` = $business_id",
                    "DELETE FROM `business_ratings` WHERE `business_ratings`.`business_id` = $business_id",
                    "DELETE FROM `business_subcategories` WHERE `business_subcategories`.`business_id` = $business_id",
                    "DELETE FROM `business_timings` WHERE `business_timings`.`business_id` = $business_id",
                    "DELETE FROM `business_views` WHERE `business_views`.`business_id` = $business_id",
                    "DELETE FROM `contacts` WHERE `contacts`.`business_id` = $business_id",
                    "DELETE FROM `business_favorites` WHERE `business_favorites`.`business_id` = $business_id"
                );
                foreach ($sql as $query) {
                    $this->query($query);
                }
            }
        }
        /*
          business_queries
         */
        return true;
    }

    function seo_url($string = '', $flag = '-', $strlen = false) {
        if (trim($string) != '') {
            if ($flag == " ") {
                $output = trim(preg_replace('/[^A-Za-z0-9.]+/i', $flag, $string), $flag);
                $output = preg_replace('/\s+/', ' ', $output);
                $output = str_replace(" ", "_", $output);
            } else {
                $output = trim(preg_replace('/[^A-Za-z0-9]+/i', $flag, $string), $flag);
            }
            if ($strlen) {
                $output = substr($output, 0, $strlen);
            }
            $output = strtolower($output);
            return $output;
        } else {
            return '';
        }
    }

}
