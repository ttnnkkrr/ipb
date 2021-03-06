<?php

/**
 * <pre>
 * Invision Power Services
 * IP.Board v3.1.2
 * CAPTCHA abstraction - easily create, check and display CAPTHCA images
 * Last Updated: $Date: 2010-01-15 10:18:25 -0500 (Fri, 15 Jan 2010) $
 * </pre>
 *
 * @author 		$Author: bfarber $
 * @copyright	(c) 2001 - 2009 Invision Power Services, Inc.
 * @license		http://www.invisionpower.com/community/board/license.html
 * @package		IP.Board
 * @subpackage	Kernel
 * @link		http://www.invisionpower.com
 * @since		Friday 19th May 2006 17:33
 * @version		$Revision: 370 $
 */

class classCaptcha
{
	/**
	 * Registry object
	 *
	 * @access	protected
	 * @var		object
	 */
	protected $registry;
	
	/**
	 * Database object
	 *
	 * @access	protected
	 * @var		object
	 */
	protected $DB;
	
	/**
	 * Settings object
	 *
	 * @access	protected
	 * @var		object
	 */
	protected $settings;
	
	/**
	 * Request object
	 *
	 * @access	protected
	 * @var		object
	 */
	protected $request;
	
	/**
	 * Language object
	 *
	 * @access	protected
	 * @var		object
	 */
	protected $lang;
	
	/**
	 * Member object
	 *
	 * @access	protected
	 * @var		object
	 */
	protected $member;
	
	/**
	 * Member data object
	 *
	 * @access	protected
	 * @var		object
	 */
	protected $memberData;	
	
	/**
	 * Plug in class
	 *
	 * @access	private
	 * @var		object
	 */
	private $_plugInClass;
	
	/**
	 * Constructor
	 *
	 * @access	public
	 * @param	object	ipsRegistry
	 * @return	void
	 */
	public function __construct( ipsRegistry $registry )
	{
		$this->registry = $registry;
		$this->DB       = $this->registry->DB();
		$this->settings =& $this->registry->fetchSettings();
		$this->request  =& $this->registry->fetchRequest();
		$this->lang     = $this->registry->getClass('class_localization');
		$this->member   = $this->registry->member();
		$this->memberData =& $this->registry->member()->fetchMemberData();
		
		$plugin = $this->settings['bot_antispam_type'];
		
		if ( ! file_exists( IPS_KERNEL_PATH . 'classCaptchaPlugin/' . $plugin . '.php' ) )
		{
			$plugin = 'default';
		}
	
		require_once( IPS_KERNEL_PATH . 'classCaptchaPlugin/' . $plugin . '.php' );
		$this->_plugInClass = new captchaPlugIn( $registry );
	}
	
	/**
	 * Magic Call method
	 *
	 * @param	string	Method Name
	 * @param	mixed	Method arguments
	 * @return   mixed
	 */
	public function __call( $method, $arguments )
	{
		if ( method_exists( $this->_plugInClass, $method ) )
		{
			return $this->_plugInClass->$method( $arguments );
		}
		else
		{
			trigger_error( $method . " does not exist", E_USER_ERROR );
		}
	}
	
	/**
	 * Magic __get method
	 *
	 * @access	public
	 * @param	mixed
	 * @return	mixed
	 */
	public function __get( $name )
	{
		if ( property_exists( $this->_plugInClass, $name ) )
		{
			return $this->_plugInClass->$name;
		}
		else
		{
			trigger_error( $name . " does not exist", E_USER_ERROR );
		}
	}

}
