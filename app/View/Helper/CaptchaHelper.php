<?php

/**
 * Helper for Showing the use of Captcha*
 * @author     Arvind Kumar
 * @link       http://www.devarticles.in/
 * @copyright  Copyright © 2014 http://www.devarticles.in/
 * @version 2.5 - Tested OK in Cakephp 2.5.4
 */
class CaptchaHelper extends AppHelper {

    /**
     * helpers
     *
     * @var array
     */
    public $helpers = array('Html', 'Form');

    /**
     * Constructor
     *
     * ### Settings:
     *
     * - Get settings set from Component.
     *
     * @param View $View the view object the helper is attached to.
     * @param array $settings Settings array Settings array
     */
    public function __construct(View $View, $settings = array()) {
        parent::__construct($View, $settings);
    }

    function render($settings = array()) {
        $this->settings = array_merge($this->settings, (array) $settings);
        $this->settings['reload_txt'] = isset($this->settings['reload_txt']) ? __($this->settings['reload_txt']) : __('Can\'t read? Reload');
        #$this->settings['clabel'] = isset($this->settings['clabel']) ? __($this->settings['clabel']) : __('Enter security code shown above:');
        $this->settings['clabel'] = __("Please enter the verification code as it is shown.");
        #$this->settings['mlabel'] = isset($this->settings['mlabel']) ? __($this->settings['mlabel']) : __('<p>Answer Simple Math</p>');
        $this->settings['mlabel'] = __('Answer Simple Math');
        $this->settings['attr'] = isset($this->settings['attr']) ? $this->settings['attr'] : array();

        $controller = strtolower($this->settings['controller']);
        $action = $this->settings['action'];
        $qstring = array(
            'type' => $this->settings['type'],
            'model' => $this->settings['model'],
            'field' => $this->settings['field']
        );

        switch ($this->settings['type']):
            case 'image':
                $qstring = array_merge($qstring, array(
                    'width' => $this->settings['width'],
                    'height' => $this->settings['height'],
                    'theme' => $this->settings['theme'],
                    'length' => $this->settings['length'],
                ));

                $text_params = array_merge(array('placeholder' => 'Enter captcha', 'autocomplete' => 'off', 'label' => false, 'value' => '', 
                    'after' => "<label>" . $this->settings['clabel'] . "</label>"), $this->settings['attr']);
                echo $this->Form->input($this->settings['model'] . '.' . $this->settings['field'], $text_params);
                
                echo $this->Html->image($this->Html->url(array('controller' => $controller, 'action' => $action, '?' => $qstring), true), array('vspace' => 2, 'id' => 'captcha_img'));
                echo $this->Html->link($this->settings['reload_txt'], 'javascript:void(0)', array('class' => 'creload', 'escape' => false,
                    'onclick' => 'captcha_refresh();'));
                break;
            case 'math':
                $qstring = array_merge($qstring, array('type' => 'math'));
                if (isset($this->settings['stringOperation'])) {
                    echo $this->settings['mlabel'] . $this->settings['stringOperation'] . ' = ?';
                } else {
                    echo $this->requestAction(array('controller' => $controller, 'action' => $action, '?' => $qstring));
                }
                $text_params = array_merge(array('placeholder' => $this->settings['mlabel'], 'autocomplete' => 'off', 
                    'div' => false, 'label' => false, 'value' => '', ),
                    $this->settings['attr']);
                echo $this->Form->input($this->settings['model'] . '.' . $this->settings['field'], $text_params);
                        #array_merge(array('autocomplete' => 'off', 'label' => false, 'class' => 'repatch_val'), $this->settings['attr']);
                break;
        endswitch;
    }

}
