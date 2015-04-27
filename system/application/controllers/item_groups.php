<?php
class Item_Groups extends Controller {





  function Item_Groups(){
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
	$this->load->model('items_model', 'M_items');
    #$this->load->model('Item_Groups_model', 'M_types');
    // Load the icon selector helper
    $this->load->helper('iconsel');
    #$this->load->scaffolding('rooms');
	// Load the image resizer script
		$this->load->script('resize');
  }
  
  
  
  
  function index($start_at = NULL){
  	log_message('debug', 's/index');
  	if($start_at == NULL){ $start_at = $this->uri->segment(3); }
		// Init pagination
		$pages['base_url'] = site_url('item_groups/index');
		$pages['total_rows'] = $this->crud->Count('item_groups');
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
		$body['item_groups'] = $this->crud->Get('item_groups', NULL, NULL, $this->school_id, 'name asc', $pages['per_page'], $start_at );
		// Set main layout
		$layout['title'] = 'Equipments';
		$layout['showtitle'] = $layout['title'];
		$layout['body'] = $this->load->view('item_groups/item_groups_index', $body, True);
		$this->load->view('index_layout', $layout );
  }
  
  
  
  
  
	/**
	 * Controller function to handle the Add page
	 */
	function add(){
		// Load view
		$layout['title'] = 'Add New Equipment';
		$layout['showtitle'] = $layout['title'];
		$body['item_types'] = $this->M_items->GetItemType('item_types');
		$layout['body'] = $this->load->view('item_groups/item_groups_add', $body, True);
		$this->load->view('index_layout', $layout );
	}
	
	
	
	
	
	/**
	 * Controller function to handle the Edit page
	 */
	function edit($item_group_id = NULL){
		if($item_group_id == NULL){ $item_group_id = $this->uri->segment(3); }
		// Load view
		$body['item_group'] = $this->crud->Get('item_groups', 'item_group_id', $item_group_id, $this->school_id);
		$layout['title'] = 'Edit Item Type';
		$layout['showtitle'] = $layout['title'];
		
		$body['item_types'] = $this->M_items->GetItemType('item_types');
		
		$layout['body'] = $this->load->view('item_groups/item_groups_add', $body, True);	#$this->load->view('rooms/rooms_add', $body, True);
		$this->load->view('index_layout', $layout );
	}
	
	
	
	
	
