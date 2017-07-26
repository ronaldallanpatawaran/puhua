<?php
//==============================================================================
// MailChimp Integration Pro v201.2
// 
// Author: Clear Thinking, LLC
// E-mail: johnathan@getclearthinking.com
// Website: http://www.getclearthinking.com
// 
// All code within this file is copyright Clear Thinking, LLC.
// You may not copy or reuse code within this file without written permission.
//==============================================================================

	//------------------------------------------------------------------------------
	// Data Arrays
	//------------------------------------------------------------------------------
	$data['entry_listid'] = $data['pro_entry_listid'];
	$data['heading_title'] = $data['pro_heading_title'];
	
	$data['rule_options'] = array(
		'order_criteria' => array('currency', 'customer_group', 'language', 'store'),
	);
	
	if (!empty($data['saved']['apikey'])) {
		foreach ($data['mailchimp_lists'] as $list_id => $list_name) {
			if (!$list_id) continue;
			$data['merge_tags'][$list_id] = $mailchimp_integration->getMergeTags($list_id);
			$data['interest_groups'][$list_id] = $mailchimp_integration->getInterestGroups($list_id);
		}
	}
	
	$customer_fields = array('' => $data['text_leave_blank']);
	foreach (array('address', 'customer') as $table) {
		$customer_fields[$table] = '';
		$columns = array();
		foreach ($this->db->query("DESCRIBE " . DB_PREFIX . $table)->rows as $column) {
			$columns[$table . ':' . $column['Field']] = $column['Field'];
		}
		asort($columns);
		$customer_fields = array_merge($customer_fields, $columns);
	}
	
	//------------------------------------------------------------------------------
	// List Settings
	//------------------------------------------------------------------------------
	$data['settings'][] = array(
		'type'		=> 'html',
		'content'	=> '<div class="text-info text-center" style="padding-bottom: 20px">' . $data['pro_help_list_mapping'] . '</div>',
	);
	
	$table = 'mapping';
	$sortby = 'list';
	$data['settings'][] = array(
		'key'		=> $table,
		'type'		=> 'table_start',
		'columns'	=> array('action', 'list', 'rules'),
	);
	foreach ($this->getTableRowNumbers($data, $table, $sortby) as $num => $rules) {
		$prefix = $table . '_' . $num . '_';
		$data['settings'][] = array(
			'type'		=> 'row_start',
		);
		$data['settings'][] = array(
			'key'		=> 'delete',
			'type'		=> 'button',
		);
		$data['settings'][] = array(
			'type'		=> 'column',
		);
		$data['settings'][] = array(
			'key'		=> $prefix . 'list',
			'type'		=> 'select',
			'options'	=> $data['mailchimp_lists'],
		);
		$data['settings'][] = array(
			'type'		=> 'column',
		);
		$data['settings'][] = array(
			'key'		=> $prefix . 'rule',
			'type'		=> 'rule',
			'rules'		=> $rules,
		);
		$data['settings'][] = array(
			'type'		=> 'row_end',
		);
	}
	$data['settings'][] = array(
		'type'		=> 'table_end',
		'buttons'	=> 'add_row',
		'text'		=> 'button_add_mapping',
	);
	
	//------------------------------------------------------------------------------
	// Merge Tags
	//------------------------------------------------------------------------------
	$data['settings'][] = array(
		'key'		=> 'merge_tags',
		'type'		=> 'tab',
	);
	$data['settings'][] = array(
		'key'		=> 'merge_tags',
		'type'		=> 'heading',
	);
	$data['settings'][] = array(
		'type'		=> 'html',
		'content'	=> '<div class="text-info text-center" style="padding-bottom: 20px">' . $data['pro_help_merge_tags'] . '</div>',
	);
	if (!empty($data['merge_tags'])) {
		foreach ($data['merge_tags'] as $list_id => $merge_tags) {
			$data['settings'][] = array(
				'type'		=> 'html',
				'content'	=> '<hr />',
			);
			foreach ($merge_tags as $merge) {
				if ($merge['tag'] == 'EMAIL') {
					continue;
				} elseif ($merge['tag'] == 'FNAME') {
					$default = 'customer:firstname';
				} elseif ($merge['tag'] == 'LNAME') {
					$default = 'customer:lastname';
				} elseif ($merge['tag'] == 'ADDRESS') {
					$default = 'customer:address_id';
				} elseif ($merge['tag'] == 'PHONE') {
					$default = 'customer:telephone';
				} else {
					$default = '';
				}
				$data['settings'][] = array(
					'key'		=> $list_id . '_' . $merge['tag'],
					'title'		=> $data['mailchimp_lists'][$list_id] . ' - ' . $merge['tag'] . ':',
					'type'		=> 'select',
					'options'	=> $customer_fields,
					'default'	=> $default,
				);
			}
		}
	}
	
	//------------------------------------------------------------------------------
	// Interest Groups
	//------------------------------------------------------------------------------
	$data['settings'][] = array(
		'key'		=> 'interest_groups',
		'type'		=> 'tab',
	);
	$data['settings'][] = array(
		'key'		=> 'interest_groups',
		'type'		=> 'heading',
	);
	$data['settings'][] = array(
		'type'		=> 'html',
		'content'	=> '<div class="text-info text-center" style="padding-bottom: 20px">' . $data['pro_help_interestgroups'] . '</div>',
	);
	$data['settings'][] = array(
		'key'		=> 'interest_groups',
		'type'		=> 'select',
		'options'	=> array(0 => $data['text_no'], 1 => $data['text_yes']),
	);
	$data['settings'][] = array(
		'key'		=> 'display_routes',
		'type'		=> 'textarea',
	);
	$data['settings'][] = array(
		'key'		=> 'moduletext_interestgroups',
		'type'		=> 'multilingual_text',
		'default'	=> 'Please choose your interests below',
	);
	$data['settings'][] = array(
		'key'		=> 'moduletext_updatebutton',
		'type'		=> 'multilingual_text',
		'default'	=> 'Update',
	);
	$data['settings'][] = array(
		'key'		=> 'moduletext_updated',
		'type'		=> 'multilingual_text',
		'default'	=> 'Your interests have been successfully updated.',
	);
	if (isset($data['interest_groups'])) {
		foreach ($data['interest_groups'] as $list_id => $interest_groups) {
			if (empty($interest_groups)) continue;
			$data['settings'][] = array(
				'type'		=> 'heading',
				'text'		=> '"' . $data['mailchimp_lists'][$list_id] . '" ' . $data['heading_interest_groups'],
			);
			$data['settings'][] = array(
				'type'		=> 'html',
				'content'	=> '<div class="text-info text-center" style="padding-bottom: 5px">' . $data['help_interestgroup_text'] . '</div>',
			);
			foreach ($interest_groups as $interest_group) {
				$data['settings'][] = array(
					'type'		=> 'html',
					'content'	=> '<hr />',
				);
				$data['settings'][] = array(
					'key'		=> $list_id . '_' . $interest_group['id'],
					'title'		=> '<strong>"' . $interest_group['name'] . '" ' . $data['entry_group_title'] . '</strong>',
					'type'		=> 'multilingual_text',
					'default'	=> $interest_group['name'],
				);
				foreach ($interest_group['groups'] as $group) {
					$data['settings'][] = array(
						'key'		=> $list_id . '_' . $interest_group['id'] . '_' . $group['id'],
						'title'		=> '"' . $group['name'] . '" ' . $data['entry_option'],
						'type'		=> 'multilingual_text',
						'default'	=> $group['name'],
					);
				}
			}
		}
	}
	
	//------------------------------------------------------------------------------
	// Module Settings
	//------------------------------------------------------------------------------
	$data['settings'][] = array(
		'key'		=> 'module_settings',
		'type'		=> 'tab',
	);
	$data['settings'][] = array(
		'key'		=> 'module_settings',
		'type'		=> 'heading',
	);
	$data['settings'][] = array(
		'type'		=> 'html',
		'content'	=> '<div class="text-info text-center" style="padding-bottom: 20px">' . $data['help_module_settings'] . '</div>',
	);
	foreach (array('firstname', 'lastname', 'telephone', 'address', 'city', 'postcode') as $field) {
		$data['settings'][] = array(
			'key'		=> 'modules_' . $field,
			'type'		=> 'select',
			'options'	=> array('hide' => $data['text_hide'], 'optional' => $data['text_optional'], 'required' => $data['text_required']),
		);
	}
	$data['settings'][] = array(
		'key'		=> 'modules_zone',
		'type'		=> 'select',
		'options'	=> array('hide' => $data['text_hide'], 'show' => $data['text_show']),
	);
	$data['settings'][] = array(
		'key'		=> 'modules_country',
		'type'		=> 'select',
		'options'	=> array('hide' => $data['text_hide'], 'show' => $data['text_show']),
	);
	