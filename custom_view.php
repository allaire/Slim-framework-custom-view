<?php
class custom_view extends Slim_View
{
	static protected $_layout = NULL;
	static protected $_data   = NULL;

	public static function set_layout($layout = NULL, $data = array())
	{
		self::$_data = $data;
		self::$_layout = $layout;
	}

	public static function set_data($data = NULL)
	{
		self::$_data = $data;
	}

	public function render($template)
	{
		$template_path = $this->getTemplatesDirectory() . '/' . ltrim($template, '/');

		if (!file_exists($template_path))
		{
			throw new RuntimeException('View cannot render template `' . $template_path . '`. Template does not exist.');
		}

		extract($this->data);

		ob_start();
		require $template_path;
		$html = ob_get_clean();
		
		return $this->_render_layout($html);
	}

	private function _render_layout($content)
	{
		if(self::$_layout !== NULL)
		{
			$layout_path = $this->getTemplatesDirectory() . '/' . ltrim(self::$_layout, '/');

			if (!file_exists($layout_path))
			{
				throw new RuntimeException('View cannot render layout `' . $layout_path . '`. Layout does not exist.');
			}

			extract(self::$_data);

			ob_start();
			require $layout_path;
			$view = ob_get_clean();
		}

		return $view;
	}

}
?>