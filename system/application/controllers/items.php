<?php
class Items extends Controller {





  function Items(){
    parent::Controller();

		// Load language
  	$this->lang->load('crbs', 'english');

		// Get school id
    $this->school_id = $this->session->userdata('school_id');

    $this->output->enable_profiler($this->session->userdata('profiler'));

    // Check user is logged in & is admin
    if($this->uri->segment(2) != 'info'){
	    if(!$this->userauth->loggedin()){
	    	$this->session->set_flashdata('login', $this->load->view('msgbox/error', $this->lang->line('crbs_auth_mustbeloggedin'), True) );
				redirect('site/home', 'location');
			} else {
				$this->loggedin = True;
				$this->authlevel = $this->userauth->GetAuthLevel($this->session->userdata('user_id'));
				if(!$this->userauth->CheckAuthLevel(ADMINISTRATOR)){
					$this->session->set_flashdata('auth', $this->load->view('msgbox/error', $this->lang->line('crbs_auth_mustbeadmin'), True) );
					redirect('controlpanel', 'location');
				}
			}
		}
		// Load models
		$this->load->model('crud_model', 'crud');
    $this->load->model('school_model', 'M_school');
    $this->load->model('items_model', 'M_items');
    $this->load->model('users_model', 'M_users');
	$this->load->model('reservations_model', 'M_reservations');
    // Load the icon selector helper
    $this->load->helper('iconsel');
    // Load the image resizer script
		$this->load->script('resize');
    #$this->load->scaffolding('items');
  }




  function info(){
  	#$this->output->enable_profiler(true);
  	//$this->output->cache(60*24*7);
  	$school_id = $this->uri->segment(3);
  	$item_id = $this->uri->segment(4);

		$item['users'] = $this->M_users->Get(NULL, $this->school_id, array('user_id', 'username', 'displayname'), 'lastname asc, username asc' );

		$item['fields'] = $this->M_items->GetFields(NULL, $school_id);
		$item['fieldvalues'] = $this->M_items->GetFieldValues($item_id);
		$item['item'] = $this->M_items->Get($item_id, $school_id);

		#$item = $this->M_items->GetInfo($item_id, $school_id);
		#$item['fields'] = $this->M_items->GetFields(NULL, $this->school_id);
		#$item['fieldvalues'] = $this->M_items->GetFieldValues($item_id);

		$layout['body'] = $this->load->view('items/room_info', $item, True);
		$layout['title'] = $item['item']->name;
		#print_r($item);
		$this->load->view('minilayout', $layout);
	}





	function index(){
		// Get list of items from database
		$body['items'] = $this->M_items->GetItemGroupName();	//$this->session->userdata('schoolcode'));
		$body['item_type'] = $this->M_items->GetItemType(NULL);
		$body['item_group'] = $this->M_items->GetItemGroup(NULL);
		// Set main layout
		$layout['title'] = 'Items';
		$layout['showtitle'] = $layout['title'];
		$layout['body'] = $this->load->view('items/items_index', $body, True);
		$this->load->view('index_layout', $layout );
	}





	/**
	 * Controller function to handle the Add page
	 */
	function add(){
		// Get list of users
		$body['users'] = $this->M_users->Get( $this->session->userdata('schoolcode'), NULL, array('user_id', 'username', 'displayname'), 'lastname asc, username asc' );
		$body['users'] = $this->M_users->Get(NULL, NULL, array('user_id', 'username', 'displayname'), 'lastname asc, username asc' );
		$body['fields'] = $this->M_items->GetFields($this->session->userdata('schoolcode'));
		
		$body['item_types'] = $this->crud->Get('item_types');
		$body['item_groups'] = $this->crud->Get('item_groups');
		
		// Load view
		$layout['title'] = 'Add Item';
		$layout['showtitle'] = $layout['title'];

		$cols[0]['content'] = $this->load->view('items/items_add', $body, True);
		$cols[0]['width'] = '70%';
		$cols[1]['content'] = $this->load->view('items/items_add_side', $body, True);
		$cols[1]['width'] = '30%';

		$layout['body'] = $this->load->view('columns', $cols, True);	#$this->load->view('items/items_add', $body, True);
		$this->load->view('index_layout', $layout );
	}





