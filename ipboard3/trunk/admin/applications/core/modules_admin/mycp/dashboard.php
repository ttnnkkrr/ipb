<?php

/**
 * <pre>
 * Invision Power Services
 * IP.Board v3.1.2
 * Dashboard
 * Last Updated: $Date: 2010-06-16 11:21:04 -0400 (Wed, 16 Jun 2010) $
 * </pre>
 *
 * @author 		$Author: mark $
 * @copyright	(c) 2001 - 2009 Invision Power Services, Inc.
 * @license		http://www.invisionpower.com/community/board/license.html
 * @package		IP.Board
 * @subpackage	Core
 * @link		http://www.invisionpower.com
 * @since		5th January 2005
 * @version		$Revision: 6541 $
 *
 */

if ( ! defined( 'IN_ACP' ) )
{
	print "<h1>Incorrect access</h1>You cannot access this file directly. If you have recently upgraded, make sure you upgraded 'admin.php'.";
	exit();
}

class admin_core_mycp_dashboard extends ipsCommand
{
	/**
	 * Skin object
	 *
	 * @access	private
	 * @var		object			Skin templates
	 */
	private $html;

	/**
	 * Shortcut for url
	 *
	 * @access	private
	 * @var		string			URL shortcut
	 */
	private $form_code;

	/**
	 * Shortcut for url (javascript)
	 *
	 * @access	private
	 * @var		string			JS URL shortcut
	 */
	private $form_code_js;

