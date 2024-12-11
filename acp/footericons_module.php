<?php
/**
 *
 * Footer Icons extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2023 - cabot
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace cabot\footericons\acp;

/**
 * @package acp
 */

class footericons_module
{
	/** @var string */
	public $u_action;

	/** @var string */
	public $tpl_name;

	/** @var string */
	public $page_title;

	function main()
	{
		global $phpbb_container, $db, $template, $request, $config, $cache, $user, $phpbb_log, $language;

		$this->tpl_name = 'acp_footericons';
		$language->add_lang('acp_footericons', 'cabot/footericons');
		$this->page_title = $language->lang('ACP_FI_TITLE');
		$footericons_table = $phpbb_container->getParameter('tables.footericons_table');

		add_form_key('footericons/acp_footericons');

		$sql = 'SELECT *
		FROM '. $footericons_table;
		$result = $db->sql_query($sql);

		while ($row = $db->sql_fetchrow($result))
		{
			if (!empty($row['fi_url']))
			{
				$template->assign_block_vars('fi_icons', [
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
		};

		if (empty($row['fi_url']))
		{
			$template->assign_block_vars('fi_icons', [
				'FI_URL'	=> '',
			]);
		};
		$db->sql_freeresult($result);

		$submit = $request->is_set_post('submit');
		if ($submit)
		{
			if (!check_form_key('footericons/acp_footericons'))
			{
				trigger_error('FORM_INVALID');
			}

			$config->set('footericons_enable', $request->variable('footericons_enable', 0));
			$config->set('footericons_position', $request->variable('footericons_position', 0));
			$config->set('footericons_align', $request->variable('footericons_align', ''));
			$config->set('footericons_size', $request->variable('footericons_size', ''));

			$sql = 'DELETE FROM ' . $footericons_table ;
			$db->sql_query($sql);

			$fi_url 			= $request->variable('fi_url', ['' => ''], true);
			$fi_name 			= $request->variable('fi_name', ['' => ''], true);
			$fi_desc 			= $request->variable('fi_desc', ['' => ''], true);
			$fi_open 			= $request->variable('fi_open', ['' => ''], true);
			$fi_code 			= $request->variable('fi_code', ['' => ''], true);
			$fi_color 			= $request->variable('fi_color', ['' => ''], true);
			$fi_color_hover 	= $request->variable('fi_color_hover', ['' => ''], true);
			$fi_bg 				= $request->variable('fi_bg', ['' => ''], true);
			$fi_bgcolor 		= $request->variable('fi_bgcolor', ['' => ''], true);
			$fi_bgcolor_hover 	= $request->variable('fi_bgcolor_hover', ['' => ''], true);
			$fi_shadow_color 	= $request->variable('fi_shadow_color', ['' => ''], true);

			$i = 0;
			$sql_ary = [];
			while ($i < count($fi_url))
			{
				$sql_ary[] = [
					'fi_url' 			=> $fi_url[$i],
					'fi_name'			=> $fi_name[$i],
					'fi_desc'			=> $fi_desc[$i],
					'fi_open'			=> $fi_open[$i],
					'fi_code'			=> $fi_code[$i],
					'fi_color' 			=> $fi_color[$i],
					'fi_color_hover' 	=> $fi_color_hover[$i],
					'fi_bg'				=> $fi_bg[$i],
					'fi_bgcolor' 		=> $fi_bgcolor[$i],
					'fi_bgcolor_hover' 	=> $fi_bgcolor_hover[$i],
					'fi_shadow_color'	=> $fi_shadow_color[$i],
				];
				$i++;
			}
			$db->sql_multi_insert($footericons_table,  $sql_ary);

			$cache->destroy('sql', $footericons_table);

			$user_id = $user->data['user_id'];
			$user_ip = $user->ip;

			$phpbb_log->add('admin', $user_id, $user_ip, 'LOG_FI_MODIFIED');
			trigger_error($language->lang('ACP_FI_SAVED') . adm_back_link($this->u_action));
		}

		$template->assign_vars([
			'FI_ENABLE'		=> (bool) $config['footericons_enable'],
			'FI_POSITION'	=> $config['footericons_position'],
			'FI_ALIGN'		=> $config['footericons_align'],
			'FI_SIZE'		=> $config['footericons_size'],
		]);
	}
}
