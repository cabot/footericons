<?php
/**
 *
 * Footer Icons extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2023 - cabot
 * @license GNU General Public License, version 2 (GPL-2.0)
 * Slovenian Translation - Marko K.(max, max-ima,...)
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
	'ACP_FI_ALIGN'							=> 'Poravnava ikon',
	'ACP_FI_ALIGN_CENTER'					=> 'Center',
	'ACP_FI_ALIGN_END'						=> 'Desno',
	'ACP_FI_ALIGN_START'					=> 'Levo',
	'ACP_FI_BG'								=> 'Ozadje ikone',
	'ACP_FI_BG_CIRCLE'						=> 'Okroglo ozadje',
	'ACP_FI_BG_EXPLAIN'						=> 'Omogoča dodajanje okroglega ali kvadratnega ozadja.',
	'ACP_FI_BG_NONE'						=> 'Brez ozadja',
	'ACP_FI_BG_SQUARE'						=> 'Zaobljeno kvadratno ozadje',
	'ACP_FI_BG_STOP'						=> 'Kvadratno ozadje',
	'ACP_FI_BGCOLOR'						=> 'Barva ozadja ikone',
	'ACP_FI_BGCOLOR_HOVER'					=> 'Barva ozadja ob prehodu na ikono',
	'ACP_FI_BGCOLOR_HOVER_EXPLAIN'			=> 'Vnesite vrednost “prozorno”, če želite uporabiti privzeto barvo ikone.',
	'ACP_FI_CODE'							=> 'Koda ikone',
	'ACP_FI_CODE_EXPLAIN'					=> 'Kliknite v polje, da izberete ikono.',
	'ACP_FI_COLOR'							=> 'Barva ikone',
	'ACP_FI_COLOR_HOVER'					=> 'Barva ikone ob prehodu na ikono',
	'ACP_FI_HEADING'						=> 'Konfiguracija in predogled ikon v nogi',
	'ACP_FI_DEFAULT_TITLE'					=> 'Nova ikona',
	'ACP_FI_DESC'							=> 'Opis ikone',
	'ACP_FI_DESC_EXPLAIN'					=> 'Informativno besedilo, ki se prikaže v namigu, ko se ikona premakne (Izbirno).',
	'ACP_FI_DELETE_INFO'					=> 'Ikona bo odstranjena, ko bo obrazec potrjen.',
	'ACP_FI_DELETE_NO'						=> 'Obnovi',
	'ACP_FI_DELETE_YES'						=> 'Izbriši',
	'ACP_FI_ENABLE'							=> 'Omogoči prikaz ikon',
	'ACP_FI_INFO'							=> 'Informacije',
	'ACP_FI_ICON_CLOSE'						=> 'Zapri',
	'ACP_FI_ICON_SEARCH'					=> 'Iskanje (npr. google)',
	'ACP_FI_ICONS'							=> 'Ikone',
	'ACP_FI_MORE_LINKS'						=> 'Dodajte drugo ikono',
	'ACP_FI_NAME'							=> 'Ime ikone',
	'ACP_FI_NAME_EXPLAIN'					=> 'Vnesite ime ikone (npr. phpBB).',
	'ACP_FI_OPEN'							=> 'Odpiranje povezave',
	'ACP_FI_OPEN_NEW'						=> 'Novo okno',
	'ACP_FI_OPEN_SAME'						=> 'Isto okno',
	'ACP_FI_PREVIEW'						=> 'Predogled',
	'ACP_FI_PREVIEW_EXPLAIN'				=> 'Tukaj bodo prikazane samo že potrjene ikone.',
	'ACP_FI_POSITION'						=> 'Položaj ikon',
	'ACP_FI_POSITION_COPYRIGHT_APPEND'		=> 'V avtorskih pravicah',
	'ACP_FI_POSITION_COPYRIGHT_PREPEND'		=> 'Pred avtorskimi pravicami',
	'ACP_FI_POSITION_FOOTER_AFTER'			=> 'Pod forumom',
	'ACP_FI_POSITION_PAGE_BODY_AFTER'		=> 'Pred spodnjo navigacijsko vrstico',
	'ACP_FI_SAVED'							=> 'Nastavitve ikon so shranjene',
	'ACP_FI_SHADOW_COLOR'					=> 'Barva padajoče sence',
	'ACP_FI_SHADOW_COLOR_EXPLAIN'			=> 'Ikoni dodajte rahlo padajočo senco.<br>Če želite, da se senca ne prikaže, izberite vrednost “prozorno”.',
	'ACP_FI_SIZE'							=> 'Velikost ikon',
	'ACP_FI_SIZE_EXPLAIN'					=> 'Vnesite velikost prikaza ikone in <a href="https://www.w3.org/Style/Examples/007/units.en.html" title="Več o merskih enotah (odpre se v novem zavihku)" target="_blank"> mersko enoto <i class="fa fa-external-link" aria-hidden="true"></i></a>.<br>Privzeto: <b>2em</b>',
	'ACP_FI_TOP'							=> 'Nazaj na vrh',
	'ACP_FI_URL'							=> 'URL povezave, povezane z ikono',
	'ACP_FI_URL_EXPLAIN'					=> 'Vnesite celoten naslov URL povezave (npr. https://www.phpbb-fr.com)<br><strong>Pustite to polje prazno in potrdite, da odstranite povezavo.</strong>',
]);
