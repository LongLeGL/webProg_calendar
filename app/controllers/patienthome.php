<?php

class patienthome extends Controller
{
	private $model;

    public function __construct()
	{
		$this->model = $this->model("patienthomeModel");
    }

	public function render()
	{
		$this->view("auth_layout", [
			"page"=> 'patienthome',
		]);
	}

	// define function for running patienthome
}