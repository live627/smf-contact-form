<?php

if (!defined('SMF'))
	die('Hacking attempt...');

function Contact()
{
	global $context, $mbname, $txt, $sourcedir, $modSettings, $webmaster_email;

	// Users have no need to use this, just send a PM
	if (!$user_info['is_guest'])
		redirectexit();

	loadTemplate('Register');

	// Are we submitting?
	if (isset($_GET['sa']) && $_GET['sa'] == 'save')
	{
		checkSession('post');
		validateToken('contact');

		// Can't send a lot of these in a row, no sir!
		spamProtection('contact');

		// No errors, yet.
		$context['errors'] = array();

		// Check whether the visual verification code was entered correctly.
		if (!empty($modSettings['reg_verification']) && $context['user']['is_guest'])
		{
			require_once($sourcedir . '/Subs-Editor.php');
			$verificationOptions = array(
				'id' => 'register',
			);
			$context['visual_verification'] = create_control_verification($verificationOptions, true);

			if (is_array($context['visual_verification']))
			{
				loadLanguage('Errors');
				foreach ($context['visual_verification'] as $error)
					$context['errors'][] = $txt['error_' . $error];
			}
		}

		// Check the fields
		$fields = array('from', 'email', 'subject', 'message');
		foreach($fields as $field)
			if(empty($_POST[$field]))
				$context['errors'][] = $txt['contact_' . $field . '_blank'];

		// For send mail function
		require_once($sourcedir . '/Subs-Post.php');

		$message = <<<EOD
Name: {$_POST['from']}
Email: {$_POST['email']}
Subject: {$_POST['subject']}

{$_POST['message']}
EOD;

		// Send email to webmaster
		sendmail($webmaster_email, $mbname.' - '.$_POST['subject'], $message, $_POST['email']);

		$context['sub_template']  = 'send';
		$context['page_title'] = $txt['contact_title_sent'];
	}
	else
	{
		// Generate a visual verification code to make sure the user is no bot.
		if (!empty($modSettings['reg_verification']))
		{
			require_once($sourcedir . '/Subs-Editor.php');
			$verificationOptions = array(
				'id' => 'register',
			);
			$context['visual_verification'] = create_control_verification($verificationOptions);
			$context['visual_verification_id'] = $verificationOptions['id'];
		}
		// Otherwise we have nothing to show.
		else
			$context['visual_verification'] = false;

		$context['sub_template']  = 'main';
		$context['page_title'] = $txt['contact_title'];
		createToken('contact');
	}
}
?>