	function save(){
		#print_r($_POST);
	 	// Get ID from form
		$item_group_id = $this->input->post('item_group_id');

		// Load image manipulation library
		$this->load->library('image_lib');

		// Load upload library
		$this->load->library('upload');

		// Load file helper library
		$this->load->helper('file');
		
		// Upload config
		$upload['upload_path'] 			= './webroot/images/roomphotos/temp';
		$upload['allowed_types']		= 'jpg|jpeg';
		$upload['max_size']					= '4096';
		$upload['max_width']				= '3000';
		$upload['max_height']				= '3000';
		$this->upload->initialize($upload);
		
		// Validation rules
		$vrules['item_group_id']		= 'required';
		$vrules['item_type_id']		= 'required';
		$vrules['name']							= 'required|min_length[1]|max_length[50]';
		$vrules['description']			= 'max_length[255]';
		$vrules['icon']							= 'max_length[255]';
		$vrules['photo']			= 'max_length[255]';
		$this->validation->set_rules($vrules);

		// Pretty it up a bit for error validation message
		$vfields['item_group_id']		= 'Item Group ID';
		$vfields['item_type_id']		= 'Item Type ID';
		$vfields['name']						= 'Name';
		$vfields['description']			= 'Description';
		$vfields['icon']						= 'Icon';
		$vfields['photo']						= 'Photo';
		$vfields['photo_delete']		= 'Delete photo';
		$this->validation->set_fields($vfields);

		// Set the error delims to a nice styled red hint under the fields
		$this->validation->set_error_delimiters('<p class="hint error"><span>', '</span></p>');
		
    if ($this->validation->run() == FALSE){
    
    	// Validation failed
			if($item_group_id != "X"){
				return $this->edit($item_group_id);
			} else {
				return $this->add();
			}
    
    } else {
		
			log_message('debug', 'CRBS: Validation succeeded');

			if( !$this->upload->do_upload() ){
				// Not uploaded
				$error = $this->upload->display_errors('','');
				echo "<script type='text/javascript'>alert('$error');</script>";
				if( $error != 'You did not select a file to upload' ){
					$this->session->set_flashdata('image_error', $error);
					echo $error;
					if( $item_group_id != "X"){
						return $this->edit($item_group_id);

					} else {
						return $this->add();
					}
				}
				$upload = false;
			} else {
				#echo "uploading";
				// File uploaded
				$photo = $this->upload->data();

				// new filename is <md5(rawname sessionid)>.<extension>
				$newfile = md5($photo['raw_name'].$this->session->userdata('session_id')) . $photo['file_ext'];

				$thumbs['image_library']		= 'GD2';
				$thumbs['source_image']			= $photo['full_path'];
				$thumbs['create_thumb']			= false;
				$thumbs['maintain_ratio']		= true;
				$thumbs['master_dim']				= 'auto';
				$this->image_lib->initialize($thumbs);

				$errcount = 0;

				$thumbs['new_image']				= 'webroot/images/roomphotos/640/'.$newfile;
				$thumbs['width']						= 640;
				$thumbs['height']						= 480;
				$this->image_lib->initialize($thumbs);
				if( !$this->image_lib->resize() ){ $errcount++; }

				$thumbs['new_image']				= 'webroot/images/roomphotos/320/'.$newfile;
				$thumbs['width']						= 320;
				$thumbs['height']						= 240;
				$this->image_lib->initialize($thumbs);
				if( !$this->image_lib->resize() ){ $errcount++; }

				$thumbs['new_image']				= 'webroot/images/roomphotos/160/'.$newfile;
				$thumbs['width']						= 160;
				$thumbs['height']						= 120;
				$this->image_lib->initialize($thumbs);
				if( !$this->image_lib->resize() ){ $errcount++; }

				log_message('debug', 'CRBS: Full path to uploaded photo: '.$photo['full_path']);
				log_message('debug', 'CRBS: Resize item photo image error count: '.$errcount);

				if( $errcount == 0 ){
					unlink($photo['full_path']);
				}

				// Done
				$upload = true;
				//print_r($photo);
			}
    
			// Validation succeeded!
			// Create array for database fields & data
			$data = array();
			$data['name']						= $this->input->post('name');
			$data['item_type_id']						= $this->input->post('item_type_id');
			$data['description']		=	$this->input->post('description');
			$data['icon']						= $this->input->post('icon');
			
			if( $upload == true ){
				$data['item_groups.photo'] = $newfile;
			}
			
			// Now see if we are editing or adding
			if($item_group_id == 'X'){
				// No ID, adding new record
				#echo 'adding';
				if( !$this->crud->Add('item_groups', 'item_group_id', $data) ){
					$flashmsg = $this->load->view('msgbox/error', 'An error occured adding item type <strong>'.$data['name'].'</strong>.', True);
				} else {
					$flashmsg = $this->load->view('msgbox/info', 'Item Type named <strong>'.$data['name'].'</strong> has been added.', True);
				}
			} else {
				// We have an ID, updating existing record
				if( !$this->crud->Edit('item_groups', 'item_group_id', $item_group_id, $data) ){
					$flashmsg = $this->load->view('msgbox/error', 'A database error occured editing item type <strong>'.$data['name'].'</strong>.', True);
				} else {
					$flashmsg = $this->load->view('msgbox/info', 'Item Type named <strong>'.$data['name'].'</strong> has been modified.', True);
				}
				
			}
			
			// Go back to index
			$this->session->set_flashdata('saved', $flashmsg);
			redirect('item_groups', 'redirect');
    
		}
	
	}
	
	
	
	
	
	/**
	 * Controller function to delete a type
	 */
	function delete(){
	  // Get ID from URL
		$group_id = $this->uri->segment(3);
		
		// Check if a form has been submitted; if not - show it to ask user confirmation
		if( $this->input->post('id') ){
			// Form has been submitted (so the POST value exists)
			// Call model function to delete manufacturer
			$this->crud->Delete('item_groups', 'item_group_id', $this->input->post('id'));
			$this->session->set_flashdata('saved', $this->load->view('msgbox/info', 'The item type has been deleted.', True) );
			// Redirect
			redirect('item_groups', 'redirect');
		} else {
			// Initialise page
			$body['action'] = 'item_groups/delete';
			$body['id'] = $group_id;
			$body['cancel'] = 'item_groups';
			$body['text'] = 'If you delete this item type, you must re-assign any of its members to another item type.';
			// Load page
			$layout['title'] = 'Delete Item Group';
			$layout['showtitle'] = $layout['title'];
			$layout['body'] = $this->load->view('partials/deleteconfirm', $body, True);
			$this->load->view('index_layout', $layout );
		}
	}





}
?>
