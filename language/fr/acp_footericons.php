<?php
/**
 *
 * Footer Icons extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2023 - cabot
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
	'ACP_FI_ALIGN'							=> 'Alignement des icônes',
	'ACP_FI_ALIGN_CENTER'					=> 'Au centre',
	'ACP_FI_ALIGN_END'						=> 'À droite',
	'ACP_FI_ALIGN_START'					=> 'À gauche',
	'ACP_FI_BG'								=> 'Fond de l’icône',
	'ACP_FI_BG_CIRCLE'						=> 'Fond rond',
	'ACP_FI_BG_EXPLAIN'						=> 'Permet d’ajouter un fond rond ou carré.',
	'ACP_FI_BG_NONE'						=> 'Pas de fond',
	'ACP_FI_BG_SQUARE'						=> 'Fond carré arrondi',
	'ACP_FI_BG_STOP'						=> 'Fond carré',
	'ACP_FI_BGCOLOR'						=> 'Couleur de fond',
	'ACP_FI_BGCOLOR_HOVER'					=> 'Couleur de fond au survol',
	'ACP_FI_BGCOLOR_HOVER_EXPLAIN'			=> 'Saisissez la valeur « transparent » pour utiliser la couleur de l’icône par défaut.',
	'ACP_FI_CODE'							=> 'Code de l’icône',
	'ACP_FI_CODE_EXPLAIN'					=> 'Cliquez dans le champ pour sélectionner une icône.',
	'ACP_FI_COLOR'							=> 'Couleur de l’icône',
	'ACP_FI_COLOR_HOVER'					=> 'Couleur de l’icône au survol',
	'ACP_FI_HEADING'						=> 'Configuration et aperçu des icônes de pied de page',
	'ACP_FI_DEFAULT_TITLE'					=> 'Nouvelle icône',
	'ACP_FI_DESC'							=> 'Description de l’icône',
	'ACP_FI_DESC_EXPLAIN'					=> 'Texte informatif affiché dans une infobulle lors du survol de l’icône (facultatif).',
	'ACP_FI_DELETE_INFO'					=> 'L’icône sera supprimée lors de la validation du formulaire.',
	'ACP_FI_DELETE_NO'						=> 'Restaurer',
	'ACP_FI_DELETE_YES'						=> 'Supprimer',
	'ACP_FI_ENABLE'							=> 'Activer l’affichage des icônes',
	'ACP_FI_ICON_CLOSE'						=> 'Fermer',
	'ACP_FI_ICON_SEARCH'					=> 'Rechercher (p. ex. google)',
	'ACP_FI_ICONS'							=> 'Icônes',
	'ACP_FI_INFO'							=> 'Informations',
	'ACP_FI_MORE_LINKS'						=> 'Ajouter une nouvelle icône',
	'ACP_FI_NAME'							=> 'Nom de l’icône',
	'ACP_FI_NAME_EXPLAIN'					=> 'Saisissez l’intitulé de l’icône (p. ex. phpBB).',
	'ACP_FI_OPEN'							=> 'Ouverture du lien',
	'ACP_FI_OPEN_NEW'						=> 'Nouvelle fenêtre',
	'ACP_FI_OPEN_SAME'						=> 'Même fenêtre',
	'ACP_FI_PREVIEW'						=> 'Aperçu',
	'ACP_FI_PREVIEW_EXPLAIN'				=> 'Seuls les icônes déjà validées seront affichées ici.',
	'ACP_FI_POSITION'						=> 'Position des icônes',
	'ACP_FI_POSITION_COPYRIGHT_APPEND'		=> 'Dans les copyrights',
	'ACP_FI_POSITION_COPYRIGHT_PREPEND'		=> 'Avant les copyrights',
	'ACP_FI_POSITION_FOOTER_AFTER'			=> 'Sous le forum',
	'ACP_FI_POSITION_PAGE_BODY_AFTER'		=> 'Avant la barre de navigation inférieure',
	'ACP_FI_SAVED'							=> 'Paramètres des icônes sauvegardés',
	'ACP_FI_SHADOW_COLOR'					=> 'Couleur de l’ombre portée',
	'ACP_FI_SHADOW_COLOR_EXPLAIN'			=> 'Ajoutez une légère ombre portée à l’icône.<br>Saisissez la valeur « transparent » pour ne pas afficher d’ombre.',
	'ACP_FI_SIZE'							=> 'Taille de l’icône',
	'ACP_FI_SIZE_EXPLAIN'					=> 'Saisissez la taille d’affichage de l’icône et l’<a href="https://www.w3.org/Style/Examples/007/units.fr.html" title="En savoir plus sur les unités de mesure (s’ouvre dans un nouvel onglet)" target="_blank">unité de mesure <i class="fa fa-external-link" aria-hidden="true"></i></a>.<br>Par défaut : <b>2em</b>',
	'ACP_FI_TOP'							=> 'Retour en haut de page',
	'ACP_FI_URL'							=> 'URL du lien associé à l’icône',
	'ACP_FI_URL_EXPLAIN'					=> 'Saisissez l’URL complète du lien (p. ex. https://www.phpbb-fr.com)<br><strong>Laissez le champ vide et validez pour supprimer l’icône.</strong>',
]);
