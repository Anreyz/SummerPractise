<?php

class Uploader
{
	public $nameField;
	
	public function __construct($nameField)
	{
		$this->nameField = $nameField;  

	}

	public function isUploaded()
	{
		if ($this->nameField['error'] == 0){
			$this->upload();
		} 
	}

	public function upload()
	{
		move_uploaded_file(
			$this->nameField['tmp_name'], 
			__DIR__ . '/../files/' . $this->nameField['name']
		); 
	}
}