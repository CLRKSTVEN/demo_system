<?php
class Library extends CI_Controller{
  function __construct(){
    parent::__construct();
    $this->load->database();
    $this->load->helper('url');
	$this->load->helper('url', 'form');	
	$this->load->library('form_validation');
    $this->load->model('LibraryModel');
	 $this->load->model('SettingsModel');

    if($this->session->userdata('logged_in') !== TRUE){
      redirect('login');
    }
  }
//Update Books
function updateBooks(){
		$id=$this->input->get('id');
		$result['category']=$this->LibraryModel->getBookCategory();
		$result['location']=$this->LibraryModel->getBookLocation();
		$result['publisher']=$this->LibraryModel->getPublisher();
		$result['settings']=$this->SettingsModel->getSchoolInfo();
		$result['data']=$this->LibraryModel->bookDetails($id);
		
		$this->load->view('lib_book_update',$result);
		 if($this->input->post('submit'))
		 {
		$BookNo=$this->input->post('BookNo');
		$Title=$this->input->post('Title');
		$AuthorNum=$this->input->post('AuthorNum');
		$Author=$this->input->post('Author');
		$coAuthors=$this->input->post('coAuthors');
		$Publisher=$this->input->post('Publisher');
		$YPublished=$this->input->post('YPublished');
		$Subject=$this->input->post('Subject');
		$ISBN=$this->input->post('ISBN');
		$Edition=$this->input->post('Edition');
		$CallNum=$this->input->post('CallNum');
		$Category=$this->input->post('Category');
		$Location=$this->input->post('Location');
		$DeweyNum=$this->input->post('DeweyNum');
		$AccNo=$this->input->post('AccNo');
		$Price=$this->input->post('Price');
		
		$Encoder=$this->session->userdata('username');
		$updatedDate=date("Y-m-d");		

		date_default_timezone_set('Asia/Manila'); # add your city to set local time zone
		$now = date('H:i:s A');
		
		$date=date("Y-m-d");

		$que=$this->db->query("update libbookentry set BookNo='$BookNo',Title='$Title',AuthorNum='$AuthorNum',Author='$Author',coAuthors='$coAuthors',Publisher='$Publisher',YPublished='$YPublished',Subject='$Subject',ISBN='$ISBN',Edition='$Edition',CallNum='$CallNum',Category='$Category',Location='$Location',DeweyNum='$DeweyNum',AccNo='$AccNo',Price='$Price' where BookID='".$id."'");
		$this->session->set_flashdata('msg', '<div class="alert alert-success text-center"><b>Updated successfully.</b></div>');

		redirect('Library/Books');
		 }
		 }			


public function booksEntry() {
 
    // Retrieve data for the view
    $data = [
        'data' => $this->LibraryModel->getBookCategory(),
        'location' => $this->LibraryModel->getBookLocation(),
        'publisher' => $this->LibraryModel->getPublisher(),
        'auth' => $this->LibraryModel->getAuthors(),
        'settings' => $this->SettingsModel->getSchoolInfo()
    ];
    
    // Load the view with data
    $this->load->view('lib_book_entry', $data);

    // Check if form was submitted
    if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        
        // Define validation rules
        $this->form_validation->set_rules('BookNo', 'Book Number', 'required');
        // Add more rules as necessary

        if ($this->form_validation->run() === FALSE) {
            // Handle validation errors
            $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center"><b>Validation Error.</b></div>');
            redirect('Library/Books');
        } else {
            // Collect input data
            $data = [
                'BookNo' => $this->input->post('BookNo'),
                'Title' => $this->input->post('Title'),
                'AuthorNum' => $this->input->post('AuthorNum'),
                'Author' => $this->input->post('Author'),
                'coAuthors' => $this->input->post('coAuthors'),
                'Publisher' => $this->input->post('Publisher'),
                'YPublished' => $this->input->post('YPublished'),
                'Subject' => $this->input->post('Subject'),
                'ISBN' => $this->input->post('ISBN'),
                'Edition' => $this->input->post('Edition'),
                'CallNum' => $this->input->post('CallNum'),
                'Category' => $this->input->post('Category'),
                'Location' => $this->input->post('Location'),
                'DeweyNum' => $this->input->post('DeweyNum'),
                'AccNo' => $this->input->post('AccNo'),
                'Price' => $this->input->post('Price'),
                'settingsID' => $this->input->post('settingsID'),
                'Encoder' => $this->session->userdata('username'),
                'EntryDate' => date("Y-m-d"),
                'BookStatus' => 'In',
                'stat' => 'Available'
            ];

            // Check if the book number already exists
            if ($this->db->where('BookNo', $data['BookNo'])->count_all_results('libbookentry') > 0) {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center"><b>Book Number is in use.</b></div>');
            } else {
                // Insert new book entry
                $this->db->insert('libbookentry', $data);
                $this->session->set_flashdata('msg', '<div class="alert alert-success text-center"><b>Saved successfully.</b></div>');
            }

            redirect('Library/Books');
        }
    }
}
	
  
//Masterlist All Books
  function reportsAllBooks(){
		$result['data']=$this->LibraryModel->reportsAllBooks();
		$this->load->view('lib_reports_all_books',$result);	
  }
  

  
