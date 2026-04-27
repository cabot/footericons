<?php
/**
 *
 * Footer Icons extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2023-2026 - cabot
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}
// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ « » “ ” …
//
$lang = array_merge($lang, [
	'ACP_FI_ALIGN'							=> 'Alignment of icons',
	'ACP_FI_ALIGN_CENTER'					=> 'Center',
	'ACP_FI_ALIGN_END'						=> 'Right',
	'ACP_FI_ALIGN_START'					=> 'Left',
	'ACP_FI_APPLY_STYLE'					=> 'Apply the style of this icon to other icons',
	'ACP_FI_STYLES_APPLIED'					=> 'The icon style has been successfully applied to other icons.',
	'ACP_FI_APPLY_STYLE_CONFIRM'			=> 'Are you sure you want to apply the style of this icon to all other icons?<br><ul><li>Icon colour</li><li>Icon colour on hover</li><li>Icon background</li><li>Background colour</li><li>Background colour on hover</li><li>Drop shadow colour</li></ul>',
	'ACP_FI_BG'								=> 'Icon background',
	'ACP_FI_BG_CIRCLE'						=> 'Round background',
	'ACP_FI_BG_EXPLAIN'						=> 'Allows you to add a round or square background.',
	'ACP_FI_BG_NONE'						=> 'No background',
	'ACP_FI_BG_SQUARE'						=> 'Rounded square background',
	'ACP_FI_BG_STOP'						=> 'Square background',
	'ACP_FI_BGCOLOR'						=> 'Background colour',
	'ACP_FI_BGCOLOR_HOVER'					=> 'Background colour on hover',
	'ACP_FI_BGCOLOR_HOVER_EXPLAIN'			=> 'Enter the value “transparent” to use the default icon colour.',
	'ACP_FI_CODE'							=> 'Icon code',
	'ACP_FI_CODE_EXPLAIN'					=> 'Click in the field to select an icon.',
	'ACP_FI_COLOR'							=> 'Icon colour',
	'ACP_FI_COLOR_HOVER'					=> 'Colour of the icon on hover',
	'ACP_FI_DEFAULT_TITLE'					=> 'New icon',
	'ACP_FI_DELETE_INFO'					=> 'The icon will be removed when the form is validated.',
	'ACP_FI_DELETE_CONFIRM'					=> 'Are you sure you want to delete this icon?',
	'ACP_FI_DELETE_NO'						=> 'Restore',
	'ACP_FI_DELETE_YES'						=> 'Delete',
	'ACP_FI_DELETED'						=> 'Icon “%s” successfully deleted.',
	'ACP_FI_DELETE_FAILED'					=> 'Failed to delete the icon.',
	'ACP_FI_DESC'							=> 'Icon description',
	'ACP_FI_DESC_EXPLAIN'					=> 'Informative text displayed in a tooltip when hovering the icon.',
	'ACP_FI_ENABLE'							=> 'Enable icon display',
	'ACP_FI_EXTERNAL_LINK'					=> 'External link',
	'ACP_FI_EXTERNAL_LINK_EXPLAIN'			=> 'Select "Yes" to open the link in a new tab.',
	'ACP_FI_HEADING_ADD'					=> 'Add an icon',
	'ACP_FI_HEADING_EDIT'					=> 'Edit an icon',
	'ACP_FI_HEADING_SETTINGS'				=> 'Icons configuration and preview',
	'ACP_FI_ICON_ADD'						=> 'Add new icon',
	'ACP_FI_ICON_CLOSE'						=> 'Close',
	'ACP_FI_ICONS_LIST'						=> 'Icons list',
	'ACP_FI_ICON_SEARCH'					=> 'Search (eg. google)',
	'ACP_FI_ICONS'							=> 'Icons',
	'ACP_FI_INFO'							=> 'Informations',
	'ACP_FI_NAME'							=> 'Icon name',
	'ACP_FI_NAME_EXPLAIN'					=> 'Enter the name of the icon (e.g. phpBB).',
	'ACP_FI_POSITION'						=> 'Position of icons',
	'ACP_FI_POSITION_COPYRIGHT_APPEND'		=> 'In copyrights',
	'ACP_FI_POSITION_COPYRIGHT_PREPEND'		=> 'Before copyrights',
	'ACP_FI_POSITION_FOOTER_AFTER'			=> 'Below the forum',
	'ACP_FI_POSITION_PAGE_BODY_AFTER'		=> 'Before the bottom navigation bar',
	'ACP_FI_PREVIEW'						=> 'Preview',
	'ACP_FI_PREVIEW_EXPLAIN'				=> 'Only icons already validated will be displayed here.',
	'ACP_FI_REQUIRED'						=> '*required',
	'ACP_FI_SAVED'							=> 'Icons settings saved',
	'ACP_FI_SHADOW_COLOR'					=> 'Drop shadow colour',
	'ACP_FI_SHADOW_COLOR_EXPLAIN'			=> 'Add a slight drop shadow to the icon.<br>Select the value “transparent” to not display a shadow.',
	'ACP_FI_SIZE'							=> 'Icon size',
	'ACP_FI_SIZE_EXPLAIN'					=> 'Enter the display size of the icon and the <a href="https://www.w3.org/Style/Examples/007/units.en.html" title="Learn more about units of measurements (opens in new tab)" target="_blank"> unit of measurement <i class="fa fa-external-link" aria-hidden="true"></i></a>.<br>Default: <b>2em</b>',
	'ACP_FI_TOP'							=> 'Back to the top',
	'ACP_FI_URL'							=> 'URL of the link associated to the icon',
	'ACP_FI_URL_EXPLAIN'					=> 'Enter the full URL of the link (e.g. https://www.phpbb-fr.com)',
	'ACP_FI_MISSING_FIELDS'					=> 'The following required field(s) are missing:<br>%s',
	'ACP_FI_NOT_FOUND'						=> 'Icon not found.',
]);
