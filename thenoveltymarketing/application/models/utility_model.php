<?php
class Utility_model extends CI_Model {

	public function __construct()
	{
				
	}

	public function create_random_string($type,$length)
	{
		$random_string = '';
		$value = '';
		switch ($type) {
			case 'alpha_numeric':
				$random_string = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
				break;

			case 'alpha_numeric_uc':
				$random_string = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
				break;
			
			case 'alpha':
				$random_string = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
				break;

			case 'numeric':
				$random_string = '1234567890';
				break;

			default:
				$random_string = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
				break;
		}
		for ($i=0; $i < $length; $i++) { 
			$value .= $random_string[rand(0,strlen($random_string)-1)];
		}
		return $value;
	}

	public function create_unique_random_string($type,$length,$table,$field)
	{
		$num_found = 1;
		$value = '';
		while($num_found > 0):
			$value = $this->utility_model->create_random_string( $type, $length );
			$query = $this->db->get_where($table, array($field => $value));
			$num_found = $query->num_rows();
		endwhile;
		return $value;
	}

	public function create_unique_id($name,$type,$length,$table,$field)
	{
		$month_cor = array();

		$month_cor[] = 'J';
		$month_cor[] = 'F';
		$month_cor[] = 'H';
		$month_cor[] = 'A';
		$month_cor[] = 'Y';
		$month_cor[] = 'N';
		$month_cor[] = 'L';
		$month_cor[] = 'A';
		$month_cor[] = 'S';
		$month_cor[] = 'O';
		$month_cor[] = 'N';
		$month_cor[] = 'D';

		$num_found = 1;
		$value = '';
		while($num_found > 0):
			$value = strtoupper(substr($name['firstname'],0,1)) . strtoupper(substr($name['lastname'],0,1)) . date('y') . $month_cor[date('n')-1] . $this->utility_model->create_random_string( $type, $length );
			$query = $this->db->get_where($table, array($field => $value));
			$num_found = $query->num_rows();
		endwhile;

		return $value;
	}

	public function get_name($account_id)
	{
		$query_string = "SELECT first_name, last_name FROM profile WHERE account_id = '$account_id'";
		$query = $this->db->query($query_string);
		$value = null;
		if ( $query->num_rows() > 0 ) {
			$value = $query->first_row()->last_name . ', ' . $query->first_row()->first_name;
		}
		return $value;
	}

	public function get_data($tablecolumn,$options=null)
	{
		$query = '';
		$tablecolumn = explode('.', $tablecolumn);
		if($options==null):
			if(count($tablecolumn) > 1): $this->db->select($tablecolumn[1]); endif;
			$query = $this->db->get($tablecolumn[0]);
		else:
			if(count($tablecolumn) > 1): $this->db->select($tablecolumn[1]); endif;
			$query = $this->db->get_where($tablecolumn[0],$options);
		endif;
		return $query;
	}

}