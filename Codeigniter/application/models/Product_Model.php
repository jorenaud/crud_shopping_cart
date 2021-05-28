<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_Model extends CI_Model {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function getAll()
	{
		$query = $this->db->get('products', 10);
        return $query->result_array();
	}

	public function deleteById($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('products');
		return true;
	}

	public function getCountByName($name)
	{
		$this->db->where('name', $name);
		$query = $this->db->get('products');
		return $query->num_rows();
	}

	public function updateById($id, $file_name)
	{
		if ($file_name != ""){
			$data = array(
				'name' => $this->input->post("name"),
				'price' => $this->input->post("price"),
				'stock' => $this->input->post("stock"),
				'image' => $file_name
			);	
		}else{
			$data = array(
				'name' => $this->input->post("name"),
				'price' => $this->input->post("price"),
				'stock' => $this->input->post("stock")
			);	
		}
		
		$this->db->set($data);
		$this->db->where('id', $id);
		$this->db->update('products'); 

		return true;
	}

	public function increase($name, $file_name)
	{
		// echo 'stock + ' . $this->input->post("stock");die();
		$data = array(
			'name' => $this->input->post("name"),
			'price' => $this->input->post("price"),
			'image' => $file_name
		);	
		$this->db->where('name', $name);
		$this->db->set($data);
		$this->db->set('stock', 'stock+'. $this->input->post("stock"), FALSE);
		$this->db->update('products'); 

		return true;
	}

	public function create($file_name)
	{
		$data = array(
			'name' => $this->input->post("name"),
			'price' => $this->input->post("price"),
			'stock' => $this->input->post("stock"),
			'image' => $file_name
		);
		
		$this->db->insert('products', $data);

		return true;
	}
}
