<?php
require_once("/var/www/htdocs/Projects/NOLOH/NOLOH.php");
require_once("../SyntaxHighlighter.php");

class HighlighterTest extends WebPage 
{	
	function HighlighterTest()
	{
		parent::WebPage('Syntax Highlighter Example');
		$highlighter = new SyntaxHighlighter('code.txt', SyntaxHighlighter::PHP, 0, 0, null, null);
		$this->Controls->Add($highlighter);
	}
}
?>