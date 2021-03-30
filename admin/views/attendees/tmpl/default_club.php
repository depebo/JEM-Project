<?php
/**
 * @version 2.3.0
 * @package JEM
 * @copyright (C) 2013-2019 joomlaeventmanager.net
 * @copyright (C) 2005-2009 Christoph Lukes
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */
defined('_JEXEC') or die;
JHtml::_('behavior.tooltip');

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
$user		= JemFactory::getUser();
$userId		= $user->get('id');
$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
$saveTeetime = ($this->lists['order'] == 'r.tee_time');

JFactory::getDocument()->addScriptDeclaration('
	Joomla.submitbutton = function(task)
	{
		document.adminForm.task.value=task;
		if (task == "attendees.export") {
			Joomla.submitform(task, document.getElementById("adminForm"));
			document.adminForm.task.value="";
		} else {
      		Joomla.submitform(task, document.getElementById("adminForm"));
		}
	};
');
JFactory::getDocument()->addScriptDeclaration('
    function submitName(node) {
      node.parentNode.previousElementSibling.childNodes[0].checked = true;
      Joomla.submitbutton("attendees.edit");
    }
');
?>
<form action="<?php echo JRoute::_('index.php?option=com_jem&view=attendees&eventid='.$this->event->id); ?>"  method="post" name="adminForm" id="adminForm">
	<?php if (isset($this->sidebar)) : ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
	<?php endif; ?>
		<table class="adminlist" style="width:100%;">
			<tr>
				<td style="width:100%;padding:10px">
					<b><?php echo JText::_('COM_JEM_DATE').':'; ?></b>&nbsp;<?php echo $this->event->dates; ?><br />
					<b><?php echo JText::_('COM_JEM_EVENT_TITLE').':'; ?></b>&nbsp;<?php echo $this->escape($this->event->title); ?>
				</td>
			</tr>
		</table>
		<br />
		<table class="adminform">
			<tr>
				<td width="100%">
					<?php echo JText::_('COM_JEM_SEARCH').' '.$this->lists['filter']; ?>
					<input type="text" name="filter_search" id="filter_search" value="<?php echo $this->lists['search']; ?>" class="text_area" onChange="document.adminForm.submit();" />
					<button class="buttonfilter" type="submit"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
					<button class="buttonfilter" type="button" onclick="document.id('filter_search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
				</td>
				<td style="text-align:right; white-space:nowrap;">
					<?php echo JText::_('COM_JEM_STATUS').' '.$this->lists['status']; ?>
				</td>
			</tr>
		</table>
		<table class="table table-striped" id="attendeeList">
			<thead>
				<tr>
					<th width="1%" class="center"><?php echo JText::_('COM_JEM_NUM'); ?></th>
					<th width="1%" class="center"><input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" /></th>
					<th class="title"><?php echo JHtml::_('grid.sort', 'COM_JEM_NAME', 'u.name', $listDirn, $listOrder); ?></th>
					<th class="title"><?php echo JHtml::_('grid.sort', 'COM_JEM_REGDATE', 'r.uregdate', $listDirn, $listOrder); ?></th>
					<th width="1%" class="title center"><?php echo JHtml::_('grid.sort', 'COM_JEM_HEADER_WAITINGLIST_STATUS', 'r.waiting',$listDirn, $listOrder); ?></th>
					<?php if (!empty($this->jemsettings->regallowcomments)) : ?>
					<th width="10%" class="title"><?php echo JText::_('COM_JEM_COMMENT'); ?></th>
					<?php endif;?>
					<th class="title center">
						<?php
						echo JHtml::_('grid.sort', 'COM_JEM_CLUB_REGISTRATION_TEE_TIME', 'r.tee_time', $listDirn, $listOrder); 
						echo JHtml::_('grid.order',  $this->items, 'filesave.png', 'attendees.saveteetime');
						?>
					</th>
					<th width="1%" class="center"><?php echo JText::_('COM_JEM_CLUB_REGISTRATION_BUGGY'); ?></th>
					<th class="title"><?php echo JText::_('COM_JEM_CLUB_REGISTRATION_PREFERRED_START'); ?></th>
					<th width="1%" class="center"><?php echo JText::_('COM_JEM_CLUB_REGISTRATION_TWOS'); ?></th>
					<th width="1%" class="center"><?php echo JText::_('COM_JEM_CLUB_REGISTRATION_GUEST'); ?></th>
					<th class="title"><?php echo JText::_('COM_JEM_CLUB_REGISTRATION_GUEST_NAME'); ?></th>
					<th class="title center"><?php echo JText::_('COM_JEM_CLUB_REGISTRATION_GUEST_HANDICAP'); ?></th>
					<th width="1%" class="title center"><?php echo JText::_('COM_JEM_REMOVE_USER'); ?></th>
					<th width="1%" class="center nowrap"><?php echo JHtml::_('grid.sort', 'COM_JEM_ATTENDEES_REGID', 'r.id', $listDirn, $listOrder ); ?></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="20">
						<?php echo (method_exists($this->pagination, 'getPaginationLinks') ? $this->pagination->getPaginationLinks(null, array('showLimitBox' => true)) : $this->pagination->getListFooter()); ?>
					</td>
				</tr>
			</tfoot>
			<tbody>
				<?php
				$canChange = $user->authorise('core.edit.state');

				foreach ($this->items as $i => $row) :
				?>
				<tr class="row<?php echo $i % 2; ?>">
					<td class="center"><?php echo $this->pagination->getRowOffset( $i ); ?></td>
					<td class="center"><?php echo JHtml::_('grid.id', $i, $row->id); ?></td> <?php // Die ID kann man doch auch als Parameter für "submitName()" nehmen. Dann muss ich nicht erst den Baum entlang hangeln ?>
					<td><a href="#" onclick="submitName(this); return false;"><?php echo $row->name; ?></a></td>
					<td><?php if (!empty($row->uregdate)) { echo JHtml::_('date', $row->uregdate, JText::_('DATE_FORMAT_LC2')); } ?></td>
					<td class="center">
						<?php
						$status = (int)$row->status;
						if ($status === 1 && $row->waiting == 1) { $status = 2; }
						echo JHtml::_('jemhtml.toggleAttendanceStatus', $status, $i, $canChange);
						?>
					</td>
					<?php if (!empty($this->jemsettings->regallowcomments)) : ?>
					<?php $cmnt = (\Joomla\String\StringHelper::strlen($row->comment) > 20) ? (rtrim(\Joomla\String\StringHelper::substr($row->comment, 0, 18)).'&hellip;') : $row->comment; ?>
					<td><?php if (!empty($cmnt)) { echo JHtml::_('tooltip', $row->comment, null, null, $cmnt, null, null); } ?></td>
					<?php endif; ?>
					<td class="center">
						<?php 
						if ($canChange){
							$disabled = $saveTeetime ? '' : 'disabled="disabled"';
							echo JemHelper::GetTeeTimeSelect($this->event->times, $this->event->endtimes, $this->event->tee_time_interval_minutes,$row->tee_time,'tee_time[]',$this->event->interval_desc_format);
						} else {
							echo (empty($row->tee_time) || $row->tee_time == '00:00:00'?'':JHtml::_('date',$row->tee_time,JText::_('COM_JEM_CLUB_TIME_FORMAT')));
						}
						?> 
					</td>
					<td class="center">
						<?php echo ($row->buggy?JHtml::_('image','com_jem/tick.png',JText::_('COM_JEM_CLUB_REGISTRATION_BUGGY'),null,true):''); ?>
					</td>
					<td>
						<?php if ($row->preferred_start > 0) { echo JText::_('COM_JEM_CLUB_REGISTRATION_PREFERRED_START_'.$row->preferred_start);} ?>
					</td>
					<td class="center">
						<?php echo ($row->twos?JHtml::_('image','com_jem/tick.png',JText::_('COM_JEM_CLUB_REGISTRATION_TWOS'),null,true):''); ?>
					</td>
					<td class="center">
						<?php echo ($row->guest?JHtml::_('image','com_jem/tick.png',JText::_('COM_JEM_CLUB_REGISTRATION_GUEST'),null,true):''); ?>
					</td>
					<td><?php echo $this->escape($row->guest_name); ?></td>
					<td class="center"><?php if ($row->guest) { echo $this->escape(number_format($row->guest_handicap,1)); }; ?></td>
					<td class="center">
						<a href="javascript: void(0);" onclick="return listItemTask('cb<?php echo $i;?>','attendees.remove')">
							<?php echo JHtml::_('image','com_jem/publish_r.png',JText::_('COM_JEM_REMOVE'),NULL,true); ?>
						</a>
					</td>
					<td class="center">
					<?php echo $this->escape($row->id); ?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	<?php if (isset($this->sidebar)) : ?>
	</div>
	<?php endif; ?>

	<?php echo JHtml::_( 'form.token' ); ?>
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="eventid" value="<?php echo $this->event->id; ?>" />
	<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
</form>