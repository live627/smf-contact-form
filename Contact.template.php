<?php

function template_main()
{
	global $scripturl, $txt, $context;

	echo '
		<div class="cat_bar">
			<h3 class="catbg">
				', $context['page_title'], '
			</h3>
		</div>
		<form action="', $scripturl, '?action=contact" method="post" style="margin: 16px">
			<span class="upperframe"><span></span></span>
			<div class="roundframe">
			<span class="half_content"><b>', $txt['contact_field_from'], ':</b></span>
			<span class="half_content"><input type="text" name="from" size="50" /></span>
			<span class="half_content"><b>', $txt['contact_field_email'], ':</b></span>
			<span class="half_content"><input type="text" name="email" size="50" /></span>
			<span class="half_content"><b>', $txt['contact_field_subject'], ':</b></span>
			<span class="half_content"><input type="text" name="subject" size="50" /></span>
			<span class="half_content"><b>', $txt['contact_field_message'], ':</b></span>
			<span class="half_content"><textarea rows="6" name="message" cols="42"></textarea></span>';

	if ($context['visual_verification'])
	{
		echo '
			<span class="half_content"><b>', $txt['verification'], ':</b></span>
			<span class="half_content">', template_control_verification($context['visual_verification_id'], 'all'), '</span>';
	}

	echo '
				<div class="submitbutton">
					<input type="submit" value="', $txt['sendtopic_send'], '" name="send" tabindex="', $context['tabindex']++, '" />
					<input type="hidden" name="', $context['session_var'], '" value="', $context['session_id'], '" />
					<input type="hidden" name="', $context['contact_token_var'], '" value="', $context['contact_token'], '" />
				</div>
			</div>
		</form>';
}

function template_send()
{
	global $scripturl, $txt;

	echo '
<div>
	<table border="0" cellpadding="3" cellspacing="0" width="80%" class="tborder" align="center">
		<tr class="catbg">
			<span align="center">', $txt['contact_success'], '</span>
		</tr>
		<tr class="windowbg2">
			<span style="padding: 3ex;" align="center">
				<a href="', $scripturl, '">', $txt['contact_success_link'], '</a>
			</span>
		</tr>
	</table>
</div>';
}
?>