	/**
	 * Controller function to handle an edit
	 */
	function edit($id = NULL){
		if($id == NULL){ $id = $this->uri->segment(3); }
		$body['users'] = $this->M_users->Get(NULL, NULL, array('user_id', 'username', 'displayname'), 'lastname asc, username asc' );
		$body['fields'] = $this->M_items->GetFields($this->session->userdata('schoolcode'));
		$body['fieldvalues'] = $this->M_items->GetFieldValues($id);
		$body['item'] = $this->M_items->Get($id, $this->school_id);
		#print_r($body);
		// Load view
		$layout['title'] = 'Edit Item';
		$layout['showtitle'] = $layout['title'];
		
		$body['item_types'] = $this->crud->Get('item_types');
		$body['item_groups'] = $this->crud->Get('item_groups');

		$cols[0]['content'] = $this->load->view('items/items_add', $body, True);
		$cols[0]['width'] = '70%';
		$cols[1]['content'] = $this->load->view('items/items_add_side', $body, True);
		$cols[1]['width'] = '30%';

		$layout['body'] = $this->load->view('columns', $cols, True);	#$this->load->view('items/items_add', $body, True);
		$this->load->view('index_layout', $layout );
	}

	function history($id = NULL) {
		
		$layout['title'] = 'Item History';
		$layout['showtitle'] = $layout['title'];
	
		if($id == NULL){ 
		
			$id = $this->uri->segment(3); 
		
		}
		
		$body['count'] = $this->M_reservations->GetHistoryCount($id);
		$body['items'] = $this->M_reservations->GetHistory($id);
		$body['period'] = $this->M_reservations->GetPeriod();
		$body['users'] = $this->M_users->GetAll();
		
		$layout['body'] = $this->load->view('items/items_history', $body, True);
		$this->load->view('index_layout', $layout);
			
		
	}

	function itemhistory() {
		
		$layout['title'] = 'Item History';
		$layout['showtitle'] = $layout['title'];
			
		$body['reservations'] = $this->M_reservations->GetAll();
		$body['items'] = $this->M_items->GetAll();
		$body['item_group'] = $this->M_items->GetItemGroup();
		$body['period'] = $this->M_reservations->GetPeriod();
		$body['users'] = $this->M_users->GetAll();		
		
		$layout['body'] = $this->load->view('items/items_history_all', $body, True);
		$this->load->view('index_layout', $layout);
			
		
	}
	
	function currentreservations() {
		
		$layout['title'] = 'Item Reservations Today';
		$layout['showtitle'] = $layout['title'];
			
		$body['reservations'] = $this->M_reservations->GetFilter();
		$body['items'] = $this->M_items->GetAll();
		$body['period'] = $this->M_reservations->GetPeriod();
		$body['users'] = $this->M_users->GetAll();		
		$body['item_group'] = $this->M_items->GetItemGroup();
		
		$layout['body'] = $this->load->view('items/items_history_today', $body, True);
		$this->load->view('index_layout', $layout);
			
		
	}
	
	function status() {
		
			$layout['title'] = 'Item Status';
			$layout['showtitle'] = $layout['title'];
	
			$uri = $this->session->userdata('uri');
			$reservation_id = $this->uri->segment(3);
			
			if($this->M_reservations->updateAction($reservation_id)){
				$msg = $this->load->view('msgbox/info', 'The item reservation is <strong>done</strong>.', True);
			} else {
				$msg = $this->load->view('msgbox/error', 'An error occured updating the reservation.', True);
			}
			$this->session->set_flashdata('saved', $msg);
			redirect('items/currentreservations');
		
	}


