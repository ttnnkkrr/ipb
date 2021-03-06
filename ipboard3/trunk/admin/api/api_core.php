<?php

/**
 * <pre>
 * Invision Power Services
 * IP.Board v3.1.2
 * API: Core
 * Last Updated: $Date: 2010-01-15 10:18:44 -0500 (Fri, 15 Jan 2010) $
 * </pre>
 *
 * @author 		$Author: bfarber $
 * @copyright	(c) 2001 - 2009 Invision Power Services, Inc.
 * @license		http://www.invisionpower.com/community/board/license.html
 * @package		IP.Board
 * @link		http://www.invisionpower.com
 * @version		$Rev: 5713 $
 */

class apiCore
{
	/**
	 * Registry Object Shortcuts
	 */
	protected $DB;
	protected $settings;
	protected $request;
	protected $lang;
	protected $member;
	protected $cache;	
	protected $registry;
	
	/**
	 * API Error string
	 *
	 * @var array Errors
	 */
	public $api_error = array();

	/**
	 * API Path to IPB root (where init.php/index.php is)
	 *
	 * @var string Path to IPB root folder
	 */
	public $path_to_ipb = '';

	/**
	 * Loads the API Classes
	 *
	 * @return void
	 */
	public function init()
	{
		if( !$this->path_to_ipb )
		{
			if( defined('DOC_IPS_ROOT_PATH') )
			{
				$this->path_to_ipb	= DOC_IPS_ROOT_PATH;
			}
			else
			{
				$this->path_to_ipb = dirname(__FILE__) . '/../../';
			}
		}
		
		/* Load the registry */
		require_once( $this->path_to_ipb . 'initdata.php' );
		require_once( $this->path_to_ipb . CP_DIRECTORY . '/sources/base/ipsRegistry.php' );
		
		$this->registry = ipsRegistry::instance();
		$this->registry->init();
		
		/* Make Shortcuts */
		$this->DB       = $this->registry->DB();
		$this->settings =& $this->registry->fetchSettings();
		$this->request  =& $this->registry->fetchRequest();
		$this->lang     = $this->registry->getClass('class_localization');
		$this->member   = $this->registry->member();
		$this->memberData =& $this->registry->member()->fetchMemberData();
		$this->cache    = $this->registry->cache();
		$this->caches   =& $this->registry->cache()->fetchCaches();
		
		/* INIT Child? */
		if( method_exists( $this, 'childInit' ) )
		{
			$this->childInit();
		}
	}
}