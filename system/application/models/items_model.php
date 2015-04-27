<?php
class Items_model extends Model{





	function Items_model(){
		parent::Model();
		$options['CHECKBOX']	= 'Checkbox';
		$options['SELECT']		= 'Drop-down list';
		$options['TEXT']			= 'Text field';
		$this->options = $options;
		#$this->CI =& get_instance();
  }
  
  
  
  
  function Test(){
  	$query = $this->db->get('items');
  	return var_export($query->row(), true);
  }
  
    function GetItemType($school_id = NULL){
		if($school_id == NULL){ $school_id = $this->session->userdata('school_id'); }
		
		// All "active" bookings (today onwards)
		$query_str = "SELECT * FROM item_types WHERE 1";
		$query = $this->db->query($query_str);
		
		if( $query->num_rows() > 0 ){
			return $query->result();
		} else {
			return false;
		}
	}
	
	function GetItemGroup($school_id = NULL){
		if($school_id == NULL){ $school_id = $this->session->userdata('school_id'); }
		
		// All "active" bookings (today onwards)
		$query_str = "SELECT * FROM item_groups WHERE 1";
		$query = $this->db->query($query_str);
		
		if( $query->num_rows() > 0 ){
			return $query->result();
		} else {
			return false;
		}
	}
	
	function GetPhoto(){
		
		// All "active" bookings (today onwards)
		$query_str = "SELECT * FROM items WHERE 1";
		$query = $this->db->query($query_str);
		
		if( $query->num_rows() > 0 ){
			return $query->row();
		} else {
			return false;
		}
	}
	
	function GetItemGroupName(){
	
	$this->db->select('item_groups.name AS item_group_name, items.*');
	$this->db->from('items');
	$this->db->join('item_groups', 'items.item_group_id=item_groups.item_group_id', 'left');
	
	$query = $this->db->get();
	
	if( $query->num_rows() > 0 ){
		return $query->result();
	} else {
		return false;
	}
	
	  
  }
  
  
  
	/**
	 * Retrieve all items
	 * 
	 * @return				array				All items in table
	 */	 	 	 	
	function Get($item_id = NULL, $school_id = NULL){
		if($school_id == NULL){ $school_id = $this->session->userdata('school_id'); }
													/* .'schools.school_id,'
											.'schools.code AS schoolcode'
											#.'x' */
		
		$this->db->select(
											 'items.*,'
											.'users.user_id,'
											.'users.username,'
											.'users.displayname'
											);
		$this->db->from('items');
		#$this->db->join('schools', 'schools.school_id = items.school_id');
		$this->db->join('users', 'users.user_id = items.user_id', 'left');
		$this->db->where('items.school_id', $school_id);
		
		if( $item_id != NULL ){
			// Getting one specific item
			$this->db->where('item_id', $item_id);
			$this->db->limit('1');
			$query = $this->db->get();
			if( $query->num_rows() == 1 ){
				// One row, match!
				return $query->row();
			} else {
				// None
				return false;
			}
		} else {
			// Getting all
			$this->db->order_by('name asc');
			$query = $this->db->get();
			if( $query->num_rows() > 0 ){
				// Got some items, return result
				return $query->result();
			} else {
				// No items!
				return false;
			}
		}

	}
	
	function GetAll() {
	
		$query_str = "SELECT * FROM items ";
					
		$query = $this->db->query($query_str);
		if($query->num_rows() >= 1){
			return $query->result();
		} else {
			return false;
		}
		
	}
	
	
	
	
	
