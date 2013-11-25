<?php
/**
 * @version 1.9.5
 * @package JEM
 * @copyright (C) 2013-2013 joomlaeventmanager.net
 * @copyright (C) 2005-2009 Christoph Lukes
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('_JEXEC') or die;
?>

<div class="register">
<dl class="floattext">

<?php if ($this->item->maxplaces > 0 ) {?>
<dt class="register"><?php echo JText::_ ( 'COM_JEM_MAX_PLACES' ) . ':';?></dt>
<dd class="register"><?php echo $this->item->maxplaces; ?></dd>

<dt class="register"><?php echo JText::_ ( 'COM_JEM_BOOKED_PLACES' ) . ':';?></dt>
<dd class="register"><?php echo $this->item->booked; ?></dd>

<?php } ?>

<?php if ($this->item->maxplaces > 0): ?>
<dt class="register"><?php echo JText::_ ( 'COM_JEM_AVAILABLE_PLACES' ) . ':';?></dt>
<dd>
<?php echo ($this->item->maxplaces-$this->item->booked); ?>
</dd>

	<?php
	endif;
	?>

	<dt class="register"><?php echo JText::_( 'COM_JEM_REGISTERED_USERS' ).':'; ?></dt>
	<dd class="register">

<?php
//only set style info if users already have registered and user is allowed to see it
if ($this->registers) :
?>
	<ul class="user floattext">

<?php
//loop through attendees
foreach ($this->registers as $register) :

	$text = '';
	// is a plugin catching this ?
	//TODO: remove markup..the plugin should handle this to improve flexibility
	if ($res = $this->dispatcher->trigger('onAttendeeDisplay', array( $register->uid, &$text ))) :

		echo '<li>'.$text.'</li>';
	endif;

	//if CB
	if ($this->jemsettings->comunsolution == 1) :

		if ($this->jemsettings->comunoption == 1) :
			//User has avatar
			if(!empty($register->avatar)) :


				$avatarname = $register->avatar;

				if (strpos($avatarname,'gallery/') !== false) {
    				$useravatar = JHTML::image('components/com_comprofiler/images/'.$register->avatar,$register->name);
				}
				else
				{
					$useravatar = JHTML::image('images/comprofiler/'.'tn'.$register->avatar,$register->name);
				}

				echo "<li><a href='".JRoute::_('index.php?option=com_comprofiler&task=userProfile&user='.$register->uid )."'>".$useravatar."<span class='username'>".$register->name."</span></a></li>";

			//User has no avatar
			else :
				   $nouseravatar = JHTML::image('components/com_comprofiler/images/english/tnnophoto.jpg',$register->name);
				echo "<li><a href='".JRoute::_( 'index.php?option=com_comprofiler&task=userProfile&user='.$register->uid )."'>".$nouseravatar."<span class='username'>".$register->name."</span></a></li>";
			endif;
		endif;

		//only show the username with link to profile
		if ($this->jemsettings->comunoption == 0) :
			echo "<li><span class='username'><a href='".JRoute::_( 'index.php?option=com_comprofiler&amp;task=userProfile&amp;user='.$register->uid )."'>".$register->name." </a></span></li>";
		endif;

	//if CB end - if not CB than only name
	endif;

	//no communitycomponent is set so only show the username
	if ($this->jemsettings->comunsolution == 0) :
		echo "<li><span class='username'>".$register->name."</span></li>";
	endif;

//end loop through attendees
endforeach;
?>

	</ul>
	</dd>
</dl>
<?php endif; ?>

<?php

if ($this->print == 0) {
switch ($this->formhandler) {

	case 1:
		echo JText::_( 'COM_JEM_TOO_LATE_REGISTER' );
	break;

	case 2:
		echo JText::_( 'COM_JEM_LOGIN_FOR_REGISTER' );
	break;

	case 3:
		echo $this->loadTemplate('unregform');
	break;

	case 4:
		echo $this->loadTemplate('regform');
	break;
}
}
?>
</div>