//Masterlist All Books
  function Books(){
		$result['data']=$this->LibraryModel->reportsAllBooks();
		$this->load->view('lib_books',$result);	
  }
 //View Book Details
  function bookDetails(){
	    $id=$this->input->get('id');
		$result['data']=$this->LibraryModel->bookDetails($id);
		$this->load->view('lib_book_details',$result);	
  }
 //Delete Books 
 function deleteBook()
 {
	 // Load the session and input libraries if not already loaded
	 $this->load->library('session');
	 $this->load->helper('url'); // For redirect function
	 
	 // Retrieve the ID and username
	 $id = $this->input->post('id');
	 $username = $this->session->userdata('username');
	 
	 // Set the time zone and get the current date and time
	 date_default_timezone_set('Asia/Manila');
	 $now = date('H:i:s A');
	 $date = date('Y-m-d');
	 
	 // Use Query Builder to delete the book entry
	 $this->db->where('BookID', $id);
	 $this->db->delete('libbookentry');
	 
	 // Insert a new record into the atrail table
	 $data = array(
		 'atrailID' => '', 
		 'atDesc' => 'Deleted a book',
		 'atDate' => $date,
		 'atTime' => $now,
		 'atRes' => $username,
		 'atSNo' => $id
	 );
	 $this->db->insert('atrail', $data);
	 
	 // Redirect to the Books page
	 redirect('Library/Books');
 }
 
	
	function borrow(){
		$result['data'] = $this->LibraryModel->getBorrowed();
        $data['book'] = $this->LibraryModel->reportsAllBooks();
        $data['stude'] = $this->LibraryModel->reportsAllstudent();
        $data['set'] = $this->LibraryModel->get_other_settings();
		$this->load->view('lib_book_borrow', $result);	
	}



    public function receiveBook() {
        $bookID = $this->input->post('bookID'); // Get bookID
        $bookNo = $this->input->post('bookNo'); // Get BookNo
        $penaltyPaid = $this->input->post('penalty_paid'); // Get penalty amount
    
        // Update lib_books_borrow table to mark as received and set penalty
        $dataBorrow = [
            'penalty_paid' => $penaltyPaid,
            'status' => 'Received'
        ];
        $this->db->where('bookID', $bookID);
        $this->db->update('lib_books_borrow', $dataBorrow);
    
        // Update libbookentry table to set status to "Available"
        $dataBookEntry = ['stat' => 'Available'];
        $this->db->where('BookNo', $bookNo);
        $this->db->update('libbookentry', $dataBookEntry);
    
        // Flash message and redirect
        $this->session->set_flashdata('message', 'Book received successfully and marked as available.');
        redirect('Library/borrow');
    }
    

    




    function borrow_add(){
        $data['data'] = $this->LibraryModel->getBorrow();
        $data['book'] = $this->LibraryModel->bookData();
        $data['stude'] = $this->LibraryModel->reportsAllstudent();
        $data['set'] = $this->LibraryModel->get_other_settings();
        
        // Fetch `no_days` from settings
        $data['no_days'] = !empty($data['set']) ? $data['set'][0]->no_days : 0;
        
        if ($this->input->post('save')) {
            $bookNo = $this->input->post('bookNo');  // Store BookNo separately
            $data = array(
                'bookNo' => $bookNo,
                'title' => $this->input->post('title'),
                'author' => $this->input->post('author'),
                'borrow_date' => $this->input->post('borrow_date'),
                'return_date' => $this->input->post('return_date'),
                'StudentNumber' => $this->input->post('StudentNumber'),
                'name' => $this->input->post('name'),
            );
            
            $this->load->model('LibraryModel');
            
            // Insert borrow record
            $this->LibraryModel->insert_borrow($data);
    
            // Update libbookentry status to "Borrowed"
            $this->LibraryModel->update_book_status($bookNo, 'Borrowed');
    
            // Set flash message BEFORE redirecting
            $this->session->set_flashdata('message', 'Record saved successfully');
    
            redirect('Library/borrow'); 
        } 
        $this->load->view('lib_book_borrow_add', $data);	
    }





  
    
    
	


    function returnbooks(){
		$result['data'] = $this->LibraryModel->getBorrowReturn();
        $data['book'] = $this->LibraryModel->reportsAllBooks();
        $data['stude'] = $this->LibraryModel->reportsAllstudent();
        $data['set'] = $this->LibraryModel->get_other_settings();
		$this->load->view('lib_book_return', $result);	
	}
	
	public function author() {
		$result['data'] = $this->LibraryModel->getAuthors();
		$this->load->view('lib_book_settings_author', $result);
	}
	
	
	public function Addauthor() {
		if ($this->input->post('save')) {
			$data = array(
				'AuthorNum' => $this->input->post('AuthorNum'),
				'FirstName' => $this->input->post('FirstName'),
				'MiddleName' => $this->input->post('MiddleName'),
				'LastName' => $this->input->post('LastName')
			);
	
			// Load the model and save the data
			$this->load->model('LibraryModel');
			$this->LibraryModel->insertAuthor($data);
	
			// Redirect to the author list page
			redirect('Library/author'); // Adjust the controller/method if necessary
		} 
		$this->load->view('lib_book_settings_Addauthor');
	}


	public function updateAuthor()
    {
        $authorID = $this->input->get('authorID');
        $result['data'] = $this->LibraryModel->getAuthorbyId($authorID);
        $this->load->view('updateAuthor', $result);

        if ($this->input->post('update')) {

			$AuthorNum = $this->input->post('AuthorNum');
            $FirstName = $this->input->post('FirstName');
			$MiddleName = $this->input->post('MiddleName');
            $LastName = $this->input->post('LastName');

            $this->LibraryModel->updateAuthor($authorID, $AuthorNum, $FirstName, $MiddleName, $LastName);
            $this->session->set_flashdata('author', 'Record updated successfully');
            redirect("Library/author");
        }
    }


	public function Delete_Author()
    {
        $authorID = $this->input->get('authorID');
        if ($authorID) {
            $this->LibraryModel->Delete_Author($authorID);
            $this->session->set_flashdata('author', 'Record deleted successfully');
        } else {
            $this->session->set_flashdata('author', 'Error deleting record');
        }

        redirect("Library/author");
    }


	
	
	


			function category(){
		$result['data'] = $this->LibraryModel->getCategory();
		$this->load->view('lib_book_settings_category', $result);
	}


	public function Addcategory() {
		if ($this->input->post('save')) {
			$data = array(
				'Category' => $this->input->post('Category')
			);
			$this->load->model('LibraryModel');
			$this->LibraryModel->insertcategory($data);
	
			
			redirect('Library/category'); 
		} 
		$this->load->view('lib_book_settings_Addcategory');
	}


	public function updatecategory()
    {
        $catID = $this->input->get('catID');
        $result['data'] = $this->LibraryModel->getcategorybyId($catID);
        $this->load->view('updatecategory', $result);

        if ($this->input->post('update')) {

			$Category = $this->input->post('Category');

            $this->LibraryModel->updatecategory($catID, $Category);
            $this->session->set_flashdata('author', 'Record updated successfully');
            redirect("Library/category");
        }
    }


	public function Deletecategory()
    {
        $catID = $this->input->get('catID');
        if ($catID) {
            $this->LibraryModel->Delete_category($catID);
            $this->session->set_flashdata('author', 'Record deleted successfully');
        } else {
            $this->session->set_flashdata('author', 'Error deleting record');
        }

        redirect("Library/category");
    }




			function location(){
		$result['data'] = $this->LibraryModel->getLocation();
		$this->load->view('lib_book_settings_location', $result);
	}

	


	public function Addlocation() {
		if ($this->input->post('save')) {
			$data = array(
				'location' => $this->input->post('location')
			);
			$this->load->model('LibraryModel');
			$this->LibraryModel->insertlocation($data);
	
			
			redirect('Library/location'); 
		} 
		$this->load->view('lib_book_settings_Addlocation');
	}


	public function updatelocation()
    {
        $locID = $this->input->get('locID');
        $result['data'] = $this->LibraryModel->getlocationbyId($locID);
        $this->load->view('updatelocation', $result);

        if ($this->input->post('update')) {

			$location = $this->input->post('location');

            $this->LibraryModel->updatelocation($locID, $location);
            $this->session->set_flashdata('author', 'Record updated successfully');
            redirect("Library/location");
        }
    }


	public function Deletelocation()
    {
        $locID = $this->input->get('locID');
        if ($locID) {
            $this->LibraryModel->Delete_location($locID);
            $this->session->set_flashdata('author', 'Record deleted successfully');
        } else {
            $this->session->set_flashdata('author', 'Error deleting record');
        }

        redirect("Library/location");
    }


		function publisher(){
		$result['data'] = $this->LibraryModel->get_publisher();
		$this->load->view('lib_book_settings_publisher', $result);
	}


	public function Addpublisher() {
		if ($this->input->post('save')) {
			$data = array(
				'publisher' => $this->input->post('publisher')
			);
			$this->load->model('LibraryModel');
			$this->LibraryModel->insertpublisher($data);
	
			
			redirect('Library/publisher'); 
		} 
		$this->load->view('lib_book_settings_Addpublisher');
	}


	public function updatepublisher()
    {
        $pubID = $this->input->get('pubID');
        $result['data'] = $this->LibraryModel->getpublisherbyId($pubID);
        $this->load->view('updatepublisher', $result);

        if ($this->input->post('update')) {

			$publisher = $this->input->post('publisher');

            $this->LibraryModel->updatepublisher($pubID, $publisher);
            $this->session->set_flashdata('author', 'Record updated successfully');
            redirect("Library/publisher");
        }
    }


	public function Deletepublisher()
    {
        $pubID = $this->input->get('pubID');
        if ($pubID) {
            $this->LibraryModel->Delete_publisher($pubID);
            $this->session->set_flashdata('author', 'Record deleted successfully');
        } else {
            $this->session->set_flashdata('author', 'Error deleting record');
        }

        redirect("Library/publisher");
    }


	//Masterlist All E-Books
	function ebooks(){
		$result['data']=$this->Common->no_cond('ebooks');
		$this->load->view('ebook_list',$result);	
  	}

	function ebook_new(){
		$result['data']=$this->Common->no_cond('ebooks');
        $result['ebook_cat']=$this->Common->no_cond('libcategory');
        $result['ebook_cat']=$this->Common->no_cond('libcategory');
        $result['ebook_author']=$this->Common->no_cond('libauthors');
		$this->load->view('ebook_create',$result);	

		if ($this->input->post('submit')) {

			$config['allowed_types'] = 'jpg|pdf';
            $config['upload_path'] = './upload/ebook/';
            $this->load->library('upload', $config);

                if($this->upload->do_upload('file_image')){
                    $file = $this->upload->data('file_name');

                    $this->upload->do_upload('cover_image');
                    $file2 = $this->upload->data('file_name');

                    $this->Ren_model->ebook_insert($file,$file2);
                    //$this->Ren_model->insert_at('Create New Order of Business '.$this->db->insert_id());
                    $this->session->set_flashdata('success', 'Successfully saved');
                    redirect(base_url().'Library/ebooks');

                }else{
                    print_r($this->upload->display_errors()); 
                }

        }

  	}


    function ebook_file_update(){

			$config['allowed_types'] = 'jpg|pdf';
            $config['upload_path'] = './upload/ebook/';
            $this->load->library('upload', $config);

                if($this->upload->do_upload('file_image')){
                    $file = $this->upload->data('file_name');

                    $ebook = $this->Common->one_cond_row('ebooks','id',$this->input->post('id'));
                    unlink("upload/ebook/".$ebook->file_image);

                    $this->Ren_model->ebook_file_update($file);
                    //$this->Ren_model->insert_at('Create New Order of Business '.$this->db->insert_id());
                    $this->session->set_flashdata('success', 'Successfully saved');
                    redirect(base_url().'Library/ebooks');

                }else{
                    print_r($this->upload->display_errors()); 
                }
		
  	}

	function ebook_edit(){
        $result['data']=$this->Common->no_cond('ebooks');
        $result['ebook_cat']=$this->Common->no_cond('libcategory');
        $result['ebook_author']=$this->Common->no_cond('libauthors');
        $result['ebook']=$this->Common->one_cond_row('ebooks','id',$this->uri->segment(3));
        $this->load->view('ebook_edit',$result);	

        if ($this->input->post('submit')) {
            $this->Ren_model->ebook_update();
            $this->session->set_flashdata('success', 'Updated successfully');
            redirect(base_url().'Library/ebooks');

        }

		
  	}

      function ebook_delete(){
        $ebook = $this->Common->one_cond_row('ebooks','id',$this->uri->segment(3));
        unlink("upload/ebook/".$ebook->file_path);
        unlink("upload/ebook/".$ebook->cover_image);
		$this->Ren_model->del('ebooks','id',$this->uri->segment(3));
        $this->session->set_flashdata('danger', 'Successfully deleted.');
        redirect(base_url().'Library/ebooks');
  	}

    public function page( $page = 1 ){
          // Here we get and show our foos
          //$this->load->model('foos_model');
          $view_data['foos'] = $this->Ren_model->get_foos( $page );
      
          // Load the view and pass in the foos
          $this->load->view('foos_view', $view_data);
    }

	

	 

	    




    function other_settings(){
		$result['data'] = $this->LibraryModel->get_other_settings();
		$this->load->view('other_settings', $result);
	}


    public function add_other_settings() {
        if ($this->input->post('save')) {
            $data = array(
                'fullname' => $this->input->post('fullname'),
                'position' => $this->input->post('position'),
                'no_days' => $this->input->post('no_days'),
                'penalty' => $this->input->post('penalty')
            );
            
            $this->load->model('LibraryModel');
            $this->LibraryModel->insert_other_settings($data);
    
            // Set flash message BEFORE redirecting
            $this->session->set_flashdata('message', 'Record saved successfully');
    
            redirect('Library/other_settings'); 
        } 
        $this->load->view('other_settings_add');
    }
    

	public function update_other_settings()
    {
        $libID = $this->input->get('libID');
        $result['data'] = $this->LibraryModel->get_other_settings_byId($libID);
        $this->load->view('other_settings_update', $result);

        if ($this->input->post('update')) {

			$fullname = $this->input->post('fullname');
			$position = $this->input->post('position');
			$no_days = $this->input->post('no_days');
			$penalty = $this->input->post('penalty');

            $this->LibraryModel->update_other_settings($libID, $fullname, $position, $no_days, $penalty);
            $this->session->set_flashdata('message', 'Record updated successfully');

            redirect("Library/other_settings");
        }
    }


	public function Delete_other_settings()
    {
        $libID = $this->input->get('libID');
        if ($libID) {
            $this->LibraryModel->Delete_other_settings($libID);
            $this->session->set_flashdata('message', 'Record deleted successfully');
        } else {
            $this->session->set_flashdata('message', 'Error deleting record');
        }

        redirect("Library/other_settings");
    }



    public function update_borrow()
    {
        $bookID = $this->input->get('bookID'); // Get bookID from URL
        $data['borrow'] = $this->LibraryModel->getBorrowById($bookID); // Fetch data
        $data['book'] = $this->LibraryModel->bookData1();
        $data['stude'] = $this->LibraryModel->reportsAllstudent();
        $data['set'] = $this->LibraryModel->get_other_settings();
        
    
        if ($this->input->post('update')) {
            $updateData = [
               
                'StudentNumber' => $this->input->post('StudentNumber'),
                'name' => $this->input->post('name'),
                'borrow_date' => $this->input->post('borrow_date'),
                'return_date' => $this->input->post('return_date')
            ];
    
            $this->LibraryModel->update_borrow($bookID, $updateData);
            $this->session->set_flashdata('message', 'Record updated successfully');
            redirect("Library/borrow"); // Redirect to borrow list page
        }
    
        $this->load->view('lib_book_borrow_update', $data);
    }
    


}