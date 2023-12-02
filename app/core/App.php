<?php

class App
{
	protected $controller = 'calendar';
	protected $method = 'render';
	protected $params = [];

	public function __construct()
	{
		$page = $this->parsePage();

		if (isset($page[0])){
			if(file_exists('./app/controllers/' . $page[0] . '.php'))
			{
				$this->controller = $page[0];
				unset($page[0]);
			}
		}
		
		require_once './app/controllers/' . $this->controller . '.php';
		$this->controller = new $this->controller;

		if(isset($page[1]))
		{
			if (method_exists($this->controller, $page[1]))
			{
				$this->method = $page[1];
				unset($page[1]);
			}
		}

		$this->params = $page ? array_values($page) : [];

		call_user_func_array([$this->controller, $this->method], $this->params);
	}

	public function parsePage()
	{
		if(isset($_GET['page'])) {
			return explode('/', filter_var(trim($_GET['page'], '/')));
		}
	}
}

?>