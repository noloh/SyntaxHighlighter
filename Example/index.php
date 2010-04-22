<?php
require_once("/var/www/htdocs/Stable/NOLOH/NOLOH.php");
require_once("../SyntaxHighlighter.php");

class HighlighterTest extends WebPage 
{	
	function HighlighterTest()
	{
		parent::WebPage('Syntax Highlighter Example');
		/*Instantiate new SyntaxHighlighter pointing to file code.txt, 
		using PHP, with  a location of 0, 0, and a Size of null, null*/
		$highlighter = new SyntaxHighlighter('code.txt', SyntaxHighlighter::PHP, 0, 0, null, null);
		//Add SyntaxHighlighter to the WebPage
		$this->Controls->Add($highlighter);
	}
}
?>