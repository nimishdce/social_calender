<?php
	class Md_video extends CI_Model{
	public function __construct(){
		parent::__construct();
	}

	/*function insert_video gets parameters as a string separated by , as inputs 
	assuming the inputs are in order event_id,added_by,path 
	video_id and date_added are automatically assigned 
	*/
	public function insert_video($params){
		$this->load->database();
		$this->load->library('table');
		
		$data=explode(",",$params);
		$data[4] = date('m/d/Y h:i:s a', time());
		$query=$this->db->query("INSERT INTO video (event_id,added_by,path,date_added) VALUES('".$data[1]."','".$data[2]."','".$data[3]."','".$data[4]."')");
		if($this->db->affected_rows() == 1){
			return 1;
		}
		else{
		return 0;
		}
	}
	
	/*
	function edit_video edits or updates the invite table
	function edit_video gets parameters as a string separated by , as inputs 
	assuming that the input is in order video_id,event_id,added_by,path 
	*/
	public function edit_video($params){
		$this->load->database();
		$this->load->library('table');
		
		$data=explode(",",$params);
		$data[4] = date('m/d/Y h:i:s a', time());
		$query=$this->db->query("UPDATE video SET video_id='".$data[0]."' AND event_id='".$data[1]."' AND added_by='".$data[2]."'  AND path='".$data[3]."' AND date_added='".$data[4]."' WHERE video_id='".$data[0]."'");
		if($this->db->affected_rows() == 1){
			return 1;
		}
		else{
			return 0;
		}
	}
	
	/**
	function delete_video takes video_id as argument
		$id -> video_id of the video to be deleted
		and deletes the row with that video_id in table video
	*/
	public function delete_video($id) {
		$this->load->database();
		$this->load->library('table');
		$query = $this->db->query("DELETE FROM video WHERE video_id='".$id."'");
		if($this->db->affected_rows() ==1){
			return 1;
		}
		else{
			return 0;
		}
	}
	
	//function show_video_table displays the video table 
	public function show_video_table()
	{
	$this->load->database();
	$query =$this->db->query(SELECT * FROM video);
	$this->load->library('table');
	echo $this->table->generate($query);
	}
	
}
