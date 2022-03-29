<?php
/**
 * @version     $Id: paldesk.php
 * @package     Joomla.Plugin
 * @subpackage  Content.Joomla
 * @author      Alen Begovic at Paldesk.com
 * @copyright   Copyright (C) 2017 Paldesk.com. All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 */

defined('_JEXEC') or die('Restricted access! Hacking attempt has been alerted!');

/**
 * CONTENT PLUGIN (class name must be plg (Plg)<PluginGroup><PluginName>)
 */
class plgContentPaldesk extends JPlugin
{
	/**
	 * @var string
	 */
	private $widgetScriptUri = "plugins/content/paldesk/scripts/jm_paldesk_widget.js";
	private $notificationScriptUri = "plugins/content/paldesk/scripts/jm_paldesk_notification.js";
	private $feedbackScriptUri = "plugins/content/paldesk/scripts/jm_paldesk_feedback.js";


	/**
	 * plgContentPaldesk constructor.
	 *
	 * @param       $subject
	 * @param array $config
	 *
	 * @throws \Exception
	 */
	public function __construct($subject, array $config = array())
	{
		parent::__construct($subject, $config);

		if ($this->canShowWidget())
		{
			$this->loadCustomStyle();
		}

	}


	/**
	 * @return bool
	 * @throws Exception
	 */
	public function onAfterRender()
	{
		$app  = JFactory::getApplication();
		$doc  = JFactory::getDocument();
		$JUri = JUri::getInstance();

		if ($this->canShowWidget())
		{
			$body   = $app->getBody();
			$script = $this->getWidgetScript();
			$script = "\n<script>\n" . $script . "\n</script>\n";


			switch ($this->params->get('position'))
			{
				case"head_start":
					$body = str_replace('<head>', '<head>' . $script, $body);
					break;

				case "head_end":
					$body = str_replace('</head>', $script . '</body>', $body);
					break;

				default:
				case "body_end":

					$body = str_replace('</body>', $script . '</body>', $body);
					break;
			}

			$app->setBody($body);
		}

		if ($this->canShowNotification())
		{
			$body   = $app->getBody();
			$script = $this->getNotificationScript();
			$script = "\n<script>\n" . $script . "\n</script>\n";


			switch ($this->params->get('position'))
			{
				case"head_start":
					$body = str_replace('<head>', '<head>' . $script, $body);
					break;

				case "head_end":
					$body = str_replace('</head>', $script . '</body>', $body);
					break;

				default:
				case "body_end":

					$body = str_replace('</body>', $script . '</body>', $body);
					break;
			}

			$app->setBody($body);
		}

		if ($this->canShowFeedback())
		{
			$body   = $app->getBody();
			$script = $this->getFeedbackScript();
			$script = "\n<script>\n" . $script . "\n</script>\n";


			switch ($this->params->get('position'))
			{
				case"head_start":
					$body = str_replace('<head>', '<head>' . $script, $body);
					break;

				case "head_end":
					$body = str_replace('</head>', $script . '</body>', $body);
					break;

				default:
				case "body_end":

					$body = str_replace('</body>', $script . '</body>', $body);
					break;
			}

			$app->setBody($body);
		}

		return true;
	}

//WIDGET
	/**
	 * @return bool|mixed|string
	 */
	private function getWidgetScript()
	{
		$app            = JFactory::getApplication();
		$script         = "";
		$apiKeyWidget   = $this->params->get('api_key_widget', "");
		$widgetPosition = $this->params->get('position_widget');
		$requirejs      = $this->params->get('requirejs', false);

		if ($requirejs && !$app->isAdmin())
		{
			$script = file_get_contents(__DIR__ . "/scripts/jm_paldesk_widget_requirejs.js");
		}
		else if (in_array($widgetPosition, array("head_start", "head_end", "body_start")))
		{
			$script = file_get_contents(__DIR__ . "/scripts/jm_paldesk_widget_head.js");
		}
		else
		{
			$script = file_get_contents(__DIR__ . "/scripts/jm_paldesk_widget_body.js");
		}


		if (!empty($apiKeyWidget) && !empty($script))
		{
			$script = str_replace("{{widget_user_data_config_object}}", $this->getWidgetUserDataConfig(), $script);

			$script = str_replace("{{widget_api_key}}", $apiKeyWidget, $script);

			return $script;
		}


		return false;
	}
//NOTIFICATION
	/**
	 * @return bool|mixed|string
	 */
	private function getNotificationScript()
	{
		$app            	  = JFactory::getApplication();
		$script         	  = "";
		$apiKeyNotification   = $this->params->get('api_key_notification', "");
		$notificationPosition = $this->params->get('position_notification');
		$requirejs      	  = $this->params->get('requirejs', false);

		if ($requirejs && !$app->isAdmin())
		{
			$script = file_get_contents(__DIR__ . "/scripts/jm_paldesk_notification_requirejs.js");
		}
		else if (in_array($notificationPosition, array("head_start", "head_end", "body_start")))
		{
			$script = file_get_contents(__DIR__ . "/scripts/jm_paldesk_notification_head.js");
		}
		else
		{
			$script = file_get_contents(__DIR__ . "/scripts/jm_paldesk_notification_body.js");
		}


		if (!empty($apiKeyNotification) && !empty($script))
		{
			$script = str_replace("{{notification_user_data_config_object}}", $this->getWidgetUserDataConfig(), $script);

			$script = str_replace("{{notification_api_key}}", $apiKeyNotification, $script);

			return $script;
		}


		return false;
	}
//FEEDBACK
	/**
	 * @return bool|mixed|string
	 */
	private function getFeedbackScript()
	{
		$app            = JFactory::getApplication();
		$script         = "";
		$apiKeyFeedback         = $this->params->get('api_key_feedback', "");
		$feedbackPosition = $this->params->get('position_feedback');
		$requirejs      = $this->params->get('requirejs', false);

		if ($requirejs && !$app->isAdmin())
		{
			$script = file_get_contents(__DIR__ . "/scripts/jm_paldesk_feedback_requirejs.js");
		}
		else if (in_array($feedbackPosition, array("head_start", "head_end", "body_start")))
		{
			$script = file_get_contents(__DIR__ . "/scripts/jm_paldesk_feedback_head.js");
		}
		else
		{
			$script = file_get_contents(__DIR__ . "/scripts/jm_paldesk_feedback_body.js");
		}


		if (!empty($apiKeyFeedback) && !empty($script))
		{
			$script = str_replace("{{feedback_user_data_config_object}}", $this->getWidgetUserDataConfig(), $script);

			$script = str_replace("{{feedback_api_key}}", $apiKeyFeedback, $script);

			return $script;
		}


		return false;
	}



