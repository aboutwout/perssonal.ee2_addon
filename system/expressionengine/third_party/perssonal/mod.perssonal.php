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
	
	protected $_allowed_params = array(
	  'author_id',
	  'channel',
	  'category_group',
	  'category',
	  'group_id',
	  'search:*',
	  'status',
	  'username'
	);
	
  /**
  * Constructor
  */
	function __construct()
	{
		$this->EE =& get_instance();
	}
		
	function feed()
	{
	  $hash = $this->_fetch_param('hash');
	  
	  $feed = $this->EE->db->where('hash', $hash)->limit('1')->get('perssonal_feeds');
	  
	  if ($feed->num_rows() === 0)
	  {
	    $this->_log('No feed found with hash '.$hash);
	    return FALSE;
	  }
	  
	  $meta = unserialize($feed->row('meta'));
	  $params = unserialize($feed->row('params'));
	  
	  $param_str = "disable='pagination' dynamic='no'";
	  
	  if ( ! is_array($params) OR count($params) === 0)
	  {
	    $this->_log('No or invalid parameters given.');
	    return FALSE;
	  }
	  
	  foreach ($params as $key => $val)
	  {
	    $param_str .= " {$key}='{$val}'";
	  }

	  
	  $vars = array(
	    'feed_name' => $meta['feed_name'],
	    'feed_url' => $meta['feed_url'],
	    'feed_description' => $meta['feed_description'],
	    'feed_language' => $this->EE->config->item('xml_lang'),
	    'email' => $this->EE->config->item('webmaster_email'),
	    'gmt_date' => $this->EE->localize->now,
      'parameters' => $param_str
	  );
	  
	  return $this->EE->TMPL->parse_variables_row($this->EE->TMPL->tagdata, $vars);
	  
	}
	
	function link()
	{
	  $params = $this->_fetch_params();
	  $meta = array(
      'feed_url' => $this->_make_absolute_url($this->_fetch_param('feed_url')),
      'feed_name' => $this->_fetch_param('feed_name'),
      'feed_description' => $this->_fetch_param('feed_description')
    );
	  $url = $this->_fetch_param('url');
	  $feed_url = '';
	  
	  $params_str = serialize($params);
	  $meta_str = serialize($meta);
	  $hash = md5($params_str.$meta_str);

	  $feeds = $this->EE->db->where('hash', $hash)->get('perssonal_feeds');

	  if ($feeds->num_rows() === 0)
	  {
  	  $data = array(
  	    'hash' => $hash,
  	    'params' => $params_str,
  	    'meta' => $meta_str
  	  );

  	  $this->EE->db->insert('perssonal_feeds', $data);

  	  if ($this->EE->db->affected_rows() == 1)
  	  {
  	    $feed_url = $this->EE->functions->create_url($this->EE->functions->remove_double_slashes($url.'/'.$hash));
  	  }
	  }
	  else
	  {
	    $feed_url = $this->EE->functions->create_url($this->EE->functions->remove_double_slashes($url.'/'.$hash));
	  }
	  
	  return $feed_url;
	  
	}

  ######################################
  #  Helper functions
  ######################################
  
  function _make_absolute_url($str='')
  {
    if ( ! $str) return '';
    
    if (strstr($str, 'http://') OR strstr($str, 'https://'))
    {
      return $str;   
    }
    else
    {
      return $this->EE->functions->create_url($str);
    }    
  }
  
  /**
  * Helper function for getting a parameter
  * @access		private
  * @param    $key string 
  * @param    $default_value mixed 
  * @return   mixed string|boolean
  **/	
  private function _fetch_params()
  {
    $approved = array();

    $params = $this->EE->TMPL->tagparams ? $this->EE->TMPL->tagparams : array();    

    foreach ($params as $param => $value)
    {
      if ( in_array($param, $this->_allowed_params) OR strstr($param, 'search:') !== FALSE )
      {
        $approved[$param] = $value;
      }
    }
    
    return $approved;
  }	
  

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

    $this->EE->TMPL->log_item('--> '.PERSSONAL_NAME.' : '.$message);

  }

}
/* End of file mod.perssonal.php */
/* Location: /system/expressionengine/third_party/perssonal/mod.perssonal.php */