	/**
	 * Main class entry point
	 *
	 * @access	public
	 * @param	object		ipsRegistry reference
	 * @return	void		[Outputs to screen]
	 */
	public function doExecute( ipsRegistry $registry )
	{
		//-----------------------------------------
		// Load skin
		//-----------------------------------------

		$this->html = $this->registry->output->loadTemplate('cp_skin_mycp');

		//-----------------------------------------
		// Load language
		//-----------------------------------------

		$this->registry->getClass('class_localization')->loadLanguageFile( array( 'admin_mycp' ) );

		/* This is a little hacky, but we have to allow access to the whole module to get access to 
		   'change my details'.  This check just makes sure that we don't also get access to the Dashboard
		   if the permission system automatically added permission for 'change my details' */
		if( $this->registry->getClass('class_permissions')->editDetailsOnly )
		{
			ipsRegistry::getClass('output')->showError( 'no_permission', 1004 );
		}

		//-----------------------------------------
		// Set up stuff
		//-----------------------------------------

		$this->form_code	= $this->html->form_code	= 'module=mycp&amp;section=dashboard';
		$this->form_code_js	= $this->html->form_code_js	= 'module=mycp&section=dashboard';

		//-----------------------------------------
		// INIT
		//-----------------------------------------

		define( 'IPS_NEWS_URL'			, 'http://external.ipslink.com/globalfeeds/news/' );
		define( 'IPS_BULLETINS_URL'		, 'http://external.ipslink.com/ipbfeeds/300/staffbulletin/' );
		define( 'IPS_VERSION_CHECK_URL'	, 'http://www.invisionpower.com/latestversioncheck/ipb30x.php' );

		$content         	= array();
		$thiscontent     	= "";
   		$latest_version  	= array();
   		$reg_end         	= "";
		$unfinished_upgrade	= 0;
		$urls               = array( 'news'          => IPS_NEWS_URL,
									 'keiths_bits'   => IPS_BULLETINS_URL,
									 'version_check' => IPS_VERSION_CHECK_URL,
									 'blogs'         => 'http://external.ipslink.com/globalfeeds/blog/' );

		//-----------------------------------------
		// Get MySQL & PHP Version
		//-----------------------------------------

		$this->DB->getSqlVersion();

   		//-----------------------------------------
   		// Upgrade history?
   		//-----------------------------------------

   		$latest_version = array( 'upgrade_version_id' => NULL );

   		$this->DB->build( array( 'select' => '*', 'from' => 'upgrade_history', 'order' => 'upgrade_version_id DESC', 'limit' => array(1) ) );
   		$this->DB->execute();

   		while( $r = $this->DB->fetch() )
   		{
			$latest_version = $r;
   		}

		//-----------------------------------------
		// Resetting security image?
		//-----------------------------------------

		if ( $this->request['reset_security_flag'] AND $this->request['reset_security_flag'] == 1 AND $this->request['new_build'] )
		{
			$_latest	 = IPSLib::fetchVersionNumber('core');
			$new_build   = intval( $this->request['new_build'] );
			$new_reason  = trim( substr( $this->request['new_reason'], 0, 1 ) );
			$new_version = $_latest['long'].'.'.$new_build.'.'.$new_reason;

			$this->DB->update( 'upgrade_history', array( 'upgrade_notes' => $new_version ), 'upgrade_version_id='.$latest_version['upgrade_version_id'] );

			$latest_version['upgrade_notes'] = $new_version;
		}

		//-----------------------------------------
		// Got real version number?
		//-----------------------------------------

		ipsRegistry::$version = 'v'.$latest_version['upgrade_version_human'];
		ipsRegistry::$vn_full = ( isset($latest_version['upgrade_notes']) AND $latest_version['upgrade_notes'] ) ? $latest_version['upgrade_notes'] : ipsRegistry::$vn_full;

		//-----------------------------------------
		// Licensed?
		//-----------------------------------------

		$urls['keiths_bits'] = IPS_BULLETINS_URL . '?v=' . ipsRegistry::$vn_full;

		//-----------------------------------------
		// Notepad
		//-----------------------------------------

		if ( $this->request['save'] AND $this->request['save'] == 1 )
		{
			$_POST['notes'] = $_POST['notes'] ? $_POST['notes'] : $this->lang->words['cp_acpnotes'];
			$this->cache->setCache( 'adminnotes', IPSText::stripslashes($_POST['notes']), array( 'donow' => 1, 'array' => 0 ) );
		}

		$text = $this->lang->words['cp_acpnotes'];

		if ( !$this->cache->getCache('adminnotes') )
		{
			$this->cache->setCache( 'adminnotes', $text, array( 'donow' => 1, 'array' => 0 ) );
		}

		$this->cache->updateCacheWithoutSaving( 'adminnotes', htmlspecialchars($this->cache->getCache('adminnotes'), ENT_QUOTES) );
		$this->cache->updateCacheWithoutSaving( 'adminnotes', str_replace( "&amp;#", "&#", $this->cache->getCache('adminnotes') ) );

		$content['ad_notes'] = $this->html->acp_notes( $this->cache->getCache('adminnotes') );

		//-----------------------------------------
		// ADMINS USING CP
		//-----------------------------------------

		$t_time    = time() - 60*10;
		$time_now  = time();
		$seen_name = array();
		$acponline = "";

		$this->DB->build( array(
								'select'   => 's.session_member_name, s.session_member_id, s.session_location, s.session_log_in_time, s.session_running_time, s.session_ip_address, s.session_url',
								'from'     => array( 'core_sys_cp_sessions' => 's' ),
								'add_join' => array( array(  'select' => 'm.*',
															'from'   => array( 'members' => 'm' ),
															'where'  => "m.member_id=s.session_member_id",
															'type'   => 'left'
														),
													 array(  'select' => 'pp.*',
															'from'   => array( 'profile_portal' => 'pp' ),
															'where'  => 'pp.pp_member_id=m.member_id',
															'type'   => 'left'
														)  )  )	);

		$q = $this->DB->execute();

		while ( $r = $this->DB->fetch( $q ) )
		{
			if ( isset($seen_name[ $r['session_member_name'] ]) AND $seen_name[ $r['session_member_name'] ] == 1 )
			{
				continue;
			}
			else
			{
				$seen_name[ $r['session_member_name'] ] = 1;
			}

			$r['_log_in'] = $time_now - $r['session_log_in_time'];
			$r['_click']  = $time_now - $r['session_running_time'];

			if ( ($r['_log_in'] / 60) < 1 )
			{
				$r['_log_in'] = sprintf("%0d", $r['_log_in']) . $this->lang->words['cp_secondsago'];
			}
			else
			{
				$r['_log_in'] = sprintf("%0d", ($r['_log_in'] / 60) ) . $this->lang->words['cp_minutesago'];
			}

			if ( ($r['_click'] / 60) < 1 )
			{
				$r['_click'] = sprintf("%0d", $r['_click']) . $this->lang->words['cp_secondsago'];
			}
			else
			{
				$r['_click'] = sprintf("%0d", ($r['_click'] / 60) ) . $this->lang->words['cp_minutesago'];
			}

			$r['session_location'] = $r['session_location'] ? "<a href='" . preg_replace( '/&amp;app=([a-zA-Z0-9\-_]+)/', '', $this->settings['base_url'] ) . $r['session_url'] . "'>{$r['session_location']}</a>" : $this->lang->words['cp_index'];

			$acponline .= $this->html->acp_onlineadmin_row( IPSMember::buildDisplayData( $r ) );
		}

		$content['acp_online'] = $this->html->acp_onlineadmin_wrapper( $acponline );

		//-----------------------------------------
		// Members awaiting admin validation?
		//-----------------------------------------

		if( $this->settings['reg_auth_type'] == 'admin_user' OR $this->settings['reg_auth_type'] == 'admin' )
		{
			$where_extra = $this->settings['reg_auth_type'] == 'admin_user' ? ' AND user_verified=1' : '';

			$admin_reg	= $this->DB->buildAndFetch( array( 'select' => 'COUNT(*) as reg'  , 'from' => 'validating', 'where' => 'new_reg=1' . $where_extra ) );

			if( $admin_reg['reg'] > 0 )
			{
				// We have some member's awaiting admin validation
				$data = null;

				$this->DB->build( array(
											'select' 	=> 'v.*',
											'from'		=> array( 'validating' => 'v' ),
											'where'	=> 'new_reg=1' . $where_extra,
											'limit'	=> array( 3 ),
											'add_join'	=> array(
											 					array(
																		'type'		=> 'left',
														 				'select'	=> 'm.members_display_name, m.email, m.ip_address',
														 				'from'		=> array( 'members' => 'm' ),
														 				'where'		=> 'm.member_id=v.member_id'
														 			)
														 		)
								)	);
				$this->DB->execute();

				while( $r = $this->DB->fetch() )
				{
					if ($r['coppa_user'] == 1)
					{
						$r['_coppa'] = ' ( COPPA )';
					}
					else
					{
						$r['_coppa'] = "";
					}

					$r['_entry']  = $this->registry->getClass( 'class_localization')->getDate( $r['entry_date'], 'TINY' );

					$data .= $this->html->acp_validating_block( $r );


				}

				$content['validating'] = $this->html->acp_validating_wrapper( $data );
			}
		}

		//-----------------------------------------
		// Forum and group dropdowns
		//-----------------------------------------

		require_once( IPSLib::getAppDir( 'forums' ) . '/sources/classes/forums/class_forums.php' );
		$this->registry->setClass( 'class_forums', new class_forums($this->registry) );
		$this->registry->getClass('class_forums')->forumsInit();

		$forums 		= $this->registry->getClass('class_forums')->forumsForumJump( 1 );

		$groups			= array();
		$groups_html 	= '';

		foreach( $this->cache->getCache('group_cache') as $k => $v )
		{
			$groups[ $v['g_title'] ] = "<option value='{$k}'>{$v['g_title']}</option>";
		}

		ksort( $groups );

		$groups_html = implode( "\n", $groups );

		//-----------------------------------------
		// Piece it together
		//-----------------------------------------

		$urls['version_check'] = IPS_VERSION_CHECK_URL . '?' . base64_encode( ipsRegistry::$vn_full.'|^|'.$this->settings['board_url'] );
		$this->registry->output->html .= $this->html->mainTemplate( $content, $forums, $groups_html, $urls, $this->getNotificationPanelEntries() );

		//-----------------------------------------
		// Left log all on?
		//-----------------------------------------

		if ( IPS_LOG_ALL === TRUE )
		{
			$_html = $this->html->warning_box( $this->lang->words['ds_log_all_title'], $this->lang->words['ds_log_all_desc'] ) . "<br />";
			$this->registry->output->html = str_replace( '<!--in_dev_check-->', $_html . '<!--in_dev_check-->', $this->registry->output->html );
		}

		//-----------------------------------------
		// IN DEV stuff...
		//-----------------------------------------

		if ( IN_DEV )
		{
			$lastUpdate     = $this->caches['indev'];
			$lastUpdate     = ( is_array( $lastUpdate ) ) ? $lastUpdate : array( 'import' => array( 'settings' => array() ) );
			$lastModUpdate  = ( is_array( $lastUpdate ) ) ? $lastUpdate : array( 'import' => array( 'modules'  => array() ) );
			$lastTaskUpdate = ( is_array( $lastUpdate ) ) ? $lastUpdate : array( 'import' => array( 'tasks'    => array() ) );
			$lastHelpUpdate = ( is_array( $lastUpdate ) ) ? $lastUpdate : array( 'import' => array( 'help'     => array() ) );
			$lastbbUpdate   = ( is_array( $lastUpdate ) ) ? $lastUpdate : array( 'import' => array( 'bbcode'   => array() ) );
			$content        = array();
			$modContent     = array();
			$tasksContent	= array();
			$helpContent    = array();
			$bbContent      = array();
						$_html          = '';

			foreach( ipsRegistry::$applications as $app_dir => $data )
			{
				/* Settings */
				$lastMtime  = intval( @filemtime( IPSLib::getAppDir( $app_dir ) . '/xml/' . $app_dir . '_settings.xml' ) );
				$lastDBtime = intval( $lastUpdate['import']['settings'][ $app_dir ] );

				if ( $lastMtime > $lastDBtime )
				{
					$_mtime  = $this->registry->getClass( 'class_localization')->getDate( $lastMtime , 'JOINED' );
					$_dbtime = $this->registry->getClass( 'class_localization')->getDate( $lastDBtime, 'JOINED' );

					$content[] = "<strong>" . $app['app_title'] . " {$this->lang->words['cp_settingsupdated']}.</strong><br />-- {$this->lang->words['cp_lastimportrun']}: {$_dbtime}<br />-- {$this->lang->words['cp_lastxmlexport']}: {$_mtime}";
				}

				/* Modules */
				$lastMtime  = intval( @filemtime( IPSLib::getAppDir( $app_dir ) . '/xml/' . $app_dir . '_modules.xml' ) );
				$lastDBtime = intval( $lastUpdate['import']['modules'][ $app_dir ] );

				if ( $lastMtime > $lastDBtime )
				{
					$_mtime  = $this->registry->getClass( 'class_localization')->getDate( $lastMtime , 'JOINED' );
					$_dbtime = $this->registry->getClass( 'class_localization')->getDate( $lastDBtime, 'JOINED' );

					$modContent[] = "<strong>" . $app['app_title'] . " {$this->lang->words['cp_modulessneedup']}.</strong><br />-- {$this->lang->words['cp_lastimportrun']}: {$_dbtime}<br />-- {$this->lang->words['cp_lastxmlexport']}: {$_mtime}";
				}

				/* Tasks */
				$lastMtime  = intval( @filemtime( IPSLib::getAppDir( $app_dir ) . '/xml/' . $app_dir . '_tasks.xml' ) );
				$lastDBtime = intval( $lastUpdate['import']['tasks'][ $app_dir ] );

				if ( $lastMtime > $lastDBtime )
				{
					$_mtime  = $this->registry->getClass( 'class_localization')->getDate( $lastMtime , 'JOINED' );
					$_dbtime = $this->registry->getClass( 'class_localization')->getDate( $lastDBtime, 'JOINED' );

					$tasksContent[] = "<strong>" . $app['app_title'] . " {$this->lang->words['cp_taskssneedup']}.</strong><br />-- {$this->lang->words['cp_lastimportrun']}: {$_dbtime}<br />-- {$this->lang->words['cp_lastxmlexport']}: {$_mtime}";
				}

				/* Help Files */
				$lastMtime  = intval( @filemtime( IPSLib::getAppDir( $app_dir ) . '/xml/' . $app_dir . '_help.xml' ) );
				$lastDBtime = intval( $lastUpdate['import']['help'][ $app_dir ] );

				if ( $lastMtime > $lastDBtime )
				{
					$_mtime  = $this->registry->getClass( 'class_localization')->getDate( $lastMtime , 'JOINED' );
					$_dbtime = $this->registry->getClass( 'class_localization')->getDate( $lastDBtime, 'JOINED' );

					$helpContent[] = "<strong>" . $app['app_title'] . " {$this->lang->words['cp_helpneedup']}.</strong><br />-- {$this->lang->words['cp_lastimportrun']}: {$_dbtime}<br />-- {$this->lang->words['cp_lastxmlexport']}: {$_mtime}";
				}

				/* BBCode Files */
				$lastMtime  = intval( @filemtime( IPSLib::getAppDir( $app_dir ) . '/xml/' . $app_dir . '_bbcode.xml' ) );
				$lastDBtime = intval( $lastUpdate['import']['bbcode'][ $app_dir ] );

				if ( $lastMtime > $lastDBtime )
				{
					$_mtime  = $this->registry->getClass( 'class_localization')->getDate( $lastMtime , 'JOINED' );
					$_dbtime = $this->registry->getClass( 'class_localization')->getDate( $lastDBtime, 'JOINED' );

					$bbContent[] = "<strong>" . $app['app_title'] . " {$this->lang->words['cp_bbcodeneedup']}.</strong><br />-- {$this->lang->words['cp_lastimportrun']}: {$_dbtime}<br />-- {$this->lang->words['cp_lastxmlexport']}: {$_mtime}";
				}
			}

			if ( count( $content ) )
			{
				$_html = $this->html->warning_box( $this->lang->words['cp_settingsneedup'], implode( $content, "<br />" ) . "<br /><a href='" . $this->settings['base_url'] . "app=core&amp;module=tools&amp;section=settings&amp;do=settingsImportApps'>{$this->lang->words['cp_clickhere']}</a> {$this->lang->words['cp_clickhere_info']}.");
			}

			if ( count( $modContent ) )
			{
				$_html .= $this->html->warning_box( $this->lang->words['cp_modulessneedup'], implode( $modContent, "<br />" ) . "<br /><a href='" . $this->settings['base_url'] . "app=core&amp;module=applications&amp;section=applications&amp;do=inDevRebuildAll'>{$this->lang->words['cp_clickhere']}</a> {$this->lang->words['cp_clickhere_info']}.");
			}

			if ( count( $tasksContent ) )
			{
				$_html .= $this->html->warning_box( $this->lang->words['cp_taskssneedup'], implode( $tasksContent, "<br />" ) . "<br /><a href='" . $this->settings['base_url'] . "app=core&amp;module=system&amp;section=taskmanager&amp;do=tasksImportAllApps'>{$this->lang->words['cp_clickhere']}</a> {$this->lang->words['cp_clickhere_info']}.");
			}

			if ( count( $helpContent ) )
			{
				$_html .= $this->html->warning_box( $this->lang->words['cp_helpneedup'], implode( $helpContent, "<br />" ) . "<br /><a href='" . $this->settings['base_url'] . "app=core&amp;module=tools&amp;section=help&amp;do=importXml'>{$this->lang->words['cp_clickhere']}</a> {$this->lang->words['cp_clickhere_info']}.");
			}

			if ( count( $bbContent ) )
			{
				$_html .= $this->html->warning_box( $this->lang->words['cp_bbcodeneedup'], implode( $bbContent, "<br />" ) . "<br /><a href='" . $this->settings['base_url'] . "app=core&amp;module=posts&amp;section=bbcode&amp;do=bbcode_import_all'>{$this->lang->words['cp_clickhere']}</a> {$this->lang->words['cp_clickhere_info']}.");
			}

			$this->registry->output->html = str_replace( '<!--in_dev_check-->', $_html, $this->registry->output->html );

			if ( @file_exists( DOC_IPS_ROOT_PATH . '_dev_notes.txt' ) )
			{
				$_notes = @file_get_contents( DOC_IPS_ROOT_PATH . '_dev_notes.txt' );

				if ( $_notes )
				{
					$_html = $this->registry->output->global_template->information_box( $this->lang->words['cp_devnotes'], nl2br($_notes) ) . "<br />";
					$this->registry->output->html = str_replace( '<!--in_dev_notes-->', $_html, $this->registry->output->html );
				}
			}
		}

		//-----------------------------------------
		// Last 5 log in attempts
		//-----------------------------------------

		$this->registry->getClass('class_permissions')->return	= true;

		if( $this->registry->getClass('class_permissions')->checkPermission( 'acplogin_log' ) )
		{
			$this->DB->build( array(
										'select' => '*',
										'from'   => 'admin_login_logs',
										'where'	 => 'admin_time > 0',		// This just helps mysql use the index properly, which is useful for sorting
										'order'  => 'admin_time DESC',
										'limit'  => array( 0, 5 )
							)	);

			$this->DB->execute();

			while ( $rowb = $this->DB->fetch() )
			{
				$rowb['_admin_time'] = $this->registry->class_localization->getDate( $rowb['admin_time'], 'long' );
				$rowb['_admin_img']  = $rowb['admin_success'] ? 'aff_tick.png' : 'aff_cross.png';

				$logins .= $this->html->acp_last_logins_row( $rowb );
			}

			$this->registry->output->html = str_replace( '<!--acplogins-->', $this->html->acp_last_logins_wrapper( $logins ), $this->registry->output->html );
		}

		//-----------------------------------------
		// Pass to CP output hander
		//-----------------------------------------

		$this->registry->getClass('output')->html_main .= $this->registry->getClass('output')->global_template->global_frame_wrapper();
		$this->registry->getClass('output')->sendOutput();
	}
	
	/**
	 * Builds a list of nag panel entries
	 *
	 * @access	public
	 * @return	array
	 */
	public function getNotificationPanelEntries()
	{
		/* INIT */
		$entries = array();
		
		/* Look for notification classes */
		foreach( ipsRegistry::$applications as $r )
		{
			/* Notification Class */
			$_file	= IPSLib::getAppDir( $r['app_directory'] ) . '/extensions/dashboardNotifications.php';
			$_class = 'dashboardNotifications__' . $r['app_directory'];
			
			/* Look for the file */
			if( file_exists( $_file ) )
			{
				/* Get the file */
				require_once( $_file );
				
				/* Look for the class */
				if( class_exists( $_class ) )
				{
					/* Create the object */
					$notifyObj = new $_class;
					
					/* Look for the method */
					if( method_exists( $notifyObj, 'get' ) )
					{
						/* Get the entries */
						$_entries = $notifyObj->get();
						
						if( is_array( $_entries ) && count( $_entries ) )
						{
							$entries = array_merge( $entries, $_entries );
						}
					}
				}
			}
		}

		/* Return entries */
		return $entries;
	}
}