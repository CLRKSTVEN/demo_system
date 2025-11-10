<?php
class LibraryModel extends CI_Model 
{



    public function getTotalTitleCount()
    {
        $this->db->select('COUNT(DISTINCT Title) as total_titles');
        $this->db->from('libbookentry');
        $query = $this->db->get();
        $result = $query->row();
        return $result->total_titles;
    }

    public function getTotalBooks()
    {
        $this->db->select('COUNT(DISTINCT BookID) as total_books');
        $this->db->from('libbookentry');
        $query = $this->db->get();
        $result = $query->row();
        return $result->total_books;
    }

    public function getTotalCategories()
    {
        $this->db->select('COUNT(DISTINCT Category) as total_cat');
        $this->db->from('libbookentry');
        $query = $this->db->get();
        $result = $query->row();
        return $result->total_cat;
    }
    

    
    
	function reportsAllBooks()
	{
	$query=$this->db->query("Select * from libbookentry");
	return $query->result();
	}


    function reportsAllstudent()
	{
	$query=$this->db->query("Select * from studeprofile");
	return $query->result();
	}
	
	
	function bookDetails($id)
	{
	$query=$this->db->query("Select * from libbookentry where BookID='".$id."'");
	return $query->result();
	}
	
	function getBookCategory()
	{
		$this->db->select('*');
		$this->db->order_by('Category','ASC');
		$query=$this->db->get('libcategory');
		return $query->result();

	}
	
	function getBookLocation()
	{
		$this->db->select('*');
		$this->db->order_by('location','ASC');
		$query = $this->db->get('liblocation');
		return $query->result();
	}
	
	function getPublisher()
	
	{
		$this->db->select('*');
		$this->db->order_by('publisher','ASC');
		$query=$this->db->get('libpublisher');
		return $query->result();
	}

	public function getAuthors() {
		$query = $this->db->get('libauthors'); 
		return $query->result();
	}

	
    public function getAuthorbyId($authorID)
    {
        $query = $this->db->query("SELECT * FROM libauthors WHERE authorID = '" . $authorID . "'");
        return $query->result();
    }
	
	public function updateAuthor($authorID, $AuthorNum, $FirstName, $MiddleName, $LastName)
    {
        $data = array(
            'AuthorNum' => $AuthorNum,
            'FirstName' => $FirstName,
			'MiddleName' => $MiddleName,
            'LastName' => $LastName,
        );
        $this->db->where('authorID', $authorID);
        $this->db->update('libauthors', $data);
    }



	public function insertAuthor($data) {
        $this->db->insert('libauthors', $data);
    }

	public function Delete_Author($authorID)
    {
        $this->db->where('authorID', $authorID);
        $this->db->delete('libauthors');
    }


	public function getCategory() {
		$query = $this->db->get('libcategory'); 
		return $query->result();
	}

	public function insertcategory($data) {
        $this->db->insert('libcategory', $data);
    }

	public function getcategorybyId($catID)
    {
        $query = $this->db->query("SELECT * FROM libcategory WHERE catID = '" . $catID . "'");
        return $query->result();
    }

	public function updatecategory($catID, $Category)
    {
        $data = array(
            'Category' => $Category,
           
        );
        $this->db->where('catID', $catID);
        $this->db->update('libcategory', $data);
    }

	public function Delete_category($catID)
    {
        $this->db->where('catID', $catID);
        $this->db->delete('libcategory');
    }

	

	public function getLocation() {
		$query = $this->db->get('liblocation'); 
		return $query->result();
	}

	public function insertlocation($data) {
        $this->db->insert('liblocation', $data);
    }

	public function getlocationbyId($locID)
    {
        $query = $this->db->query("SELECT * FROM liblocation WHERE locID = '" . $locID . "'");
        return $query->result();
    }

	public function updatelocation($locID, $location)
    {
        $data = array(
            'location' => $location,
           
        );
        $this->db->where('locID', $locID);
        $this->db->update('liblocation', $data);
    }

	public function Delete_location($locID)
    {
        $this->db->where('locID', $locID);
        $this->db->delete('liblocation');
    }


	public function get_publisher() {
		$query = $this->db->get('libpublisher'); 
		return $query->result();
	}