	/**
	 * Save
	 */
	 function save(){

	 	// Get ID from form
		$item_id = $this->input->post('item_id');

		// Validation rules
		$vrules['item_id']		= 'required';
		$vrules['equipment_id']		= 'min_length[2]|max_length[40]';
		$vrules['serial']		= 'min_length[2]|max_length[40]';
		$vrules['location']		= 'min_length[2]|max_length[40]';
		$vrules['icon']				= 'max_length[255]';
		$vrules['notes']			= 'max_length[255]';
		$vrules['photo']			= 'max_length[255]';
		$this->validation->set_rules($vrules);

		// Pretty it up a bit for error validation message
		$vfields['item_id']					= 'Item ID';
		$vfields['name']						= 'Item name';
		$vfields['equipment_id']				= 'Equipment ID';
		$vfields['serial']				= 'Serial Number';
		$vfields['location']				= 'Location';
		$vfields['user_id']					= 'Teacher';
		$vfields['icon']						= 'Icon';
		$vfields['notes']						= 'Notes';
		$vfields['bookable']				= 'Can be booked';
		$vfields['status']				= 'Item Status';
		$vfields['photo']						= 'Photo';
		$vfields['photo_delete']		= 'Delete photo';
		$this->validation->set_fields($vfields);

		// Set the error delims to a nice styled red hint under the fields
		$this->validation->set_error_delimiters('<p class="hint error"><span>', '</span></p>');

    if ($this->validation->run() == FALSE){

      // Validation failed
			if($item_id != "X"){
				return $this->edit($item_id);
			} else {
				return $this->add();
			}

		} else {

		  // Validation succeeded!
			/*$data = array	(
											'items.name'				=> $this->input->post('name'),
											'items.location'		=> $this->input->post('location'),
											'items.icon'				=> $this->input->post('icon'),
											'items.notes'				=> $this->input->post('notes'),
											'items.user_id'			=> $this->input->post('user_id'),
											#'items.foobar'=>'foo',
										);*/

			$data = array();
			$data['items.name'] = $this->input->post('item_group_id');
			$data['items.equipment_id'] = $this->input->post('equipment_id');
			$data['items.serial'] = $this->input->post('serial');
			$data['items.location'] = $this->input->post('location');
			$data['items.icon'] = $this->input->post('icon');
			$data['items.notes'] = $this->input->post('notes');
			$data['items.user_id'] = $this->input->post('user_id');
			$data['items.bookable'] = ($this->input->post('bookable')) ? 1 : 0;
			$data['items.status'] = ($this->input->post('status')) ? 1 : 0;
			$data['items.item_group_id'] = $this->input->post('item_group_id');

			$fields = $this->M_items->GetFields($this->session->userdata('schoolcode'));
			foreach($fields as $field){
				$fieldvalues[$field->field_id] = $this->input->post('f'.$field->field_id);
			}
			#print_r($fieldvalues);

			// Now see if we are editing or adding
			if($item_id == 'X'){
				// No ID, adding new record
				$item_id = $this->M_items->add($data);
				$this->M_items->save_field_values($item_id, $fieldvalues);
				$this->session->set_flashdata('saved', $this->load->view('msgbox/info', 'Item has been added.', True) );
			} else {
				// We have an ID, updating existing record
				// Now we delete the CURRENT photo on the database before we do an update on the ID (and thus possibly changing the photo)
				if( $upload == true ){$this->M_items->delete_photo($item_id); }
				// Update row with new details
				$this->M_items->edit($item_id, $data);
				$this->M_items->save_field_values($item_id, $fieldvalues);
				$this->session->set_flashdata('saved', $this->load->view('msgbox/info', 'Item has been modified.', True) );
			}
			// Go back to index
			redirect('items', 'redirect');

		}

	}





	/**
	 * Controller function to delete a item
	 */
	function delete(){
	  // Get ID from URL
		$id = $this->uri->segment(3);

		// Check if a form has been submitted; if not - show it to ask user confirmation
		if( $this->input->post('id') ){
			// Form has been submitted (so the POST value exists)
			// Call model function to delete manufacturer
			$this->M_items->delete($this->input->post('id'));
			$this->session->set_flashdata('saved', $this->load->view('msgbox/info', 'The item has been deleted.', True) );
			// Redirect to items again
			redirect('items', 'redirect');
		} else {
			// Initialise page
			$body['action'] = 'items/delete';
			$body['id'] = $id;
			$body['cancel'] = 'items';
			$body['text'] = 'If you delete this item, <strong>all bookings</strong> for this item will be <strong>permanently deleted</strong> as well.';
			// Load page
			$row = $this->M_items->Get($id, $this->school_id);
			$layout['title'] = 'Delete Item';
			$layout['showtitle'] = $layout['title'];
			$layout['body'] = $this->load->view('partials/deleteconfirm', $body, TRUE);
			$this->load->view('index_layout', $layout );
		}
	}





	/**
	 * FIELDS
	 */





	function fields_index(){
		$body['options_list'] = $this->M_items->options;
		// Get list of items from database
		$body['fields'] = $this->M_items->GetFields($this->session->userdata('schoolcode'));
		// Set main layout
		$layout['title'] = 'Item Fields';
		$layout['showtitle'] = 'Define Item Fields';
		$layout['body'] = $this->load->view('items/fields/items_fields_index', $body, True);
		$this->load->view('index_layout', $layout );
	}





