<?php
/**
 *
 * Footer Icons extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2023 - cabot
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace cabot\footericons\event;

use phpbb\template\template;
use phpbb\db\driver\driver_interface;
use phpbb\config\config;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event listener
 *
 */
class listener implements EventSubscriberInterface
{
	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var string */
	protected $footericons_table;

	/**
	 * Constructor
	 *
	 * @param \phpbb\config\config				$config
	 * @param \phpbb\template\template			$template
	 * @param \phpbb\db\driver\driver_interface	$db
	 * @param string							$footericons_table
	 */

	public function __construct(config $config, template $template, driver_interface $db, $footericons_table)
	{
		$this->config = $config;
		$this->template = $template;
		$this->db = $db;
		$this->footericons_table = $footericons_table;
	}

	public static function getSubscribedEvents()
	{
		return [
			'core.page_header'	=> 'footericons',
			'core.user_setup'	=> 'load_language_on_setup',
		];
	}

	public function load_language_on_setup($event)
	{
		$lang_set_ext		= $event['lang_set_ext'];
		$lang_set_ext[]		= [
			'ext_name'		=> 'cabot/footericons',
			'lang_set'		=> 'common_footericons',
		];
		$event['lang_set_ext'] = $lang_set_ext;
	}

	public function footericons()
	{
		$this->template->assign_vars([
			'FI_ENABLE'		=> (bool) $this->config['footericons_enable'],
			'FI_POSITION'	=> $this->config['footericons_position'],
			'FI_ALIGN'		=> $this->config['footericons_align'],
			'FI_SIZE'		=> $this->config['footericons_size'],
		]);

		$sql = 'SELECT *
		FROM '. $this->footericons_table;
		$result	 = $this->db->sql_query($sql, 86400);

			while ($row = $this->db->sql_fetchrow($result))
			{
			if (!empty($row['fi_url']))
				{
				$this->template->assign_block_vars('fi_icons', [
					'FI_URL'			=> $row['fi_url'],
					'FI_NAME'			=> $row['fi_name'],
					'FI_DESC'			=> $row['fi_desc'],
					'FI_OPEN'			=> (bool) $row['fi_open'],
					'FI_CODE'			=> $row['fi_code'],
					'FI_COLOR'			=> $row['fi_color'],
					'FI_COLOR_HOVER'	=> $row['fi_color_hover'],
					'FI_BG'				=> $row['fi_bg'],
					'FI_BGCOLOR'		=> $row['fi_bgcolor'],
					'FI_BGCOLOR_HOVER'	=> $row['fi_bgcolor_hover'],
					'FI_SHADOW_COLOR'	=> $row['fi_shadow_color'],
					]);
				}
			}
		$this->db->sql_freeresult($result);
	}
}
