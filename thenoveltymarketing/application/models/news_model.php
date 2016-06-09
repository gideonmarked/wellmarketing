<?php
class News_model extends CI_Model {

	public function __construct()
	{
		// $this->load->database();
	}

	public function get_news($slug = FALSE)
	{
		if ($slug === FALSE)
		{
			// $query = $this->db->get('news');
			// return $query->result_array();
		}

		$query = $this->db->order_by('creation_timestamp', 'ASC')->get_where('news');
		return $query->result_array();
	}
}