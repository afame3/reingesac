<?php
/*------------------------------------------------------------------------
# mod_simplecontact - Simple Contact
# ------------------------------------------------------------------------
# author    Vsmart Extensions
# copyright Copyright (C) 2010 www.vsmart-extensions.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.vsmart-extensions.com
# Technical Support:  Forum - http://www.vsmart-extensions.com
-------------------------------------------------------------------------*/

defined('_JEXEC') or die;
require_once __DIR__ . '/helper.php';

JHtml::_('behavior.formvalidation');

$preContactText = $params->get('preContactText', '');
$submit_text = $params->get('submit_text', 'Send us a mail');
$name_text = $params->get('name_text', 'Your Name');
$email_text = $params->get('email_text', 'Your Email');
$phone_text = $params->get('phone_text', 'Your Phone');
$message_text = $params->get('message_text', 'Your Message');
$checkbox_text = $params->get('checkbox_text', '');

$moduleclass_sfx = $params->get('moduleclass_sfx', null);
$contact_task = JRequest::getVar('contact_task', null, 'POST');
$contact_task = JRequest::getVar('contact_task', null, 'POST');

if ($contact_task == 'send') {
    $sendMessage = ModSimpleContactHelper::sendEmail($params);
}

?>
<script language="javascript">
	function contactValidate(f)
	{
		if (document.formvalidator.isValid(f)) {
			f.check.value='<?php echo JSession::getFormToken(); ?>';
			return true; 
		} else {
			alert('Please enter your contact details. Please try again.');
		}
		return false;
	}
	function clearText(field)
	{
		if (field.defaultValue == field.value) {
			field.value = '';
		}
	}

</script>

<div id="simpleContactForm<?php echo $moduleclass_sfx; ?>">
	<?php if($sendMessage) : ?>
		<p><?php echo $sendMessage; ?></p>
	<?php endif; ?>
	<form id="simpleCcontactForm" method="post" class="form-validate" onSubmit="return contactValidate(this);" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
			
		<input name="name" type="text" class="contactInput" value="<?php echo $name_text; ?>" onFocus="clearText(this)" />
		<input name="email" type="text" class="contactInput required validate-email" value="<?php echo $email_text; ?>" onFocus="clearText(this)" />
		<input name="phone" type="text" class="contactInput" value="<?php echo $phone_text; ?>" onFocus="clearText(this)" />
					
		<textarea name="text" class="contactTextarea" onFocus="clearText(this)"><?php echo $message_text; ?></textarea>
		
		<input type="submit" value="<?php echo $submit_text; ?>" class="contactButton" />
       <input type="hidden" name="contact_task" value="send" />
	   <input type="hidden" name="check" value="post" />
  </form>
</div>
