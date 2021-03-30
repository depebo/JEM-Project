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
	<?php if ($this->print == 0) : ?>
	<dl class="jem-dl floattext">
		<dt class="register registration hasTooltip" data-original-title="<?php echo JText::_('COM_JEM_YOUR_REGISTRATION'); ?>"><?php echo JText::_('COM_JEM_YOUR_REGISTRATION'); ?>:</dt>
		<dd class="register registration">
			<?php
			if ($this->item->published != 1) {
				echo JText::_('COM_JEM_WRONG_STATE_FOR_REGISTER');
			} elseif (!$this->showRegForm) {
				echo JText::_('COM_JEM_NOT_ALLOWED_TO_REGISTER');
			} else {
				switch ($this->formhandler) {
				case 0:
					echo JText::_('COM_JEM_TOO_LATE_UNREGISTER');
					break;
				case 1:
					echo JText::_('COM_JEM_TOO_LATE_REGISTER');
					break;
				case 2:
					echo JText::_('COM_JEM_LOGIN_FOR_REGISTER');
					break;
				case 3:
				case 4:
					echo $this->loadTemplate('regform_club');
					break;
				}
			}
			?>
		</dd>
	</dl>
	<?php endif; ?>
</div>
