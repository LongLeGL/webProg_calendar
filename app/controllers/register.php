<?php

class Register extends Controller
{
	private $model;

    public function __construct()
	{
		$this->model = $this->model("registerModel");
    }

	public function render()
	{
		$this->view("auth_layout", [
			"page"=> 'register',
		]);
	}

	// define function for running register
}