<?php
/**
 * @version 2.3.0
 * @package JEM
 * @copyright (C) 2013-2019 joomlaeventmanager.net
 * @copyright (C) 2005-2009 Christoph Lukes
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *
 * @todo add check if CB does exists and if so perform action
 */

defined('_JEXEC') or die;

$linkreg = 'index.php?option=com_jem&amp;view=attendees&amp;id='.$this->item->id.($this->itemid ? '&Itemid='.$this->itemid : '');
?>

<div class="register">
	<dl class="jem-dl floattext">
	<?php $maxplaces = (int)$this->item->maxplaces; ?>
	<?php $booked    = (int)$this->item->booked; ?>
	<?php if ($maxplaces > 0) : ?>
		<dt class="register max-places hasTooltip" data-original-title="<?php echo JText::_('COM_JEM_MAX_PLACES'); ?>"><?php echo JText::_('COM_JEM_MAX_PLACES'); ?>:</dt>
		<dd class="register max-places"><?php echo $maxplaces; ?></dd>
	<?php endif; ?>
	<?php if (($maxplaces > 0) || ($booked > 0)) : ?>
		<dt class="register booked-places hasTooltip" data-original-title="<?php echo JText::_('COM_JEM_BOOKED_PLACES'); ?>"><?php echo JText::_('COM_JEM_BOOKED_PLACES'); ?>:</dt>
		<dd class="register booked-places">
		<?php if (empty($this->permissions->canEditAttendees)) : ?>
			<?php echo $booked; ?>
		<?php else : ?>
			<a href="<?php echo $linkreg; ?>" title="<?php echo JText::_('COM_JEM_MYEVENT_MANAGEATTENDEES'); ?>"><?php echo $this->item->booked; ?> <i class="fa fa-external-link" aria-hidden="true"></i></a>
		<?php endif; ?>
		</dd>
	<?php endif; ?>
	<?php if ($maxplaces > 0) : ?>
		<dt class="register available-places hasTooltip" data-original-title="<?php echo JText::_('COM_JEM_AVAILABLE_PLACES'); ?>"><?php echo JText::_('COM_JEM_AVAILABLE_PLACES'); ?>:</dt>
		<dd class="register available-places"><?php echo ($maxplaces - $booked); ?></dd>
	<?php endif; ?>
	<?php
		// only set style info if users already have registered and user is allowed to see it
		if ($this->registers) :
	?>
		<dt class="register registered-users hasTooltip" data-original-title="<?php echo JText::_('COM_JEM_REGISTERED_USERS'); ?>"><?php echo JText::_('COM_JEM_REGISTERED_USERS'); ?>:</dt>
		<dd class="register registered-users">
			<ul class="fa-ul jem-registered-list">
			<?php
			if ($this->settings->get('event_comunsolution', '0') == 1) :
				if ($this->settings->get('event_comunoption', '0') == 1) :
					//$cparams = JComponentHelper::getParams('com_media');
					//$imgpath = $cparams->get('image_path'); // mostly 'images'
					$imgpath = 'images'; // CB does NOT respect path set in Media Manager, so we have to ignore this too
					if (JFile::exists(JPATH_ROOT . '/components/com_comprofiler/plugin/templates/default/images/avatar/tnnophoto_n.png')) {
						$noimg = 'components/com_comprofiler/plugin/templates/default/images/avatar/tnnophoto_n.png';
					} elseif (JFile::exists(JPATH_ROOT . '/components/com_comprofiler/images/english/tnnophoto.jpg')) {
						$noimg = 'components/com_comprofiler/images/english/tnnophoto.jpg';
					} else {
						$noimg = '';
					}
				endif;
			endif;

      if(!function_exists("jem_getStatusIcon")) {
        if ($this->settings->get('event_show_more_attendeedetails', '0')) {
          function jem_getStatusIcon($status) {
            switch($status) {
              case 2:  // waiting list
                return ' <i class="fa fa-li fa-exclamation-circle jem-attendance-status-fa-exclamation-circle hasTooltip" title="'.JText::_('COM_JEM_ATTENDEES_ON_WAITINGLIST').'"></i>';
                break;
              case 1:  // attending
                return ' <i class="fa fa-li fa-check-circle jem-attendance-status-fa-check-circle hasTooltip" title="'.JText::_('COM_JEM_ATTENDEES_ATTENDING').'"></i>';
                break;
              case 0:  // invited
                return ' <i class="fa fa-li fa-question-circle jem-attendance-status-fa-question-circle hasTooltip" title="'.JText::_('COM_JEM_ATTENDEES_INVITED').'"></i>';
                break;
              case -1: // not attending
                return ' <i class="fa fa-li fa-times-circle jem-attendance-status-fa-times-circle hasTooltip" title="'.JText::_('COM_JEM_ATTENDEES_NOT_ATTENDING').'"></i>';
                break;
              default:
                return $status;
            }
          }
        } else {
          function jem_getStatusIcon($status) {
            return ' <i class="fa fa-li fa-check-circle jem-attendance-status-fa-check-circle hasTooltip" title="'.JText::_('COM_JEM_ATTENDEES_ATTENDING').'"></i>';
          }
        }
      }
      
			// loop through attendees
      $registers_array = array();
      if ($this->settings->get('event_show_more_attendeedetails', '0')) { // Show attendees, on waitinglist, invited and not attending.
        $registers_array = array_merge($this->regs['attending'], $this->regs['waiting'], $this->regs['invited'], $this->regs['not_attending']);
      } else {
        $registers_array = $this->registers;
      }
      foreach ($registers_array as $register) :
        echo '<li class="jem-registered-user">' . jem_getStatusIcon($register->status);
        $text = '';
				// is a plugin catching this ?
				if ($res = $this->dispatcher->trigger('onAttendeeDisplay', array($register->uid, &$text))) :
					echo $text;
				endif;
				// if CB
				if ($this->settings->get('event_comunsolution', '0') == 1) :
					if ($this->settings->get('event_comunoption', '0') == 1) :
						// User has avatar
						if (!empty($register->avatar)) :
							if (JFile::exists(JPATH_ROOT . '/' . $imgpath . '/comprofiler/tn' . $register->avatar)) {
								$useravatar = JHtml::image($imgpath . '/comprofiler/tn' . $register->avatar, $register->name);
							} elseif (JFile::exists(JPATH_ROOT . '/' . $imgpath . '/comprofiler/' . $register->avatar)) {
								$useravatar = JHtml::image($imgpath . '/comprofiler/' . $register->avatar, $register->name);
							} else {
								$useravatar = empty($noimg) ? '' : JHtml::image($noimg, $register->name);
							}
							echo '<a href="' . JRoute::_('index.php?option=com_comprofiler&task=userProfile&user=' . $register->uid) . '" title = "' . JText::_('COM_JEM_SHOW_USER_PROFILE') . '">' . $useravatar . ' <span class="username">' . $register->name . '</span></a>';

						// User has no avatar
						else :
							$nouseravatar = empty($noimg) ? '' : JHtml::image($noimg, $register->name);
							echo '<a href="' . JRoute::_('index.php?option=com_comprofiler&task=userProfile&user=' . $register->uid) . '" title = "' . JText::_('COM_JEM_SHOW_USER_PROFILE') .'">' . $nouseravatar . ' <span class="username">' . $register->name . '</span></a>';
						endif;
					else :
						// only show the username with link to profile
						echo '<span class="username"><a href="' . JRoute::_('index.php?option=com_comprofiler&amp;task=userProfile&amp;user=' . $register->uid) . '">' . $register->name . '</a></span>';
					endif;
				// if CB end - if not CB than only name
				else :
					// no communitycomponent is set so only show the username
					echo '<span class="username">' . $register->name . '</span>';
				endif;
        
        echo '</li>';
			// end loop through attendees
			endforeach;
			?>
			</ul>
		</dd>
	<?php endif; ?>
	</dl>
</div>
