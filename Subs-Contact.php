<?php
// Version: 1.0: Subs-Contact.php

if (!defined('SMF'))
	die('Hacking attempt...');

function contact_load_theme()
{
	loadLanguage('Contact');
}

function contact_menu_buttons($menu_buttons)
{
	global $txt, $user_info, $scripturl;

	$new_button = array(
		'title' => $txt['contact'],
		'href' => $scripturl . '?action=contact',
		'show' => $user_info['is_guest'],
	);

	$new_menu_buttons = array();
	foreach ($menu_buttons as $area => $info)
	{
		$new_menu_buttons[$area] = $info;
		if ($area == 'help')
			$new_menu_buttons['contact'] = $new_button;
	}

	$menu_buttons = $new_menu_buttons;
}

function contact_actions(&$action_array)
{
	$action_array['contact'] = array('Contact.php', 'Contact');
}