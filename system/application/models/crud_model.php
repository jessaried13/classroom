<?php
class Crud_model extends Model{





	function Crud_model(){
		parent::Model();
  }
  
  
  
  
  
  /**
   * Get one or more departments
   * 
   * @param		str		$table				Table to get info from
   * @param		int		$pk						Name of the Primary Key ID field
   * @param		int		$pk_id				Value of the primary key field (if getting one row, NULL if all	 	    
   * @param		int		$school_id		ID of the school. If NULL, it is obtained from session
   * @param		str		$orderby			SQL 'order by' string
  */	 	 	 	   
	function Get($table, $pk = NULL, $pk_id = NULL, $school_id = NULL, $orderby = 'name asc', $per_page = NULL, $start_at = NULL){
		if($school_id == NULL){ $school_id = $this->session->userdata('school_id'); }
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('school_id', $school_id);
		$this->db->where('active', '1');
		
		if($pk_id != NULL){
			// Getting only ONE row
			$data = array($pk => $pk_id, 'active' => '1');
			$this->db->where($data);
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
			// Get all
			if( $per_page != NULL){
				if( $start_at != NULL){
					$this->db->limit($per_page, $start_at);
				} else {
					$this->db->limit($per_page);
				}
			}
			$this->db->order_by($orderby);
			$query = $this->db->get();
			if( $query->num_rows() > 0 ){
				// Got some rows, return as assoc array
				return $query->result();
			} else {
				// No rows
				return false;
			}
		}
	}
	
	
	
	
	
  function Add($table, $pk, $data){
		// Run query to insert blank row
		$this->db->insert($table, array($pk => NULL) );
		// Get id of inserted record
		$pk_id = $this->db->insert_id();
		// Now call the edit function to update the actual data for this new row now we have the ID
		return $this->Edit($table, $pk, $pk_id, $data);
  }
  
  
  
  
  
  function Edit($table, $pk, $pk_id, $data, $school_id = NULL){
  	if($school_id == NULL){ $school_id = $this->session->userdata('school_id'); }
		$this->db->where($pk, $pk_id);
		$this->db->set('school_id', $this->session->userdata('school_id'));
		$result = $this->db->update($table, $data);
		// Return bool on success
		if( $result ){
			return $pk_id;
		} else {
			return false;
		}
  }
  
  
  
  
  
  function Delete($table, $pk, $pk_id, $school_id = NULL){
	  		$data = array(
               'active' => '0'
            );
  	if($school_id == NULL){ $school_id = $this->session->userdata('school_id'); }
    $this->db->where($pk, $pk_id);
    $this->db->where('school_id', $school_id);
    $this->db->update($table, $data);
  }
  
  
  
  
  function Count($table, $school_id = NULL){
  	if($school_id == NULL){ $school_id = $this->session->userdata('school_id'); }
  	$this->db->where('school_id', $school_id);
  	return $this->db->count_all($table);
  }
  
  function GetAdminIndex(){
	
	$this->db->select('rooms.name AS room_name, types.name AS type_name, users.*, periods.time_start AS period_time_start, periods.time_end AS period_time_end, bookings.*');
	$this->db->from('bookings');
	$this->db->join('rooms', 'rooms.room_id=bookings.room_id', 'left');
	$this->db->join('periods', 'periods.period_id=bookings.period_id', 'left');
	$this->db->join('users', 'users.user_id=bookings.user_id', 'left');
	
	$query = $this->db->get();
	
	if( $query->num_rows() > 0 ){
		return $query->result();
	} else {
		return false;
	}
	
	  
  }	
	
	
	
}
?>
