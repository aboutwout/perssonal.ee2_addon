<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Perssonal Module Front End File
*
* @package		ExpressionEngine
* @subpackage	Addons
* @category	Module
* @author		Wouter Vervloet
* @link		http://www.baseworks.nl
*/

if (! defined('PERSSONAL_VERSION')) require PATH_THIRD.'perssonal/config.php';

class Perssonal {
	
	public $return_data;
	
  /**
  * Constructor
  */
	function __construct()
	{
		$this->EE =& get_instance();
	}
	
	
	function feeds()
	{
	  
	}
	
	function feed()
	{
	  $this->hash = $this->_fetch_param('hash');
	}
	
	function link()
	{
	  $this->params = $this->_fetch_params();
	  
	  debug($this->params);
	  
	}

  ######################################
  #  Helper functions
  ######################################

  /**
  * Helper function for getting a parameter
  * @access		private
  * @param    $key string 
  * @param    $default_value mixed 
  * @return   mixed string|boolean
  **/	
  private function _fetch_param($key='', $default_value = FALSE)
  {
    $val = $this->EE->TMPL->fetch_param($key);

    if ($val === '' OR $val === FALSE)
    {
      return $default_value;
    }

    return $val;
  }	

  /**
  * Helper function for getting a parameter that
  * should return a boolean value.
  * @access		private
  * @param    $key string 
  * @param    $default_value mixed
  * @return   bool
  **/	 
  private function _fetch_bool_param($key='', $default_value = FALSE)
  {
    $val = $this->_fetch_param($key, $default_value);

    return in_array($val, array('y', 'yes', '1', 'true', 'on', TRUE));
  }	

  /**
  * Log message to the template log
  * @access		private
  * @param    $message string
  * @return   void
  **/  
  function _log($message='')
  {
    if ( ! $message) return;

    $this->EE->TMPL->log_item('--> '.SASSEE_NAME.' : '.$message);

  }

}
/* End of file mod.perssonal.php */
/* Location: /system/expressionengine/third_party/perssonal/mod.perssonal.php */