	/*
		Gets all information on the item - joins all the fields as well
	*/
	function GetInfo($item_id, $school_id = NULL ){
		if($school_id == NULL){ $school_id = $this->session->userdata('school_id'); }
		
		$this->db->select(
											 'items.*,'
											/*.'itemfields.*,'
											.'itemoptions.*,'
											.'itemvalues.*,'*/
											.'users.user_id,'
											.'users.username,'
											.'users.displayname'
											);
		$this->db->from('items');	//,itemfields,itemoptions,itemvalues');
		$this->db->join('users', 'users.user_id = items.user_id', 'left');
		$this->db->where('items.school_id', $school_id);
		$this->db->where('items.item_id', $item_id);
	
		$query = $this->db->get();
		
		$data['item'] = $query->row();
		
		$this->db->select('itemfields.*, itemoptions.*, itemvalues.*');
		$this->db->from('itemvalues');
		
		$this->db->join('itemoptions', 'itemoptions.field_id = itemvalues.field_id', 'left');
		$this->db->join('itemfields', 'itemfields.field_id = itemvalues.field_id');
		#$this->db->join('itemvalues', 'itemvalues.value = itemoptions.option_id');
		#$this->db->join('itemoptions','itemoptions.option_id=itemvalues.value');
		#$this->db->where('itemoptions.option_id=itemvalues.value');
		$this->db->where('itemvalues.item_id', $item_id);
		$this->db->where('itemfields.school_id', $school_id);
		
		$query = $this->db->get();
		
		$data['fields'] = $query->result();
		#$data['fields'] = $this->db->last_query();

		
				#$this->db->join('itemfields', 'itemfields.school_id = items.school_id');
		#$this->db->join('itemvalues', 'itemvalues.item_id = items.item_id');
		#$this->db->join('itemoptions', 'itemoptions.field_id = itemvalues.field_id');
		
		return $data;
	} 
	
	
	
	
	/**
	 * Gets item ID and name of one item owned by the given user id
	 * 
	 * @param	int	$school_id	School ID
	 * @param	int	$user_id	ID of user to lookup
	 * @return	mixed	object if result, false on no results	 	 	 	 
	 */	 	
	function GetByUser($user_id, $school_id = NULL ){
		if($school_id == NULL){ $school_id = $this->session->userdata('school_id'); }
		$query_str = "SELECT item_id,name FROM items "
								."WHERE school_id=$school_id AND user_id=$user_id "
								."ORDER BY name LIMIT 1";
		$query = $this->db->query($query_str);
		if($query->num_rows() == 1){
			return $query->row();
		} else {
			return false;
		}
	}
	
	
	
	
	
	function add($data){
		// Run query to insert blank row
		$this->db->insert('items', array('item_id' => NULL) );
		// Get id of inserted record
		$item_id = $this->db->insert_id();
		// Now call the edit function to update the actual data for this new row now we have the ID
		$this->edit($item_id, $data);
		return $item_id;
	}
	
	
	
	
	
	function edit($item_id, $data){
		$this->db->where('item_id', $item_id);
		$this->db->set('school_id', $this->school_id);
		$result = $this->db->update('items', $data);
		// Return bool on success
		if($result){
			// Clear the cache file for this item info page
			$this->clear_item_cache($this->school_id, $item_id);
			return true;
		} else {
			return false;
		}
	}
	
	
	
	
	
	function clear_item_cache($item_id, $school_id = NULL){
		if($school_id == NULL){ $school_id = $this->session->userdata('school_id'); }
		$path = 0;
		$cache_path = ($path == '') ? BASEPATH.'cache/' : $path;
		$uri = $this->config->item('base_url')
					.$this->config->item('index_page')
					."/items/info/$school_id/$item_id";
		$cache_path .= md5($uri);
		if(file_exists($cache_path)){
			return @unlink($cache_path);
		} else {
			return false;
		}
	}





	/**
	 * Deletes a item with the given ID
	 *
	 * @param   int   $id   ID of item to delete
	 *
	 */
	function delete($id){
			$data = array(
               'active' => '0'
            );
		$this->delete_photo($id);
    $this->db->where('item_id', $id);
	$this->db->update('items', $data);
	}
	
	
	
	
	
	/**
	 * Deletes a photo
	 */	 	
	function delete_photo($item_id){
		$row = $this->Get($item_id, NULL);
		$photo = $row->photo;
		#echo $item_id;
		@unlink('webroot/images/itemphotos/160/'.$photo);
		@unlink('webroot/images/itemphotos/320/'.$photo);
		@unlink('webroot/images/itemphotos/640/'.$photo);
		$this->db->where('item_id', $item_id);
		$this->db->update('items', array('photo' => '')); 
	}
	
	
	
	
	
