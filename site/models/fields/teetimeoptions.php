<?php

/**
 * @version 2.0.0
 * @package JEM
 * @copyright (C) 2013-2014 joomlaeventmanager.net
 * @copyright (C) 2005-2009 Christoph Lukes
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */
defined('JPATH_BASE') or die;

JFormHelper::loadFieldClass('list');

/**
 * Teetime Field class.
 *
 * 
 */
class JFormFieldTeetimeOptions extends JFormFieldList {

    /**
     * The form field type.
     *
     */
    protected $type = 'TeetimeOptions';

    public function getOptions() {
        $arr = explode('|',$this->value.'|||');
        $this->value = $arr[3];
        return JemHelper::GetTimeOptions($arr[0],$arr[1],$arr[2],$arr[3]);
    }
}
