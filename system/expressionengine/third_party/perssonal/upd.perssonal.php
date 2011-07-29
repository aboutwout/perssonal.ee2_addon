<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Perssonal Module Install/Update File
*
* @package		ExpressionEngine
* @subpackage	Addons
* @category	Module
* @author		Wouter Vervloet
* @link		http://www.baseworks.nl
*/

if (! defined('PERSSONAL_VERSION')) require PATH_THIRD.'perssonal/config.php';

class Perssonal_upd {
	
	public $version = PERSSONAL_VERSION;
	
	private $EE;
	
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->EE =& get_instance();
	}
	
	// ----------------------------------------------------------------
	
	/**
	 * Installation Method
	 *
	 * @return 	boolean 	TRUE
	 */
	public function install()
	{
		$mod_data = array(
			'module_name'			=> PERSSONAL_NAME,
			'module_version'		=> $this->version,
			'has_cp_backend'		=> PERSSONAL_HAS_CP,
			'has_publish_fields'	=> PERSSONAL_HAS_PUBLISH
		);
		
		$this->EE->db->insert('modules', $mod_data);
		
		$this->EE->load->dbforge();
		
		$fields = array(
      'hash' => array(
        'type' => 'VARCHAR',
        'constraint' => '32'
      ),
      'params' => array(
        'type' => 'TEXT',
        'null' => TRUE
      ),
      'meta' => array(
        'type' => 'TEXT',
        'null' => TRUE
      ) 
		);
		
    $this->EE->dbforge->add_field('id');
    $this->EE->dbforge->add_field($fields);
    $this->EE->dbforge->create_table('perssonal_feeds', TRUE);
		
		return TRUE;
	}

	// ----------------------------------------------------------------
	
	/**
	 * Uninstall
	 *
	 * @return 	boolean 	TRUE
	 */	
	public function uninstall()
	{
		$mod_id = $this->EE->db->select('module_id')
								->get_where('modules', array(
									'module_name'	=> PERSSONAL_NAME
								))->row('module_id');
		
		$this->EE->db->where('module_id', $mod_id)
					 ->delete('module_member_groups');
		
		$this->EE->db->where('module_name', PERSSONAL_NAME)
					 ->delete('modules');
		
    $this->EE->load->dbforge();
    $this->EE->dbforge->drop_table('perssonal_feeds');
		
		return TRUE;
	}
	
	// ----------------------------------------------------------------
	
	/**
	 * Module Updater
	 *
	 * @return 	boolean 	TRUE
	 */	
	public function update($current = '')
	{
		// If you have updates, drop 'em in here.
		return TRUE;
	}
	
}
/* End of file upd.perssonal.php */
/* Location: /system/expressionengine/third_party/perssonal/upd.perssonal.php */