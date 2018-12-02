<?php

namespace Helpers;

class HTMLFormBuilder
{
	public $form;
	public $action;
	public $token;

	public $form_beginning =
	'
	<!-- BEGIN FORM -->
	<div>
		<form action="{{action}}" class="" id="" method="post">
			<div style="position:absolute;left:-10000px;"><input type="text" name="test" tabindex="-1" value="--Some Value Here--" autocomplete="off"></div>
			<input type="hidden" name="token" value="{{token}}" />
			<table class="">';

	public $form_end =
	'
			</table>
		</form>
	</div>
	<!-- END FORM -->
	';

	public function __construct()
	{
		$this->form = $this->form_beginning;
	}

	public function setAction( $url )
	{
		if ( filter_var( $url, FILTER_VALIDATE_URL ) ) {
			$this->action = $url;
			return;
		}

		throw new \Exception( "The action you provided is not a valid URL" );

	}

	public function setToken( $token )
	{
		$this->token = $token;
	}

	public function addField( $name, $type, $required = false, $text = null, $value = null )
	{
		$isSubmitType = true;
		$inputType = "submit";

		if ( $type != "submit" ) {
			$isSubmitType = false;
			$inputType = "text";
		}

		$hasText = true;

		if ( is_null( $text ) ) {
			$hasText = false;
		}

		$requiredAttribute = $required ? " required=\"required\"" : "";

		switch ( $isSubmitType ) {
			case false:
				$this->form = $this->form . '
				<tr>
					<td>
						<label for="">' . ucwords( $name ) . '</label>
						<br/>
						<input autocomplete="off" id=""' . $requiredAttribute . ' name="' . preg_replace( "/[\s]+/", "_", strtolower( trim( $name ) ) ) . '" type="' . $inputType . '" />
					</td>
				</tr>';
				break;
			case true:
				$buttonText = $hasText ? $text : ucwords( $type );
				$this->form = $this->form . '
				<tr>
					<td>
						<button type="submit" id=""' . $requiredAttribute . '/>' . $buttonText . '</button>
					</td>
				</tr>';
				break;
		}
	}

	private function replaceTags()
	{
		if ( isset( $this->action ) == false ) {
			throw new \Exception( "No action has been specified for this form" );
		}

		if ( isset( $this->token ) == false ) {
			throw new \Exception( "No token has been specified for this form" );
		}

		$this->form = preg_replace( "/\{\{action\}\}/", $this->action, $this->form );
		$this->form = preg_replace( "/\{\{token\}\}/", $this->token, $this->form );
	}

	public function getFormHTML()
	{
		$this->replaceTags();
		return htmlentities( $this->form . $this->form_end );
	}
}
