<?php
/**
 *
 * Footer Icons extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2023-2026 - cabot
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace cabot\footericons\event;

use phpbb\cache\driver\driver_interface as cache;
use phpbb\config\config;
use phpbb\db\driver\driver_interface as db;
use phpbb\extension\manager;
use phpbb\path_helper;
use phpbb\template\template;
use cabot\footericons\ext;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event listener
 *
 */
class listener implements EventSubscriberInterface
{
	/** @var cache */
	protected $cache;

	/** @var config */
	protected $config;

	/** @var db */
	protected $db;

	/** @var manager */
	protected $ext_manager;

	/** @var path_helper */
	protected $path_helper;

	/** @var template */
	protected $template;

	/** @var string */
	protected $footericons_table;

	/** @var string ext path */
	protected $ext_path;

	/**
	 * Constructor
	 *
	 * @param cache    $cache
	 * @param config   $config
	 * @param db       $db
	 * @param manager  $ext_manager
	 * @param template $template
	 * @param string   $footericons_table
	 */

	public function __construct(cache $cache, config $config, db $db, manager $ext_manager, path_helper $path_helper, template $template, string $footericons_table)
	{
		$this->cache = $cache;
		$this->config = $config;
		$this->db = $db;
		$this->ext_manager = $ext_manager;
		$this->path_helper = $path_helper;
		$this->template = $template;
		$this->footericons_table = $footericons_table;
		$ext_rel = $this->ext_manager->get_extension_path('cabot/footericons', true);
		$this->ext_path = $this->path_helper->update_web_root_path($ext_rel);
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
			'FI_ENABLE'						=> (bool) $this->config['footericons_enable'],
			'FI_POSITION'					=> $this->config['footericons_position'],
			'FI_ALIGN'						=> $this->config['footericons_align'],
			'FI_SIZE'						=> $this->config['footericons_size'],
			'FA_BRANDS_SUPPORT_STYLESHEET'	=> $this->ext_path . ext::FA_BRANDS_SUPPORT_PATH,
			'FA_BRANDS_ICONS_STYLESHEET'	=> $this->ext_path . ext::FA_BRANDS_ICONS_PATH,
		]);

		$fi_icons = $this->cache->get('_footericons');
		if ($fi_icons === false)
		{
			$sql = 'SELECT * FROM ' . $this->footericons_table . ' ORDER BY fi_order';
			$result = $this->db->sql_query($sql);

			$fi_icons = [];
			while ($row = $this->db->sql_fetchrow($result))
			{
				$fi_icons[] = $row;
			}
			$this->db->sql_freeresult($result);

			$this->cache->put('_footericons', $fi_icons);
		}

		foreach ($fi_icons as $row)
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
	}
}
