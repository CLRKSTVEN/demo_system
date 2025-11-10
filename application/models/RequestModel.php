<?php
class RequestModel extends CI_Model
{
    public function get_all_requests()
    {
        return $this->db->order_by('request_date', 'DESC')->get('document_requests')->result();
    }

    public function get_requests_by_student($studentNumber)
    {
        return $this->db->where('StudentNumber', $studentNumber)->order_by('request_date', 'DESC')->get('document_requests')->result();
    }

    public function insert_request($data)
    {
        return $this->db->insert('document_requests', $data);
    }

    public function update_status($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('document_requests', $data);
    }

    public function get_request($id)
    {
        return $this->db->where('id', $id)->get('document_requests')->row();
    }

    public function log_status_change($data)
{
    return $this->db->insert('document_request_logs', $data);
}

public function get_logs_by_request($request_id)
{
    return $this->db->where('request_id', $request_id)
                    ->order_by('updated_at', 'DESC')
                    ->get('document_request_logs')
                    ->result();
}

public function get_active_document_types()
{
    return $this->db->where('is_active', 1)->order_by('document_name')->get('document_types')->result();
}

// Get all document types
public function get_all_document_types()
{
    return $this->db->order_by('document_name')->get('document_types')->result();
}

// Get a single document type
public function get_document_type($id)
{
    return $this->db->get_where('document_types', ['id' => $id])->row();
}

// Insert new document type
public function insert_document_type($data)
{
    return $this->db->insert('document_types', $data);
}

// Update document type
public function update_document_type($id, $data)
{
    return $this->db->where('id', $id)->update('document_types', $data);
}

// Delete document type
public function delete_document_type($id)
{
    return $this->db->delete('document_types', ['id' => $id]);
}



}