	public function insertpublisher($data) {
        $this->db->insert('libpublisher', $data);
    }

	public function getpublisherbyId($pubID)
    {
        $query = $this->db->query("SELECT * FROM libpublisher WHERE pubID = '" . $pubID . "'");
        return $query->result();
    }

	public function updatepublisher($pubID, $publisher)
    {
        $data = array(
            'publisher' => $publisher,
           
        );
        $this->db->where('pubID', $pubID);
        $this->db->update('libpublisher', $data);
    }

	public function Delete_publisher($pubID)
    {
        $this->db->where('pubID', $pubID);
        $this->db->delete('libpublisher');
    }
 
	//Student Total Semesters Enrolled
	function semStudeCount($id)
	{
	$query=$this->db->query("SELECT StudentNumber, count(Semester) as SemesterCounts FROM semesterstude where StudentNumber='".$id."' group by StudentNumber");

	return $query->result();

        if($query->num_rows() > 0)
        {
           return $query->result();
        }
        return false;
	}


    
























    public function get_other_settings() {
		$query = $this->db->get('lib_other_settings'); 
		return $query->result();
	}

	public function insert_other_settings($data) {
        $this->db->insert('lib_other_settings', $data);
    }

	public function get_other_settings_byId($libID)
    {
        $query = $this->db->query("SELECT * FROM lib_other_settings WHERE libID = '" . $libID . "'");
        return $query->result();
    }

	public function update_other_settings($libID, $fullname, $position, $no_days, $penalty)
    {
        $data = array(
            'fullname' => $fullname,
            'position' => $position,
            'no_days' => $no_days,
            'penalty' => $penalty,
           
        );
        $this->db->where('libID', $libID);
        $this->db->update('lib_other_settings', $data);
    }

	public function Delete_other_settings($libID)
    {
        $this->db->where('libID', $libID);
        $this->db->delete('lib_other_settings');
    }
	

    public function getBorrow() {
		$query = $this->db->get('lib_books_borrow'); 
		return $query->result();
	}

    
    public function getBorrowReturn() {
        $this->db->where('status', 'Received'); // Fetch only records with status = 'Received'
        $query = $this->db->get('lib_books_borrow');
        return $query->result();
    }
    


    public function insert_borrow($data) {
        $this->db->insert('lib_books_borrow', $data);
    }


    public function update_book_status($bookNo, $status) {
        $this->db->where('bookNo', $bookNo);
        $this->db->update('libbookentry', array('stat' => $status));
    }

    


    public function getBorrowed() {
        // Fetch all borrowed books except those that are already received
        $this->db->select('*');
        $this->db->from('lib_books_borrow');
        $this->db->where('status !=', 'Received'); // Exclude received books
        $query = $this->db->get();
        $borrowedBooks = $query->result();
    
        // Fetch penalty rate from settings
        $this->db->select('penalty');
        $this->db->from('lib_other_settings');
        $penaltyQuery = $this->db->get()->row();
        $penaltyRate = $penaltyQuery ? $penaltyQuery->penalty : 0;
    
        // Calculate penalty for each book
        foreach ($borrowedBooks as &$row) {
            $returnDate = strtotime($row->return_date);
            $today = strtotime(date('Y-m-d'));
    
            if ($today > $returnDate) {
                $daysLate = ($today - $returnDate) / (60 * 60 * 24); // Convert seconds to days
                $row->penalty_paid = $daysLate * $penaltyRate;
            } else {
                $row->penalty_paid = 0; // No penalty if not overdue
            }
        }
    
        return $borrowedBooks;
    }
    
    
    function bookData()
    {
        $query = $this->db->query("SELECT * FROM libbookentry WHERE stat != 'Borrowed'");
        return $query->result();
    }
    
    function bookData1()
    {
        $query = $this->db->query("SELECT * FROM libbookentry");
        return $query->result();
    }


    
    public function update_borrow($bookID, $updateData) {
        $this->db->where('bookID', $bookID);
        return $this->db->update('lib_books_borrow', $updateData);
    }
    

    public function getBorrowById($bookID)
{
    $query = $this->db->query("SELECT * FROM lib_books_borrow WHERE bookID = '" . $bookID . "'");
    return $query->row();
}


}
