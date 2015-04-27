<?php
class Item_Types extends Controller {





  function Item_Types(){
    parent::Controller();
    
		// Load language
  	$this->lang->load('crbs', 'english');
    
		// Get school id
    $this->school_id = $this->session->userdata('school_id');

    $this->output->enable_profiler($this->session->userdata('profiler'));
    
    // Check user is logged in & is admin
    if(!$this->userauth->loggedin()){
    	$this->session->set_flashdata('login', $this->load->view('msgbox/error', $this->lang->line('crbs_auth_mustbeloggedin'), True));
			redirect('site/home', 'location');
		} else {
			$this->loggedin = True;
			$this->authlevel = $this->userauth->GetAuthLevel($this->session->userdata('user_id'));
			if(!$this->userauth->CheckAuthLevel(ADMINISTRATOR)){
				$this->session->set_flashdata('auth', $this->load->view('msgbox/error', $this->lang->line('crbs_auth_mustbeadmin'), True));
				redirect('controlpanel', 'location');
			}
		}
		
		// Load models etc
		$this->load->library('pagination');
		$this->load->model('crud_model', 'crud');
    $this->load->model('school_model', 'M_school');
    #$this->load->model('Item_Types_model', 'M_types');
    // Load the icon selector helper
    $this->load->helper('iconsel');
    #$this->load->scaffolding('rooms');
  }
  
  
  
  
  function index($start_at = NULL){
  	log_message('debug', 'Item_Types/index');
  	if($start_at == NULL){ $start_at = $this->uri->segment(3); }
		// Init pagination
		$pages['base_url'] = site_url('item_types/index');
		$pages['total_rows'] = $this->crud->Count('item_types');
		$pages['per_page'] = '10';
		$pages['full_tag_open'] = '<p style="text-align:center">';
		$pages['full_tag_close'] = '</p>';
		$pages['cur_tag_open'] = ' <b>';
		$pages['cur_tag_close'] = '</b>';
		$pages['first_link'] = '<img src="webroot/images/ui/resultset_first.png" width="16" height"16" alt="First" title="First" align="top" />';
		$pages['last_link'] = '<img src="webroot/images/ui/resultset_last.png" width="16" height"16" alt="Last" title="Last" align="top" />';
		$pages['next_link'] = '<img src="webroot/images/ui/resultset_next.png" width="16" height"16" alt="Next" title="Next" align="top" />';
		$pages['prev_link'] = '<img src="webroot/images/ui/resultset_previous.png" width="16" height"16" alt="Previous" title="Previous" align="top" />';
		$this->pagination->initialize($pages);
		$body['pagelinks'] = $this->pagination->create_links();
		// Get list of rooms from database
		$body['item_types'] = $this->crud->Get('item_types', NULL, NULL, $this->school_id, 'name asc', $pages['per_page'], $start_at );
		// Set main layout
		$layout['title'] = 'Equipment Types';
		$layout['showtitle'] = $layout['title'];
		$layout['body'] = $this->load->view('item_types/item_types_index', $body, True);
		$this->load->view('index_layout', $layout );
  }
  
  
  
  
  
	/**
	 * Controller function to handle the Add page
	 */
	function add(){
		// Load view
		$layout['title'] = 'Add Item Type';
		$layout['showtitle'] = $layout['title'];
		$layout['body'] = $this->load->view('item_types/item_types_add', NULL, True);
		$this->load->view('index_layout', $layout );
	}
	
	
	
	
	
	/**
	 * Controller function to handle the Edit page
	 */
	function edit($item_type_id = NULL){
		if($item_type_id == NULL){ $item_type_id = $this->uri->segment(3); }
		// Load view
		$body['item_type'] = $this->crud->Get('item_types', 'item_type_id', $item_type_id, $this->school_id);
		$layout['title'] = 'Edit Item Type';
		$layout['showtitle'] = $layout['title'];
		
		$layout['body'] = $this->load->view('item_types/item_types_add', $body, True);	#$this->load->view('rooms/rooms_add', $body, True);
		$this->load->view('index_layout', $layout );
	}
	
	
	
	
	
	function save(){
		#print_r($_POST);
	 	// Get ID from form
		$item_type_id = $this->input->post('item_type_id');
		
		// Validation rules
		$vrules['item_type_id']		= 'required';
		$vrules['name']							= 'required|min_length[1]|max_length[50]';
		$vrules['description']			= 'max_length[255]';
		$vrules['icon']							= 'max_length[255]';
		$this->validation->set_rules($vrules);

		// Pretty it up a bit for error validation message
		$vfields['item_type_id']		= 'Item Type ID';
		$vfields['name']						= 'Name';
		$vfields['description']			= 'Description';
		$vfields['icon']						= 'Icon';
		$this->validation->set_fields($vfields);

		// Set the error delims to a nice styled red hint under the fields
		$this->validation->set_error_delimiters('<p class="hint error"><span>', '</span></p>');
		
    if ($this->validation->run() == FALSE){
    
    	// Validation failed
			if($item_type_id != "X"){
				return $this->edit($item_type_id);
			} else {
				return $this->add();
			}
    
    } else {
    
			// Validation succeeded!
			// Create array for database fields & data
			$data = array();
			$data['name']						= $this->input->post('name');
			$data['description']		=	$this->input->post('description');
			$data['icon']						= $this->input->post('icon');
			
			// Now see if we are editing or adding
			if($item_type_id == 'X'){
				// No ID, adding new record
				#echo 'adding';
				if( !$this->crud->Add('item_types', 'item_type_id', $data) ){
					$flashmsg = $this->load->view('msgbox/error', 'An error occured adding item type <strong>'.$data['name'].'</strong>.', True);
				} else {
					$flashmsg = $this->load->view('msgbox/info', 'Item Type named <strong>'.$data['name'].'</strong> has been added.', True);
				}
			} else {
				// We have an ID, updating existing record
				if( !$this->crud->Edit('item_types', 'item_type_id', $item_type_id, $data) ){
					$flashmsg = $this->load->view('msgbox/error', 'A database error occured editing item type <strong>'.$data['name'].'</strong>.', True);
				} else {
					$flashmsg = $this->load->view('msgbox/info', 'Item Type named <strong>'.$data['name'].'</strong> has been modified.', True);
				}
				
			}
			
			// Go back to index
			$this->session->set_flashdata('saved', $flashmsg);
			redirect('item_types', 'redirect');
    
		}
	
	}
	
	
	
	
	
	/**
	 * Controller function to delete a type
	 */
	function delete(){
	  // Get ID from URL
		$type_id = $this->uri->segment(3);
		
		// Check if a form has been submitted; if not - show it to ask user confirmation
		if( $this->input->post('id') ){
			// Form has been submitted (so the POST value exists)
			// Call model function to delete manufacturer
			$this->crud->Delete('item_types', 'item_type_id', $this->input->post('id'));
			$this->session->set_flashdata('saved', $this->load->view('msgbox/info', 'The item type has been deleted.', True) );
			// Redirect
			redirect('item_types', 'redirect');
		} else {
			// Initialise page
			$body['action'] = 'item_types/delete';
			$body['id'] = $type_id;
			$body['cancel'] = 'item_types';
			$body['text'] = 'If you delete this item type, you must re-assign any of its members to another item type.';
			// Load page
			$row = $this->crud->Get('item_types', 'item_type_id', $type_id);
			$layout['title'] = 'Delete Item Type';
			$layout['showtitle'] = $layout['title'];
			$layout['body'] = $this->load->view('partials/deleteconfirm', $body, True);
			$this->load->view('index_layout', $layout );
		}
	}





}
?>
