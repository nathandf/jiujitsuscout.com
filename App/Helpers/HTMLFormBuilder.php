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
	public $form_offer;

	public $form_beginning =
	'
	<!-- BEGIN FORM -->
	<script type="text/javascript" src="{{javascript_resource_url}}"></script>
	<div class="{{application_prefix}}form-container">
		<p class="{{application_prefix}}form-offer">{{form_offer}}</p>
		<form action="{{action}}" id="" method="post" target="_parent">
			<div style="position:absolute;left:-9999px;">
				<input id="f873f916d9706847402b08cd30c5d584" type="text" name="f873f916d9706847402b08cd30c5d584" tabindex="-1" autocomplete="off">
			</div>
			<input type="hidden" name="token" value="{{token}}" />';

	public $form_body = "";

	public $form_end =
	'
			<br\>
			<button type="submit" class="EmbeddableFormWidgetByJiuJitsuScout__form-submit-button EmbeddableFormWidgetByJiuJitsuScout__material-hover"/>Get Offer Now ></button>
		</form>
	</div>
	<!-- END FORM -->
	';

	public function setAction( $url )
	{
		if ( filter_var( $url, FILTER_VALIDATE_URL ) ) {
			$this->action = $url;
			return $this;
		}

		throw new \Exception( "The action you provided is not a valid URL" );
	}

	public function setToken( $token )
	{
		$this->token = $token;
		return $this;
	}

	public function setApplicationPrefix( $prefix )
	{
		$this->application_prefix = $prefix;
		return $this;
	}

	public function setJavascriptResourceURL( $url )
	{
		$this->javascript_resource_url = $url;
		return $this;
	}

	public function setFormOffer( $form_offer )
	{
		$this->form_offer = $form_offer;
		return $this;
	}

	public function addField( $name, $type, $required = false, $text = null, $value = null )
	{
		$inputType = "text";
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
			<div class="{{application_prefix}}field-container">
				<label class="{{application_prefix}}form-input-label" for="">' . ucwords( $name ) . '</label>' . $requiredIndicator . '
				<br/>
				<textarea autocomplete="off" class="{{application_prefix}}form-textarea" id=""' . $requiredAttribute . ' name="' . preg_replace( "/[\s]+/", "_", strtolower( trim( $name ) ) ) . '"/></textarea>
			</div>';
		} else {
			switch ( $type ) {
				case "email":
					$inputType = "email";
					break;
				case "phone number":
					$inputType = "number";
					break;
			}
			$this->form_body = $this->form_body . '
			<div class="{{application_prefix}}field-container">
				<label class="{{application_prefix}}form-input-label" for="">' . ucwords( $name ) . '</label>' . $requiredIndicator . '
				<br/>
				<input autocomplete="off" class="{{application_prefix}}form-input" id=""' . $requiredAttribute . ' name="' . preg_replace( "/[\s]+/", "_", strtolower( trim( $name ) ) ) . '" type="' . $inputType . '" />
			</div>';
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
		$this->form = preg_replace( "/\{\{form_offer\}\}/", $this->form_offer, $this->form );
	}

	public function getFormHTML()
	{
		$this->build();
		$this->replaceTags();

		return htmlentities( $this->form );
	}
}
