<?php
/**
 *
 * Footer Icons extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2023-2026 - cabot
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace cabot\footericons\controller;

use phpbb\config\config;
use phpbb\db\driver\driver_interface as db;
use phpbb\extension\manager;
use phpbb\language\language;
use phpbb\log\log;
use phpbb\request\request;
use phpbb\template\template;
use phpbb\cache\driver\driver_interface as cache;
use phpbb\user;
use cabot\footericons\services\footericons_service;
use cabot\footericons\ext;

class acp_controller
{
	/** @var config */
	protected $config;

	/** @var db */
	protected $db;

	/** @var manager */
	protected $ext_manager;

	/** @var language */
	protected $language;

	/** @var log */
	protected $log;

	/** @var request */
	protected $request;

	/** @var template */
	protected $template;

	/** @var cache */
	protected $cache;

	/** @var user */
	protected $user;

	/** @var footericons_service */
	protected $footericons_service;

	/** @var string */
	protected $footericons_table;

	/** @var string */
	public $u_action;

	/** @var string ext path */
	protected $ext_path;

	/**
	 * Constructor
	 *
	 * @param config				$config
	 * @param db					$db
	 * @param manager				$ext_manager
	 * @param language				$language
	 * @param log					$log
	 * @param request				$request
	 * @param template				$template
	 * @param user					$user
	 * @param cache					$cache
	 * @param footericons_service	$footericons_service
	 * @param string				$footericons_table
	 */
	public function __construct(config $config, db $db, manager $ext_manager, language $language, log $log, request $request, template $template, user $user, cache $cache, footericons_service $footericons_service, string $footericons_table)
	{
		$this->config = $config;
		$this->db = $db;
		$this->ext_manager = $ext_manager;
		$this->language = $language;
		$this->log = $log;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->cache = $cache;
		$this->footericons_service = $footericons_service;
		$this->footericons_table = $footericons_table;
		$this->ext_path = $this->ext_manager->get_extension_path('cabot/footericons', true);

		$this->language->add_lang('acp_footericons', 'cabot/footericons');
	}

	/**
	 * Display the options a user can configure for this extension.
	 *
	 * @return void
	 */
	public function display_options(): void
	{
		$form_key = 'footericons/acp_footericons';
		add_form_key($form_key);

		$this->template->assign_vars([
			'U_ACTION' => $this->u_action,
		]);

		// Actions
		$action = $this->request->variable('action', '');
		$icon_id = (int)$this->request->variable('fi_id', 0);

		$this->handle_action($action, $icon_id, $form_key);

		// General settings
		if (in_array($action, ['add', 'edit'], true))
		{
			return;
		}
		$this->settings_submission($form_key);

		$this->assign_template_vars();
	}

	/**
	 * Handle add/edit form display and submission.
	 *
	 * @param string $action 'add' or 'edit'
	 * @param int $icon_id
	 * @param string $form_key
	 * @return void
	 */
	protected function add_edit(string $action, int $icon_id, string $form_key): void
	{
		$submit = $this->request->is_set_post('submit');
		$errors = [];
		$error_msg = '';
		$has_errors = false;

		$icon_data = [
			'FI_URL'			=> '',
			'FI_NAME'			=> '',
			'FI_DESC'			=> '',
			'FI_OPEN'			=> 0,
			'FI_CODE'			=> '',
			'FI_COLOR'			=> '#105289',
			'FI_COLOR_HOVER'	=> '#105289',
			'FI_BG'				=> 0,
			'FI_BGCOLOR'		=> 'transparent',
			'FI_BGCOLOR_HOVER'	=> 'transparent',
			'FI_SHADOW_COLOR'	=> 'transparent',
		];

		if ($action === 'edit' && $icon_id)
		{
			$sql = 'SELECT * FROM ' . $this->footericons_table . ' WHERE fi_id = ' . (int) $icon_id;
			$result = $this->db->sql_query($sql);
			if ($row = $this->db->sql_fetchrow($result))
			{
				$icon_data = array_merge($icon_data, [
					'FI_URL'			=> $row['fi_url'],
					'FI_NAME'			=> $row['fi_name'],
					'FI_DESC'			=> $row['fi_desc'],
					'FI_OPEN'			=> (int) $row['fi_open'],
					'FI_CODE'			=> $row['fi_code'],
					'FI_COLOR'			=> $row['fi_color'],
					'FI_COLOR_HOVER'	=> $row['fi_color_hover'],
					'FI_BG'				=> (int)$row['fi_bg'],
					'FI_BGCOLOR'		=> $row['fi_bgcolor'],
					'FI_BGCOLOR_HOVER'	=> $row['fi_bgcolor_hover'],
					'FI_SHADOW_COLOR'	=> $row['fi_shadow_color'],
				]);
			}
			$this->db->sql_freeresult($result);
		}

		if ($submit)
		{
			if (!check_form_key($form_key))
			{
				trigger_error('FORM_INVALID');
			}

			$fi_url = $this->request->variable('fi_url', '', true);
			$fi_name = $this->request->variable('fi_name', '', true);
			$fi_desc = $this->request->variable('fi_desc', '', true);
			$fi_open = (int) $this->request->variable('fi_open', 0);
			$fi_code = $this->request->variable('fi_code', '', true);
			$fi_color = $this->request->variable('fi_color', '#105289', true);
			$fi_color_hover = $this->request->variable('fi_color_hover', '#105289', true);
			$fi_bg = (int) $this->request->variable('fi_bg', 0);
			$fi_bgcolor = $this->request->variable('fi_bgcolor', 'transparent', true);
			$fi_bgcolor_hover = $this->request->variable('fi_bgcolor_hover', 'transparent', true);
			$fi_shadow_color = $this->request->variable('fi_shadow_color', 'transparent', true);

			// Merge submitted values for re-display in case of errors
			$icon_data = array_merge($icon_data, [
				'FI_URL'			=> $fi_url,
				'FI_NAME'			=> $fi_name,
				'FI_DESC'			=> $fi_desc,
				'FI_OPEN'			=> $fi_open,
				'FI_CODE'			=> $fi_code,
				'FI_COLOR'			=> $fi_color,
				'FI_COLOR_HOVER'	=> $fi_color_hover,
				'FI_BG'				=> $fi_bg,
				'FI_BGCOLOR'		=> $fi_bgcolor,
				'FI_BGCOLOR_HOVER'	=> $fi_bgcolor_hover,
				'FI_SHADOW_COLOR'	=> $fi_shadow_color,
			]);

			if (empty($fi_name))
			{
				$errors[] = $this->language->lang('ACP_FI_NAME');
			}
			if (empty($fi_url))
			{
				$errors[] = $this->language->lang('ACP_FI_URL');
			}
			if (empty($fi_code))
			{
				$errors[] = $this->language->lang('ACP_FI_CODE');
			}

			if (!empty($errors))
			{
				$has_errors = true;
				$error_msg = $this->language->lang('ACP_FI_MISSING_FIELDS', implode('<br>', array_map(function($e) { return '<strong>' . $e . '</strong>'; }, $errors)));
			}

			if (!$has_errors)
			{
				if ($action === 'add')
				{
					$sql = 'SELECT MAX(fi_order) AS max_order FROM ' . $this->footericons_table;
					$result = $this->db->sql_query($sql);
					$row = $this->db->sql_fetchrow($result);
					$max_order = (int) ($row['max_order'] ?? 0);
					$this->db->sql_freeresult($result);
					$new_order = $max_order + 1;

					$this->db->sql_query('INSERT INTO ' . $this->footericons_table . ' ' . $this->db->sql_build_array('INSERT', [
						'fi_url' => $fi_url,
						'fi_name' => $fi_name,
						'fi_desc' => $fi_desc,
						'fi_open' => $fi_open,
						'fi_code' => $fi_code,
						'fi_color' => $fi_color,
						'fi_color_hover' => $fi_color_hover,
						'fi_bg' => $fi_bg,
						'fi_bgcolor' => $fi_bgcolor,
						'fi_bgcolor_hover' => $fi_bgcolor_hover,
						'fi_shadow_color' => $fi_shadow_color,
						'fi_order' => $new_order,
					]));
					$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_FI_ICON_ADDED', false, [$fi_name]);
					$this->cache->destroy('_footericons');
				}
				else // edit
				{
					if ($icon_id)
					{
						$this->db->sql_query('UPDATE ' . $this->footericons_table . ' SET ' . $this->db->sql_build_array('UPDATE', [
							'fi_url' => $fi_url,
							'fi_name' => $fi_name,
							'fi_desc' => $fi_desc,
							'fi_open' => $fi_open,
							'fi_code' => $fi_code,
							'fi_color' => $fi_color,
							'fi_color_hover' => $fi_color_hover,
							'fi_bg' => $fi_bg,
							'fi_bgcolor' => $fi_bgcolor,
							'fi_bgcolor_hover' => $fi_bgcolor_hover,
							'fi_shadow_color' => $fi_shadow_color,
						]) . ' WHERE fi_id = ' . (int) $icon_id);
						$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_FI_ICON_UPDATED', false, [$fi_name]);
						$this->cache->destroy('_footericons');
					}
				}

				trigger_error($this->language->lang('ACP_FI_SAVED') . adm_back_link($this->u_action));
			}
		}

		$this->template->assign_vars(array_merge($icon_data, [
			'S_ERROR'						=> $has_errors,
			'ERROR_MSG'						=> $error_msg,
			'S_ADD_EDIT'					=> true,
			'PAGE_HEADING'					=> $action === 'add' ? $this->language->lang('ACP_FI_HEADING_ADD') : $this->language->lang('ACP_FI_HEADING_EDIT'),
			'U_ACTION'						=> $this->u_action . '&action=' . $action . ($icon_id ? '&fi_id=' . $icon_id : ''),
			'FI_EXT_PATH'					=> $this->ext_path,
			'FA_BRANDS_SUPPORT_STYLESHEET'	=> $this->ext_path . ext::FA_BRANDS_SUPPORT_PATH,
			'FA_BRANDS_ICONS_STYLESHEET'	=> $this->ext_path . ext::FA_BRANDS_ICONS_PATH,
		]));
	}

	/**
	 * Handle submission of general settings
	 */
	protected function settings_submission(string $form_key): void
	{
		if ($this->request->is_set_post('submit')) {
			if (!check_form_key($form_key)) {
				trigger_error('FORM_INVALID');
			}

			$this->config->set('footericons_enable', $this->request->variable('footericons_enable', 0));
			$this->config->set('footericons_position', $this->request->variable('footericons_position', 0));
			$this->config->set('footericons_align', $this->request->variable('footericons_align', ''));
			$this->config->set('footericons_size', $this->request->variable('footericons_size', ''));

			$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_FI_SETTINGS_UPDATED');
			trigger_error($this->language->lang('ACP_FI_SAVED') . adm_back_link($this->u_action));
		}
	}

	/**
	 * Handle actions: move, delete, add/edit
	 */
	protected function handle_action(string $action, int $icon_id, string $form_key): void
	{
		switch ($action)
		{
			case 'move_up':
			case 'move_down':
				if ($icon_id)
				{
					$this->footericons_service->move($icon_id, $action);
					$this->cache->destroy('_footericons');
					if ($this->request->is_ajax())
					{
						$json = new \phpbb\json_response();
						$json->send(['success' => true]);
					}

					redirect($this->u_action);
				}
			break;

			case 'delete':
				if ($icon_id)
				{
					$sql = 'SELECT fi_name FROM ' . $this->footericons_table . ' WHERE fi_id = ' . (int) $icon_id;
					$result = $this->db->sql_query($sql);
					$row = $this->db->sql_fetchrow($result);
					$this->db->sql_freeresult($result);

					$fi_name = $row['fi_name'] ?? $icon_id;

					if (confirm_box(true))
					{
						$this->footericons_service->delete($icon_id);
						$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_FI_ICON_DELETED', false, [$fi_name]);
						$this->cache->destroy('_footericons');

						if ($this->request->is_ajax())
						{
							$json = new \phpbb\json_response();
							$json->send([
								'success'		=> true,
								'MESSAGE_TITLE'	=> $this->language->lang('INFORMATION'),
								'MESSAGE_TEXT'  => $this->language->lang('ACP_FI_DELETED', $fi_name),
								'REFRESH_DATA'	=> ['time' => 3],
							]);
						}

						trigger_error($this->language->lang('ACP_FI_DELETED', $fi_name) . adm_back_link($this->u_action));
					}
					else
					{
						confirm_box(false, $this->language->lang('ACP_FI_DELETE_CONFIRM'), build_hidden_fields([
								'action'=> 'delete',
								'fi_id'	=> $icon_id,
							])
						);
					}
				}
			break;

			case 'add':
			case 'edit':
				$this->add_edit($action, $icon_id, $form_key);
			break;

			case 'apply_style':
				if ($icon_id)
				{
					if (confirm_box(true))
					{
						$this->apply_style($icon_id);
					}
					else
					{
						confirm_box(false, $this->language->lang('ACP_FI_APPLY_STYLE_CONFIRM'), build_hidden_fields([
							'action'	=> 'apply_style',
							'fi_id'		=> $icon_id,
						]));
					}
				}
			break;
		}
	}

	/**
	 * Apply style of one icon to all other icons
	 */
	protected function apply_style(int $icon_id): void
	{
		// Get selected icon style
		$sql = 'SELECT fi_color, fi_color_hover, fi_bg, fi_bgcolor, fi_bgcolor_hover, fi_shadow_color
				FROM ' . $this->footericons_table . ' WHERE fi_id = ' . (int)$icon_id;
		$result = $this->db->sql_query($sql);
		$style = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		if (!$style)
		{
			trigger_error($this->language->lang('ACP_FI_NOT_FOUND'));
		}

		// Apply style to other icons
		$this->db->sql_query('UPDATE ' . $this->footericons_table . ' SET ' . $this->db->sql_build_array('UPDATE', [
			'fi_color' => $style['fi_color'],
			'fi_color_hover' => $style['fi_color_hover'],
			'fi_bg' => (int) $style['fi_bg'],
			'fi_bgcolor' => $style['fi_bgcolor'],
			'fi_bgcolor_hover' => $style['fi_bgcolor_hover'],
			'fi_shadow_color' => $style['fi_shadow_color'],
		]) . ' WHERE fi_id <> ' . (int) $icon_id);

		$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_FI_STYLE_APPLIED', false);
		$this->cache->destroy('_footericons');

		if ($this->request->is_ajax())
		{
			$json = new \phpbb\json_response();
			$json->send([
				'success' => true,
				'MESSAGE_TITLE' => $this->language->lang('INFORMATION'),
				'MESSAGE_TEXT' => $this->language->lang('ACP_FI_STYLES_APPLIED'),
				'style' => $style,
				'REFRESH_DATA' => ['time' => 3, 'url' => $this->u_action],
			]);
		}

		trigger_error($this->language->lang('ACP_FI_STYLES_APPLIED') . adm_back_link($this->u_action));
	}

	/**
	 * Assign template variables
	 */
	protected function assign_template_vars(): void
	{
		$sql = 'SELECT * FROM ' . $this->footericons_table . ' ORDER BY fi_order';
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$row_icon_id = (int) $row['fi_id'];
			$this->template->assign_block_vars('fi_icons', [
				'FI_URL'			=> $row['fi_url'],
				'FI_NAME'			=> $row['fi_name'],
				'FI_DESC'			=> $row['fi_desc'],
				'FI_OPEN'			=> (int) $row['fi_open'],
				'FI_CODE'			=> $row['fi_code'],
				'FI_COLOR'			=> $row['fi_color'],
				'FI_COLOR_HOVER'	=> $row['fi_color_hover'],
				'FI_BG'				=> (int) $row['fi_bg'],
				'FI_BGCOLOR'		=> $row['fi_bgcolor'],
				'FI_BGCOLOR_HOVER'	=> $row['fi_bgcolor_hover'],
				'FI_SHADOW_COLOR'	=> $row['fi_shadow_color'],
				'FI_ID'				=> $row_icon_id,
				'U_MOVE_UP'			=> $this->u_action . '&amp;action=move_up&amp;fi_id=' . $row_icon_id,
				'U_MOVE_DOWN'		=> $this->u_action . '&amp;action=move_down&amp;fi_id=' . $row_icon_id,
				'U_EDIT'			=> $this->u_action . '&amp;action=edit&amp;fi_id=' . $row_icon_id,
				'U_DELETE'			=> $this->u_action . '&amp;action=delete&amp;fi_id=' . $row_icon_id,
				'U_APPLY_STYLE'		=> $this->u_action . '&amp;action=apply_style&amp;fi_id=' . $row_icon_id,
			]);
		}
		$this->db->sql_freeresult($result);

		$this->template->assign_vars([
			'PAGE_HEADING'					=> $this->language->lang('ACP_FI_HEADING_SETTINGS'),
			'FI_ENABLE'						=> (int) $this->config['footericons_enable'],
			'FI_POSITION'					=> $this->config['footericons_position'],
			'FI_ALIGN'						=> $this->config['footericons_align'],
			'FI_SIZE'						=> $this->config['footericons_size'],
			'FI_EXT_PATH'					=> $this->ext_path,
			'FA_BRANDS_SUPPORT_STYLESHEET'	=> $this->ext_path . ext::FA_BRANDS_SUPPORT_PATH,
			'FA_BRANDS_ICONS_STYLESHEET'	=> $this->ext_path . ext::FA_BRANDS_ICONS_PATH,
			'ICON_STYLE_APPLY'				=> '<i class="icon acp-icon acp-icon-resync fa-refresh fa-fw" title="' . $this->language->lang('ACP_FI_APPLY_STYLE') . '"></i>',
			'ICON_STYLE_APPLY_DISABLED'		=> '<i class="icon acp-icon acp-icon-disabled fa-refresh fa-fw" title="' . $this->language->lang('ACP_FI_APPLY_STYLE') . '"></i>',
		]);
	}

	/**
	 * Set custom form action.
	 *
	 * @param string	$u_action	Custom form action
	 * @return void
	 */
	public function set_page_url(string $u_action): void
	{
		$this->u_action = $u_action;
	}
}