	function fields_add(){
		$body['options_list'] = $this->M_items->options;
		// Load view
		$layout['title'] = 'Add Field';
		$layout['showtitle'] = $layout['title'];

		$cols[0]['content'] = $this->load->view('items/fields/items_fields_add', $body, True);
		$cols[0]['width'] = '70%';
		$cols[1]['content'] = '';	//$this->load->view('items/items_add_side', $body, True);
		$cols[1]['width'] = '30%';

		$layout['body'] = $this->load->view('columns', $cols, True);	#$this->load->view('items/items_add', $body, True);
		$this->load->view('index_layout', $layout );
	}





	/**
	 * Controller function to handle an edit
	 */
	function fields_edit($id = NULL){
		if($id == NULL){ $id = $this->uri->segment(4); }
		$body['field'] = $this->M_items->GetFields( $this->session->userdata('schoolcode'), $id );
		$body['options_list'] = $this->M_items->options;
		#print_r($body);
		// Load view
		$layout['title'] = 'Edit Field';
		$layout['showtitle'] = $layout['title'];

		$cols[0]['content'] = $this->load->view('items/fields/items_fields_add', $body, True);
		$cols[0]['width'] = '70%';
		$cols[1]['content'] = '';	//$this->load->view('items/items_add_side', $body, True);
		$cols[1]['width'] = '30%';

		$layout['body'] = $this->load->view('columns', $cols, True);	#$this->load->view('items/items_add', $body, True);
		$this->load->view('index_layout', $layout );
	}





	 function fields_save(){

	 	// Get ID from form
		$field_id = $this->input->post('field_id');

		// Load validation
		#$this->load->library('validation');

		// Validation rules
		$vrules['field_id']		= 'required';
		$vrules['name']				= 'required|min_length[2]|max_length[64]';
		$this->validation->set_rules($vrules);

		// Pretty it up a bit for error validation message
		$vfields['field_id']		= 'Field ID';
		$vfields['name']				= 'Field name';
		$vfields['items']				= 'Items';
		$this->validation->set_fields($vfields);

		// Set the error delims to a nice styled red hint under the fields
		$this->validation->set_error_delimiters('<p class="hint error"><span>', '</span></p>');

    if ($this->validation->run() == FALSE){

      // Validation failed
			if($field_id != "X"){
				$this->fields_edit($field_id);
			} else {
				$this->fields_add();
			}

		} else {

		  // Validation succeeded!
			$data['name']				= $this->input->post('name');
			$data['type']				= $this->input->post('type');
			$data['options']		= $this->input->post('options');

			// Now see if we are editing or adding
			if($field_id == 'X'){
				// No ID, adding new record
				$field_id = $this->M_items->field_add($data);
				$this->session->set_flashdata('saved', $this->load->view('msgbox/info', 'The <strong>'.$data['name'].'</strong> field has been added.', True) );
			} else {
				// We have an ID, updating existing record
				// Update row with new details
				$this->M_items->field_edit($field_id, $data);
				$this->session->set_flashdata('saved', $this->load->view('msgbox/info', 'The <strong>'.$data['name'].'</strong> field has been modified.', True) );
			}
			// Go back to index
			redirect('items/fields', 'redirect');
		}

	}





	/**
	 * Controller function to delete a item
	 */
	function fields_delete(){
	  // Get ID from URL
		$id = $this->uri->segment(4);
		// Check if a form has been submitted; if not - show it to ask user confirmation
		if( $this->input->post('id') ){
			// Form has been submitted (so the POST value exists)
			// Call model function to delete manufacturer
			$this->M_items->field_delete($this->input->post('id'));
			$this->session->set_flashdata('saved', $this->load->view('msgbox/info', 'The field has been deleted.', True) );
			// Redirect to items again
			redirect('items/fields', 'redirect');
		} else {
			// Initialise page
			$body['action'] = 'items/fields/delete';
			$body['id'] = $id;
			$body['cancel'] = 'items/fields';
			#$body['text'] = 'If you delete this field, <strong>all bookings</strong> for this item will be <strong>permanently deleted</strong> as well.';
			// Load page
			$row = $this->M_items->GetFields($id);
			$layout['title'] = 'Delete Field ('.$row->name.')';
			$layout['showtitle'] = $layout['title'];
			$layout['body'] = $this->load->view('partials/deleteconfirm', $body, TRUE);
			$this->load->view('index_layout', $layout );
		}
	}





}
?>