	/**
	 * Get item fields
	 */	 	
	function GetFields($field_id = NULL, $school_id = NULL){
		if($school_id == NULL){ $school_id = $this->session->userdata('school_id'); }
		$this->db->select(
											 '*'
											#.'itemoptions.*,'
											#.'itemoptions.option_id,'
											#.'itemoptions.value,'
											#.'x.,'
											#.'school.school_id,'
											#.'school.code AS schoolcode'
											);
		$this->db->from('itemfields');
		#$this->db->join('itemoptions', 'itemfields.field_id = itemoptions.field_id', 'left outer');
		#$this->db->join('schools', 'schools.school_id = itemfields.school_id');
		$this->db->where('itemfields.school_id', $school_id);
		#$this->db->where('schools.code', $schoolcode);
		#$this->db->where('itemfields.type', 'SELECT');

		
		if( $field_id != NULL ){
			// Getting one specific field
			$this->db->where('itemfields.field_id', $field_id);
			$this->db->limit('1');
			$query = $this->db->get();
			if( $query->num_rows() == 1 ){
				// One row, match!
				$row = $query->row();
				$row->options = $this->GetOptions($field_id);
				#print_r($row);
				return $row;
			} else {
				// None
				return false;
			}
		} else {
			// Getting all
			$this->db->order_by('itemfields.type asc, itemfields.name asc');
			$query = $this->db->get();
			if( $query->num_rows() > 0 ){
				
				// Got some items, return result
				$result = $query->result();	
				
				foreach( $result as $item ){
					if($item->type == 'SELECT'){
						$item->options = $this->GetOptions($item->field_id);
						#print_r($item);
					}
				}
				
				return $result;
			} else {
				// No items!
				return false;
			}
		}
	}





	function field_add($data){
		// Run query to insert blank row
		$this->db->insert('itemfields', array('field_id' => NULL) );
		// Get id of inserted record
		$field_id = $this->db->insert_id();
		// Now call the edit function to update the actual data for this new row now we have the ID
		$this->field_edit($field_id, $data);
		return $field_id;
	}
	
	
	
	
	
	function field_edit($field_id, $data){
		// We don't add the options column to the itemfields table, so get it then remove it from the array that gets added
		$options = $data['options'];
		unset($data['options']);
		
		$this->db->where('field_id', $field_id);
		$this->db->set('school_id', $this->session->userdata('school_id'));
		$result = $this->db->update('itemfields', $data);

		// Delete row options of the field
		//		We don't yet know if the type is a SELECT, but we delete
		//		them first anyway incase they changed it 
		//		from a SELECT to something else. The new options get inserted next.
		$this->delete_field_options($field_id);
		
		if( $data['type'] == 'SELECT' ){
			
			// Explode at newline into array
			$arr_options = explode("\n", $options);
			
			// Loop through options and insert a new row for each one
			foreach($arr_options as $key => $value){
				$arr_option['field_id'] = $field_id;
				$arr_option['value'] = addslashes($value);
				$this->db->insert('itemoptions', $arr_option);
			}
			
		}
		// Return bool on success
		if( $result ){
			return true;
		} else {
			return false;
		}
	}
	
	
	
	
	
	
	
	
	/**
	 * Deletes a field with the given ID
	 *
	 * @param   int   $id   ID of field to delete
	 *
	 */
	function field_delete($id){
    $this->db->where('field_id', $id);
    $this->db->delete('itemfields');
    $this->db->where('field_id', $id);
    $this->db->delete('itemvalues');
	}
	
	
	
	
	
	/**
	 * Get options for a field
	 */	 	
	function GetOptions($field_id){
		$this->db->select('*');
		$this->db->from('itemoptions');
		$this->db->orderby('value asc');
		$this->db->where('field_id', $field_id);
		$query = $this->db->get();
		if( $query->num_rows() > 0 ){
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}
	
	
	
	
	
	/**
	 * Delete all options for a given field
	 */	 	
	function delete_field_options($field_id){
		$this->db->where('field_id', $field_id);
		$this->db->delete('itemoptions');
	}
	
	
	
	
	
	function save_field_values($item_id, $data){
		$this->db->where('item_id', $item_id);
		$this->db->delete('itemvalues');
		foreach($data as $field_id => $value){
			$values['item_id'] = $item_id;
			$values['field_id'] = $field_id;
			$values['value'] = $value;
			$this->db->insert('itemvalues', $values);
		}
	}
	
	
	
	
	
	function GetFieldValues($item_id){
		$this->db->select('field_id, value');
		$this->db->from('itemvalues');
		$this->db->orderby('value_id asc');
		$this->db->where('item_id', $item_id);
		$query = $this->db->get();
		if( $query->num_rows() > 0 ){
			$result = $query->result();
			foreach($result as $item){
				$values[$item->field_id] = $item->value;
			}
			return $values;
		} else {
			return false;
		}
	}
	
	
	
	

}
?>
