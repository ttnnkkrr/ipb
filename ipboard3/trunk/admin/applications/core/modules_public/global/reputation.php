<?php
/**
 * <pre>
 * Invision Power Services
 * IP.Board v3.1.2
 * Reputation
 * Last Updated: $Date: 2010-01-15 10:18:44 -0500 (Fri, 15 Jan 2010) $
 * </pre>
 *
 * @author 		$Author $
 * @copyright	(c) 2001 - 2009 Invision Power Services, Inc.
 * @license		http://www.invisionpower.com/community/board/license.html
 * @package		IP.Board
 * @subpackage	Core
 * @link		http://www.invisionpower.com
 * @version		$Rev: 5713 $
 *
 */

if ( ! defined( 'IN_IPB' ) )
{
	print "<h1>Incorrect access</h1>You cannot access this file directly. If you have recently upgraded, make sure you upgraded all the relevant files.";
	exit();
}

class public_core_global_reputation extends ipsCommand
{
	/**
	 * Class entry point
	 *
	 * @access	public
	 * @param	object		Registry reference
	 * @return	void		[Outputs to screen/redirects]
	 */
	public function doExecute( ipsRegistry $registry ) 
	{
		/* What to do... */
		switch( $this->request['do'] )
		{
			case 'add_rating':
				$this->doRating();
			break;
		}
	}
	
	/**
	 * Adds a rating to the index
	 *
	 * @access	public
	 * @return	void
	 */
	public function doRating()
	{
		/* INIT */
		$app     = $this->request['app_rate'];
		$type    = $this->request['type'];
		$type_id = intval( $this->request['type_id'] );
		$rating  = intval( $this->request['rating'] );
		
		/* Check */
		if( ! $app || ! $type || ! $type_id || ! $rating )
		{
			$this->registry->output->showError( 'reputation_missing_data', 10126 );
		}
		
		/* Check the secure key. Needed here to prevent direct URLs from increasing reps */
		if ( $this->request['secure_key'] != $this->member->form_hash )
		{
			$this->registry->output->showError( 'reputation_missing_data', 10126 );
		}
			
		/* Get the rep library */
		$classToLoad = IPSLib::loadLibrary( IPS_ROOT_PATH . 'sources/classes/class_reputation_cache.php', 'classReputationCache' );
		$repCache = new $classToLoad();
		
		/* Add the rating */
		if( ! $repCache->addRate( $type, $type_id, $rating, '', 0, $app ) )
		{
			$this->registry->output->showError( $repCache->error_message, 10127 );
		}
		else
		{
			/* Redirect to */
			$return_url = '';
			
			if( isset( $this->request['post_return'] ) && $this->request['post_return'] )
			{
				$return_url = $this->settings['base_url'] . 'app=forums&module=forums&section=findpost&pid=' . intval( $this->request['post_return'] );
			}
			else if( $_SERVER['HTTP_REFERER'] )
			{
				$return_url = $_SERVER['HTTP_REFERER'];
			}
			else
			{
				$return_url = $this->settings['base_url'];
			}
			
			/* Probably Temporary :) */
			$this->registry->output->silentRedirect( $return_url );
		}
	}
}