<?php

Loader::loadModule("S");

class PdfSController extends SController
{
	public function execute()
	{
		parent::execute();
		parent::setViewer("file");
//		parent::setViewer(NULL);
		
		$__url = "http://".Uri::getUrl().urldecode(Request::getString("url"));
//		$__url = "http://".urldecode(Request::getString("url"));

		$__tokens = explode(".", microtime(true));
		$__filename = md5($__tokens[0].str_pad($__tokens[1], 4, "0"));

		$__path = Router::getAppFolder().DS."data".DS."temp".DS.$__filename.".pdf";
		
		$exec = "xvfb-run -a -s \"-screen 0 1024x768x16\" wkhtmltopdf "
				. "--dpi 300 "
				. "--page-size A4 "
				. "--encoding utf-8 "
				. "-T 10mm -B 10mm -L 30mm -R 10mm "
				. (Request::getInt("without_header") == 1 ? " " : "--header-html http://".Uri::getUrl()."/html/document/header.html ")
				. "--header-spacing 3 "
//				. "--footer-html http://".Uri::getUrl()."/html/document/footer.html "
//				. "--footer-spacing 3 "
				. "'{$__url}' "
				. "{$__path}";

		exec($exec);
		
		$this->fileName = $__path;
	}
}
