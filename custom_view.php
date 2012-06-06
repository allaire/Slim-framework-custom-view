<?php
class custom_view extends Slim_View
{
	protected $_layout = NULL;
	protected $_data   = NULL;

	public function set_layout($layout = NULL, $data = array())
	{
		$this->_layout = $layout;
		$this->_data = $data;
	}

	public function set_data($data = NULL)
	{
		$this->_data = $data;
	}

	/**
	 * Overwrite the render method of Slim_View in order to include it in a layout
	 */
	public function render($template)
	{
		$template_path = $this->getTemplatesDirectory() . '/' . ltrim($template, '/');

		if (!file_exists($template_path))
		{
			throw new RuntimeException('View cannot render template `' . $template_path . '`. Template does not exist.');
		}

		// $this->data refers to Slim framework template (not base layout) variables
		extract($this->data);

		ob_start();
		require $template_path;
		$html = ob_get_clean();
		
		return $this->_render_layout($html);
	}

	/**
	 * Create a similar render method but for the layout (called by the official render method)
	 * At the moment, you have to use $content in your layout to load up your view
	 */
	private function _render_layout($content)
	{
		if($this->_layout !== NULL)
		{
			$layout_path = $this->getTemplatesDirectory() . '/' . ltrim($this->_layout, '/');

			if (!file_exists($layout_path))
			{
				throw new RuntimeException('View cannot render layout `' . $layout_path . '`. Layout does not exist.');
			}

			// Base layout variables
			extract($this->_data);

			ob_start();
			require $layout_path;
			$view = ob_get_clean();
		}

		return $view;
	}

}
?>