	/**
	 *
	 */
	private function loadCustomStyle()
	{
		$customWidgetCss = $this->params->get("custom_widget_css", "");
		$doc             = JFactory::getDocument();

		IF (!empty($customWidgetCss))
		{
			$doc->addStyleDeclaration($customWidgetCss);
		}
	}

	/**
	 * @return bool
	 * @throws \Exception
	 */
//WIDGET
	private function canShowWidget()
	{
		$app    = JFactory::getApplication();
		$apiKeyWidget = $this->params->get('api_key_widget', "");

		if ($apiKeyWidget && ($app->isSite() || ($app->isAdmin() && $this->params->get('admin_show', 0))))
		{
			return true;
		}

		return false;
	}
//NOTIFICATION
private function canShowNotification()
{
	$app    = JFactory::getApplication();
	$apiKeyNotification = $this->params->get('api_key_notification', "");

	if ($apiKeyNotification && ($app->isSite() || ($app->isAdmin() && $this->params->get('admin_show', 0))))
	{
		return true;
	}

	return false;
}

//FEEDBACK
private function canShowFeedback()
{
	$app    = JFactory::getApplication();
	$apiKeyFeedback = $this->params->get('api_key_feedback', "");

	if ($apiKeyFeedback && ($app->isSite() || ($app->isAdmin() && $this->params->get('admin_show', 0))))
	{
		return true;
	}

	return false;
}

//WIDGET
	/**
	 * @return string
	 */
	private function getWidgetUserDataConfig()
	{

		$jUser                       = JFactory::getUser();
		$widgetUserDataConfigEnabled = $this->params->get('user_data_config_enabled', 0);

		if ($widgetUserDataConfigEnabled)
		{
			if (!empty($jUser->id))
			{
				$userName = !empty($jUser->name) ? explode(" ", $jUser->name) : "";

				$widgetUserData               = array();
				$widgetUserData["externalId"] = !empty($jUser->id) ? $jUser->id : "";
				$widgetUserData["email"]      = !empty($jUser->email) ? $jUser->email : "";
				$widgetUserData["username"]   = !empty($jUser->username) ? $jUser->username : "";
				$widgetUserData["firstname"]  = !empty($userName[0]) ? $userName[0] : "";
				$widgetUserData["lastname"]   = !empty($userName[1]) ? $userName[1] : "";

				$widgetUserData = json_encode($widgetUserData);

				$widgetUserDataConfig = "beebeeate_config.user_data = " . $widgetUserData;

				return $widgetUserDataConfig;
			}
		}

		$widgetUserDataConfig = "";

		return $widgetUserDataConfig;
	}
//NOTIFICATION
/**
	 * @return string
	 */
	private function getNotificationUserDataConfig()
	{

		$jUser                       = JFactory::getUser();
		$notificationUserDataConfigEnabled = $this->params->get('user_data_config_enabled', 0);

		if ($notificationUserDataConfigEnabled)
		{
			if (!empty($jUser->id))
			{
				$userName = !empty($jUser->name) ? explode(" ", $jUser->name) : "";

				$notificationUserData               = array();
				$notificationUserData["externalId"] = !empty($jUser->id) ? $jUser->id : "";
				$notificationUserData["email"]      = !empty($jUser->email) ? $jUser->email : "";
				$notificationUserData["username"]   = !empty($jUser->username) ? $jUser->username : "";
				$notificationUserData["firstname"]  = !empty($userName[0]) ? $userName[0] : "";
				$notificationUserData["lastname"]   = !empty($userName[1]) ? $userName[1] : "";

				$notificationUserData = json_encode($notificationUserData);

				$notificationUserDataConfig = "beebeeate_config.user_data = " . $notificationUserData;

				return $notificationUserDataConfig;
			}
		}

		$notificationUserDataConfig = "";

		return $notificationUserDataConfig;
	}


//FEEDBACK
/**
	 * @return string
	 */
	private function getFeedbackUserDataConfig()
	{

		$jUser                       = JFactory::getUser();
		$feedbackUserDataConfigEnabled = $this->params->get('user_data_config_enabled', 0);

		if ($feedbackUserDataConfigEnabled)
		{
			if (!empty($jUser->id))
			{
				$userName = !empty($jUser->name) ? explode(" ", $jUser->name) : "";

				$feedbackUserData               = array();
				$feedbackUserData["externalId"] = !empty($jUser->id) ? $jUser->id : "";
				$feedbackUserData["email"]      = !empty($jUser->email) ? $jUser->email : "";
				$feedbackUserData["username"]   = !empty($jUser->username) ? $jUser->username : "";
				$feedbackUserData["firstname"]  = !empty($userName[0]) ? $userName[0] : "";
				$feedbackUserData["lastname"]   = !empty($userName[1]) ? $userName[1] : "";

				$feedbackUserData = json_encode($feedbackUserData);

				$feedbackUserDataConfig = "beebeeate_config.user_data = " . $feedbackUserData;

				return $feedbackUserDataConfig;
			}
		}

		$feedbackUserDataConfig = "";

		return $feedbackUserDataConfig;
	}

}
