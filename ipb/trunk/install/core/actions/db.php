<?php
/**
 * Invision Power Board
 * Action controller for DB page
 */

class action_db
{
	var $install;
	
	function action_db( & $install )
	{
		$this->install =& $install;
	}
	
	function run()
	{
		if( isset($this->install->ipsclass->input['db_pre']) )
		{
			$this->install->ipsclass->input['db_pre'] = strtolower($this->install->ipsclass->input['db_pre']);
		}

		/* Check input? */
		if ( $this->install->ipsclass->input['sub'] == 'check' )
		{
			/* Make sure the fields were filled out */			
			if ( ! $this->install->ipsclass->input['db_host'] || ! $this->install->ipsclass->input['db_name'] || ! $this->install->ipsclass->input['db_user'] )
			{
				$errors[] = '您必须完成表格中的全部内容';
			}
			
			//-----------------------------------------
			// Error check
			//-----------------------------------------
			
			if ( is_array( $errors ) )
			{
				$this->install->template->warning( $errors );
				return;
			}
			
			//-----------------------------------------
			// Load DB driver..
			//-----------------------------------------
			
			require_once( INS_KERNEL_PATH . 'class_db_' . $this->install->saved_data['sql_driver'] . '.php' );
			
			$classname = "db_driver_".$this->install->saved_data['sql_driver'];

			$DB = new $classname;

			$DB->obj['sql_database']   = $this->install->ipsclass->input['db_name'];
			$DB->obj['sql_user']	   = $this->install->ipsclass->input['db_user'];
			$DB->obj['sql_pass']	   = $_REQUEST['db_pass'];
			$DB->obj['sql_host']	   = $this->install->ipsclass->input['db_host'];
			$DB->obj['sql_tbl_prefix'] = $this->install->ipsclass->input['db_pre'];
			
			//--------------------------------------------------
			// Any "extra" configs required for this driver?
			//--------------------------------------------------

			if ( file_exists( INS_ROOT_PATH.'sql/'.$this->install->saved_data['sql_driver'].'_install.php' ) )
			{
				require_once( INS_ROOT_PATH.'sql/'.$this->install->saved_data['sql_driver'].'_install.php' );

				$extra_install           =  new install_extra();
				$extra_install->ipsclass =& $this->install->ipsclass;

				$extra_install->install_form_process();

				if ( count( $extra_install->errors ) )
				{
					$this->install->template->warning( implode( "<br />", $extra_install->errors ) );
				}
				
				if ( is_array( $extra_install->info_extra ) and count( $extra_install->info_extra ) )
				{ 
					foreach( $extra_install->info_extra as $k => $v )
					{
						$this->install->saved_data[ '__sql__' . $k ] = $v;
					}
				}
				
				if ( is_array( $DB->connect_vars ) and count( $DB->connect_vars ) )
				{
					foreach( $DB->connect_vars as $k => $v )
					{
						$DB->connect_vars[ $k ] = $extra_install->info_extra[ $k ];
					}
				}
			}
			
			//-----------------------------------------
			// Error check
			//-----------------------------------------
			
			if ( is_array( $errors ) )
			{
				$this->install->template->warning( $errors );
				return;
			}
			
			//--------------------------------
			// Make CONSTANT
			//--------------------------------
			
			define( 'SQL_DRIVER'              , $this->install->saved_data['sql_driver'] );
			define( 'IPS_MAIN_DB_CLASS_LOADED', TRUE );

			//--------------------------------
			// Try a DB connection
			//--------------------------------
			
			$DB->return_die = 1;

			if ( ! $DB->connect() )
			{
				$errors[] = $DB->error;
				
				if( !count($errors) )
				{
					$errors[] = "您的数据库服务器连接有问题. 请检查您的设置信息然后重试.";
				}
			}
			
			//-----------------------------------------
			// Error check
			//-----------------------------------------
			
			if ( is_array( $errors ) )
			{
				$this->install->template->warning( $errors );
				return;
			}
			
			/* Save Form Data */
			$this->install->saved_data['db_host']       = $this->install->ipsclass->input['db_host'];
			$this->install->saved_data['db_name'] 	    = $this->install->ipsclass->input['db_name'];
			$this->install->saved_data['db_user'] 		= $this->install->ipsclass->input['db_user'];
			$this->install->saved_data['db_pass'] 		= $_REQUEST['db_pass'];
			$this->install->saved_data['db_pre']  		= $this->install->ipsclass->input['db_pre'];
			$this->install->saved_data['_drop_tables']  = $this->install->ipsclass->input['_drop_tables'];
			
			//-----------------------------------------
			// Tables exist?
			//-----------------------------------------
			
			if ( ! $this->install->saved_data['_drop_tables'] AND $DB->field_exists( 'id', 'members' ) )
			{
				/* Output */
				$this->install->saved_data['_show_overwrite'] = 1;
				$this->install->template->append( $this->install->template->db_page( $drivers ) );
				$this->install->template->next_action = '?p=db&sub=check';
				
				//-----------------------------------------
				// Show overwrite?
				//-----------------------------------------

				$html = "<tr>
							<td colspan='2'>
								<div class='warning'>
									<p><strong style='color:red'>您正在试图将数据安装到一个已经存在数据表的数据库中</strong>
									<br />如果您希望在这一数据库中进行安装, 当前所有已经存在的数据表和数据都可能被删除.
									您可以继续安装, 删除所有当前的数据或者返回修改数据表前缀.</p>
									<input type='checkbox' value='1' name='_drop_tables' /><strong>在下一步的安装前删除全部的现有数据表</strong>
								</div>
							</td>
						</tr>";

				$this->install->template->page_content = str_replace( '<!--{TOP.SQL}-->', $html, $this->install->template->page_content );
				
				//--------------------------------------------------
				// Any "extra" configs required for this driver?
				//--------------------------------------------------

				if ( file_exists( INS_ROOT_PATH.'sql/'.$this->install->saved_data['sql_driver'].'_install.php' ) )
				{
					require_once( INS_ROOT_PATH.'sql/'.$this->install->saved_data['sql_driver'].'_install.php' );
					$extra_install = new install_extra();

					$this->install->template->page_content = str_replace( '<!--{EXTRA.SQL}-->', $extra_install->install_form_extra(), $this->install->template->page_content );
				}
						
				return;
			}
			
			/* Next Action */
			$this->install->template->page_current = 'admin';
			$this->install->ipsclass->input['sub'] = '';
			require_once( INS_ROOT_PATH . 'core/actions/admin.php' );	
			$action = new action_admin( $this->install );
			$action->run();
			return;
		}
		
		//--------------------------------------------------
		// DO WE HAVE A DB DRIVER SET?
		//--------------------------------------------------

		$this->install->saved_data['sql_driver'] = ( $this->install->saved_data['sql_driver'] == "" ) ? $_REQUEST['sql_driver'] : $this->install->saved_data['sql_driver'];

		if ( ! $this->install->saved_data['sql_driver'] )
		{
			//----------------------------------------------
			// Test to see how many DB driver's we've got..
			//----------------------------------------------

			$dh = opendir( INS_KERNEL_PATH );

			while ( false !== ( $file = @readdir( $dh ) ) )
			{
				if ( preg_match( "/^class_db_([a-zA-Z0-9]*)\.php/i", $file, $driver ) )
				{
					$drivers[] = $driver[1];
				}
			}

	 		@closedir( $dh );

	 		//----------------------------------------------
	 		// Got more than one?
	 		//----------------------------------------------

	 		if ( count($drivers) > 1 )
	 		{
	 			//------------------------------------------
	 			// Show choice screen first...
	 			//------------------------------------------
				
				/* Output */
				$this->install->template->append( $this->install->template->db_check_page( $drivers ) );		
				$this->install->template->next_action = '?p=db';
				return;
	 		}
	 		else
	 		{
	 			//------------------------------------------
	 			// Use only driver installed
	 			//------------------------------------------

	 			$this->install->saved_data['sql_driver'] = $drivers[0];
	 		}
		}
		
		/* Output */
		$this->install->template->append( $this->install->template->db_page() );		
		$this->install->template->next_action = '?p=db&sub=check';
		
		//--------------------------------------------------
		// Any "extra" configs required for this driver?
		//--------------------------------------------------

		if ( file_exists( INS_ROOT_PATH.'sql/'.$this->install->saved_data['sql_driver'].'_install.php' ) )
		{
			require_once( INS_ROOT_PATH.'sql/'.$this->install->saved_data['sql_driver'].'_install.php' );
			$extra_install = new install_extra();

			$this->install->template->page_content = str_replace( '<!--{EXTRA.SQL}-->', $extra_install->install_form_extra(), $this->install->template->page_content );
		}
	}
	
}

?>