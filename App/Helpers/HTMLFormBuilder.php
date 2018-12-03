<?php

namespace Helpers;

class HTMLFormBuilder
{
	public $form;
	public $action;
	public $token;
	// Application prefix will be prepended to class names and ids
	public $application_prefix;
	public $javascript_resource_url;

	public $form_beginning =
	'
	<!-- BEGIN FORM -->
	<script type="text/javascript" src="{{javascript_resource_url}}"></script>
	<div class="{{application_prefix}}form-container">
		<form action="{{action}}" id="" method="post">
			<div style="position:absolute;left:-10000px;"><input type="text" name="test" tabindex="-1" value="--Some Value Here--" autocomplete="off"></div>
			<input type="hidden" name="token" value="{{token}}" />
			<table class="">';

	public $form_body = "";

	public $form_end =
	'
			</table>
		</form>
	</div>
	<!-- END FORM -->
	';

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

	public function setApplicationPrefix( $prefix )
	{
		$this->application_prefix = $prefix;
	}

	public function setJavascriptResourceURL( $url )
	{
		$this->javascript_resource_url = $url;
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

		$requiredAttribute = "";
		$requiredIndicator = "";
		if ( $required ) {
			$requiredAttribute = " required=\"required\"";
			$requiredIndicator = " <span class=\"{{application_prefix}}required\">*</span>";
		}

		if ( $type == "message" ) {
			$this->form_body = $this->form_body . '
			<tr>
				<td>
					<label class="{{application_prefix}}form-label" for="">' . ucwords( $name ) . '</label>' . $requiredIndicator . '
					<br/>
					<textarea autocomplete="off" class="{{application_prefix}}form-textarea" id=""' . $requiredAttribute . ' name="' . preg_replace( "/[\s]+/", "_", strtolower( trim( $name ) ) ) . '"/></textarea>
				</td>
			</tr>';
		} else {
			$this->form_body = $this->form_body . '
			<tr>
				<td>
					<label class="{{application_prefix}}form-label" for="">' . ucwords( $name ) . '</label>' . $requiredIndicator . '
					<br/>
					<input autocomplete="off" class="{{application_prefix}}form-input" id=""' . $requiredAttribute . ' name="' . preg_replace( "/[\s]+/", "_", strtolower( trim( $name ) ) ) . '" type="' . $inputType . '" />
				</td>
			</tr>';
		}

	}

	private function build()
	{
		$this->form = $this->form_beginning . $this->form_body . $this->form_end;
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
		$this->form = preg_replace( "/\{\{application_prefix\}\}/", $this->application_prefix, $this->form );
		$this->form = preg_replace( "/\{\{javascript_resource_url\}\}/", $this->javascript_resource_url, $this->form );
	}

	public function getFormHTML()
	{
		$this->build();
		$this->replaceTags();

		return htmlentities( $this->form );
	}
}
