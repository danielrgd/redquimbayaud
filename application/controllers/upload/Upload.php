<?php

class Upload extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	function cargar_imagen()
	{

		$nombre_archivo =  $this->session->userdata('logged_in');
		$this->load->library('upload', $this->config->item('image_upload'));

		if ( ! $this->upload->do_upload())
		{
			echo json_encode( array('error' => $this->upload->display_errors()));

		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			echo json_encode( array("file_name"=>$data['upload_data']['file_name']));
		}
	}

	function do_upload()
	{

		$nombre_archivo =  $this->session->userdata('logged_in');
		$this->load->library('upload', $this->config->item('document_upload'));

		if ( ! $this->upload->do_upload())
		{
			echo json_encode( array('error' => $this->upload->display_errors()));

		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			echo json_encode( array("file"=>$data['upload_data']));
		}
	}
}
?>