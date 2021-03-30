<li>
	<label for="tee_time" <?php echo JemOutput::tooltip(JText::_('COM_JEM_CLUB_REGISTRATION_TEE_TIME'), JText::_('COM_JEM_CLUB_REGISTRATION_TEE_TIME_DESC')); ?>>
		<?php echo JText::_('COM_JEM_CLUB_REGISTRATION_TEE_TIME'); ?>
	</label>
	<?php echo JemHelper::GetTeeTimeSelect(
		$this->row->times,
		$this->row->endtimes,
		$this->row->tee_time_interval_minutes,
		$this->row->tee_time,
		'tee_time',
		$this->row->interval_desc_format
	); ?>
</li>
<li>
	<label for="buggy" <?php echo JemOutput::tooltip(JText::_('COM_JEM_CLUB_REGISTRATION_BUGGY'), JText::_('COM_JEM_CLUB_REGISTRATION_BUGGY_DESC')); ?>>
		<?php echo JText::_('COM_JEM_CLUB_REGISTRATION_BUGGY'); ?>
	</label>
	<input type="checkbox" name="buggy" id="buggy" value="1" <?php echo ($this->row->buggy == 1 ? 'checked' : ''); ?> />
</li>
<li>
	<label for="preferred_start" <?php echo JemOutput::tooltip(JText::_('COM_JEM_CLUB_REGISTRATION_PREFERRED_START'), JText::_('COM_JEM_CLUB_REGISTRATION_PREFERRED_START_DESC')); ?>>
		<?php echo JText::_('COM_JEM_CLUB_REGISTRATION_PREFERRED_START'); ?>
	</label>
	<?php
	$options = array(
		JHtml::_('select.option', 0, JText::_('COM_JEM_CLUB_REGISTRATION_PREFERRED_START_0')),
		JHtml::_('select.option', 1, JText::_('COM_JEM_CLUB_REGISTRATION_PREFERRED_START_1')),
		JHtml::_('select.option', 2, JText::_('COM_JEM_CLUB_REGISTRATION_PREFERRED_START_2')),
	);
	echo JHtml::_('select.genericlist', $options, 'preferred_start', array('id' => 'preferred_start', 'list.select' => $this->row->preferred_start));
	?>
</li>
<li>
	<label for="twos" <?php echo JemOutput::tooltip(JText::_('COM_JEM_CLUB_REGISTRATION_TWOS'), JText::_('COM_JEM_CLUB_REGISTRATION_TWOS_DESC')); ?>>
		<?php echo JText::_('COM_JEM_CLUB_REGISTRATION_TWOS'); ?>
	</label>
	<input type="checkbox" name="twos" id="twos" value="1" <?php echo ($this->row->twos == 1 ? 'checked' : ''); ?> />
</li>
<li>
	<label for="guest" <?php echo JemOutput::tooltip(JText::_('COM_JEM_CLUB_REGISTRATION_GUEST'), JText::_('COM_JEM_CLUB_REGISTRATION_GUEST_DESC')); ?>>
		<?php echo JText::_('COM_JEM_CLUB_REGISTRATION_GUEST'); ?>
	</label>
	<input type="checkbox" name="guest" id="guest" value="1" <?php echo ($this->row->guest == 1 ? 'checked' : ''); ?> />
</li>
<li>
	<label for="guest_name" <?php echo JemOutput::tooltip(JText::_('COM_JEM_CLUB_REGISTRATION_GUEST_NAME'), JText::_('COM_JEM_CLUB_REGISTRATION_GUEST_NAME_DESC')); ?>>
		<?php echo JText::_('COM_JEM_CLUB_REGISTRATION_GUEST_NAME'); ?>
	</label>
	<input type="text" name="guest_name" id="guest_name" value="<?php echo !empty($this->row->guest_name) ? $this->row->guest_name : ''; ?>" />
</li>
<li>
	<label for="guest_handicap" <?php echo JemOutput::tooltip(JText::_('COM_JEM_CLUB_REGISTRATION_GUEST_HANDICAP'), JText::_('COM_JEM_CLUB_REGISTRATION_GUEST_HANDICAP_DESC')); ?>>
		<?php echo JText::_('COM_JEM_CLUB_REGISTRATION_GUEST_HANDICAP'); ?>
	</label>
	<input type="text" name="guest_handicap" id="guest_handicap" value="<?php echo !empty($this->row->guest_handicap) ? $this->row->guest_handicap : ''; ?>" />
</li>