<?php


class RouteParser {

	public function __construct($url_pattern)
	{
		$this->route_pattern_segments 	= NULL;
		$this->route_id 				= NULL;
		$this->route_parameter_names 	= [];
		$this->route_parameter_values 	= [];

		$this->initialize($url_pattern);
	}
	
	
	public function create_route_id()
	{
		for($i = 0; $i < count($this->route_pattern_segments); $i++)
		{
			if(!preg_match('/:/', $this->route_pattern_segments[$i])) {
				$this->route_id .= $this->route_pattern_segments[$i];
			}
		}
		$this->route_id .= count($this->route_pattern_segments);
	}

	public function parameter_values()
	{
		return $this->route_parameter_values;
	}

	private function initialize($url_pattern)
	{
		$this->route_pattern_segments = $this->segment_route_string($url_pattern);
		$this->validate_route_string();
		$this->create_route_id();
	}

	private function populate_parameter_values()
	{
		$url_segments = UrlScanner::url_segments();
		if(count($url_segments) > 1) {
			for($i = 0; ($i < count($url_segments)-1) and $i < count($this->route_parameter_names); $i++) {
				if(!preg_match('/:/', $this->route_pattern_segments[$i])) {
					$this->route_parameter_values[$this->route_parameter_names[$i]] = $url_segments[$i+1];
				}
			}
		}
	}

	private function validate_route_string()
	{
		if(count($this->route_pattern_segments) == 0)
			throw new Exception('$url_pattern must contain a noun');
		if(count($this->route_pattern_segments) == 1) {
			$this->validate_noun();
			return;
		}
		$this->validate_noun();
		$this->validate_no_url_parameters_without_nouns();
		for($i = 1; $i < count($this->route_pattern_segments); $i++) {
			$pattern = '/:([^:\/]*)/';
			preg_match($pattern, $this->route_pattern_segments[$i], $matches);
			/*
			if(count($matches) < 1)
				throw new Exception('Url pattern is not in valid format');
			*/
			if(preg_match('/\s/', $matches[1]))
				throw new Exception('Url pattern is not in valid format, should not contain white space');
			$this->route_parameter_names[] 	= $matches[1];
		}
		$this->populate_parameter_values();
	}

	private function validate_noun()
	{
		if(preg_match('/:/', $this->route_pattern_segments[0]))
			throw new Exception('Noun cannot be an URL-Parameter!');
	}

	private function validate_no_url_parameters_without_nouns()
	{
		for($i = 1; $i < count($this->route_pattern_segments); $i++) {

			if(count($this->route_pattern_segments) > $i)
			{
				$segment = $this->route_pattern_segments[$i];
				$next_segment = $this->route_pattern_segments[$i+1];
				if(preg_match('/:/', $segment) && preg_match('/:/', $next_segment))
					throw new Exception('Not allowed to create URL-parameter without a noun before the parameter!');
			}
		}
	}

	private function segment_route_string($url_pattern)
	{
		if(is_string($url_pattern) == false)
			throw new Exception('$url_pattern must be a string');
		$segments = explode('/', $url_pattern);
		return array_values(array_filter($segments));
	}
}


