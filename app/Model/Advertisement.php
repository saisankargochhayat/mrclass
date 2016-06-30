<?php

App::uses('AppModel', 'Model');

/**
 * Advertisement Model
 *
 * @property City $City
 * @property Page $Page
 */
class Advertisement extends AppModel {

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
        'City' => array(
            'className' => 'City',
            'foreignKey' => 'city_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'AdvertisementPage' => array(
            'className' => 'AdvertisementPage',
            'foreignKey' => 'page_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    function getHomeBannerImages($pageid = '', $limit = '1', $userinfo = array(), $page = '', $page_name = '') {
        /* need to add logged in user's condition */
        $city = '';
        $user_id = !empty($userinfo['id']) ? $userinfo['id'] : 0;
        if ($userinfo['city'] > 0 && $userinfo['type'] == 2) {
            $city = "(FIND_IN_SET('" . $userinfo['city'] . "',Advertisement.city_id) OR Advertisement.city_id IS NULL OR Advertisement.city_id='')";
        }

        $CURDATE = date("Y-m-d");
        if ($pageid != '') {
            $query_params = array(
                'conditions' => array("DATE(campaign_start)<='" . $CURDATE . "'",
                    #"DATE(campaign_end)>='" . $CURDATE . "'",
                    "Advertisement.status" => 1,
                    "FLOOR(Advertisement.budget_price/Advertisement.cost_per_view) > Advertisement.views",
                    "Advertisement.page_id='$pageid'",
                    $city,
                ),
                'order' => 'rand()',
            );
            if ($limit > 0) {
                $query_params['limit'] = $limit;
            }
            if ($page > 0) {
                $query_params['page'] = $page;
            }
            $res = $this->find('all', $query_params);
            $ids = array();
            if (is_array($res) && count($res) > 0) {
                $track_sql = "INSERT INTO `advertisement_trackings` (`advertisement_id`, `user_id`, `created`,`ip`,`visited_url`,`server_agent`) VALUES ";
                foreach ($res as $val) {
                    array_push($ids, $val['Advertisement']['id']);
                    $track_sql .= "(" . $val['Advertisement']['id'] . ",{$user_id},'" . date('Y-m-d H:i:s') . "','" . $_SERVER['REMOTE_ADDR'] . "','{$page_name}','" . $_SERVER['HTTP_USER_AGENT'] . "');";
                }

                $this->query($track_sql);
                $this->query("UPDATE advertisements SET views=views+1 WHERE id IN (" . implode(",", $ids) . ")");
            }
            return $res;
        }
    }

}
