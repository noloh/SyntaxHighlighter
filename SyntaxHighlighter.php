<?php
/**
*  SyntaxHilighter Nodule Class
*  Created by NOLOH LLC.
*  @link http://www.noloh.com
* 
*  Using Alex Gorbatchev's SyntaxHighlighter
*  @link http://alexgorbatchev.com/wiki/SyntaxHighlighter
*/
class SyntaxHighlighter extends MarkupRegion
{
	/**
	* Language Constants
	*/
	const Cpp = 'Cpp', CSharp = 'CSharp', CSS = 'Css', Delphi = 'Delphi', Java = 'Java', JavaScript = 'JScript', PHP = 'Php',
	Python = 'Python', Ruby = 'Ruby', SQL = 'Sql', VisualBasic = 'Vb', XML = 'Xml', Plain = 'Plain';
	/**
	* Used to store this instance's set language
	* 
	* @var string
	*/
	private $Language;
	/**
	* Constructor
	* 
	* @param string|file $code
	* @param mixed $language
	* @param mixed $left
	* @param mixed $top
	* @param mixed $width
	* @param mixed $height
	* @return SyntaxHighlighter
	*/
	function SyntaxHighlighter($code, $language=self::PHP, $left=0, $top=0, $width=100, $height=100)
	{
		if($language == null)
			$language = Self::Plain;
		$this->Language = $language;
		parent::MarkupRegion(null, $left, $top, $width, $height);
		$this->SetConfig('tagName', 'div');
		$this->SetText($code);	
	}
	/**
	* Override of default SetText to set text of SyntaxHighlighter
	* and wrap in specific div, according to SyntaxHighlighter docs.
	* 
	* @param string $code
	*/
	function SetText($code)
	{
		if(is_file($code))
			$code = file_get_contents($code);
		$code = htmlspecialchars($code);
		$code = '<div class=\'' . 'brush: ' . strtolower($this->Language) . '\'>' . $code . '</div>';
		//Call Parent SetText with constructed code string
		parent::SetText($code);
		//RaceQueue SyntaxHighlighter's ClientSide highlight function
		ClientScript::RaceQueue($this, 'SyntaxHighlighter', 'SyntaxHighlighter.highlight');
	}
	/**
	* Set SyntaxHighlighter default
	* See SyntaxHighlighter website for more details.
	* @link http://alexgorbatchev.com/wiki/SyntaxHighlighter:Configuration
	* 
	* @param string $option Default option to set
	* @param mixed $value Default option value
	*/
	function SetDefault($option, $value)
	{
		ClientScript::RaceQueue($this, 'SyntaxHighlighter', 'SyntaxHighlighter.defaults.' . $option . ' = ' . ClientEvent::ClientFormat($value) .';');
	}
	/**
	* Set SyntaxHighlighter Configuration option
	* See SyntaxHighlighter website for a list of config options
	* @link http://alexgorbatchev.com/wiki/SyntaxHighlighter:Configuration
	* 
	* @param string $option Conifguration option to be set
	* @param mixed $value Configuration option value
	* @return 
	 */
	function SetConfig($option, $value)
	{
		ClientScript::RaceQueue($this, 'SyntaxHighlighter', 'SyntaxHighlighter.config.' . $option . ' = ' . ClientEvent::ClientFormat($value) .';');
	}
	/**
	* Do not call manually! Override of default Show(). Triggers when SyntaxHighlighter instance is initially shown.
	*/
	function Show()
	{
		parent::Show();
		$relativePath = System::GetRelativePath(getcwd(), dirname(__FILE__));
		ClientScript::AddSource($relativePath . '/scripts/shCore.js', false);
		ClientScript::AddSource($relativePath . '/scripts/shBrush' . $this->Language . '.js', false);
		WebPage::That()->CSSFiles->Add($relativePath . '/styles/shCore.css');
		WebPage::That()->CSSFiles->Add($relativePath . '/styles/shThemeDefault.css');
	}
}
?>