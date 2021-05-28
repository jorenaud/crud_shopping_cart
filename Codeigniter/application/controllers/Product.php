<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
if($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
	header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
	header('Access-Control-Allow-Headers: Content-Type');
	exit;
}
class Product extends CI_Controller {

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
	public function __construct()
	{
			parent::__construct();
			// Your own constructor code
			$this->load->model('product_model');
	}

	public function index()
	{
		header('Content-Type: application/json');
		$products = $this->product_model->getAll();
		echo json_encode(['products'=>$products]);
	}

	public function store()
	{
		$name = $this->input->post("name");
		$count = $this->product_model->getCountByName($name);
		if($count == 0){
			$file_name = $this->upload();
			$this->product_model->create($file_name);
		}else{
			$file_name = $this->upload();
			$this->product_model->increase($name, $file_name);
		}
		
		header('Content-Type: application/json');
		echo json_encode(['success'=>true]);
	}

	public function update($id)
	{
		$file_name = $this->upload();
		$this->product_model->updateById($id, $file_name);
		
		header('Content-Type: application/json');
		echo json_encode(['success'=>$id]);
	}

	public function destroy($id)
	{
		header('Content-Type: application/json');
		$this->product_model->deleteById($id);
		echo json_encode(['success'=>true]);
	}

	public function upload()
	{
		$config['upload_path']   = './uploads/'; 
		$config['allowed_types'] = 'gif|jpg|png'; 
		$config['max_size']      = 100; 
		$config['max_width']     = 1024; 
		$config['max_height']    = 768;  
		$this->load->library('upload', $config);
		
		if ( ! $this->upload->do_upload('image')) {
			$error = array('error' => $this->upload->display_errors()); 
			
		}
		else { 
			$data = array('upload_data' => $this->upload->data()); 
			return $data["upload_data"]["file_name"];
			
		} 
	}
}
