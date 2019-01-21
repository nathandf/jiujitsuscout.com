<?php

namespace Helpers;

class EmailBuilderHelper
{
	private $videoRepo;
	private $imageRepo;
	public $image_ids = [];
	public $video_ids = [];
	private $videos = [];
	private $images = [];
	public $email_body;

	public function __construct (
		\Model\Services\ImageRepository $imageRepo,
		\Model\Services\VideoRepository $videoRepo
	) {
		$this->imageRepo = $imageRepo;
		$this->videoRepo = $videoRepo;
	}

	public function prepareEmailBody( $email_body )
	{
		$this->setVideoIDs( $this->parseVideoIDs( $email_body ) )
			->setImageIDs( $this->parseImageIDs( $email_body ) )
			->setEmailBody( $email_body );
	}

	public function buildEmailBody() {
		$this->setVideos();
		$this->setImages();
	}

	private function setEmailBody( $email_body ) {
		$this->email_body = $email_body;

		return $this;
	}

	public function getEmailBody()
	{
		return $this->email_body;
	}

	public function parseVideoIDs( $email_body )
	{
		preg_match_all( "/\[\*video([0-9]+)\*\]/", $email_body, $matches );

		if ( isset( $matches[ 1 ] ) == false || empty( $matches[ 1 ] ) ) {
			return [];
		}

		return $matches[ 1 ];
	}

	public function parseImageIDs( $email_body )
	{
		preg_match_all( "/\[\*img([0-9]+)\*\]/", $email_body, $matches );

		if ( isset( $matches[ 1 ] ) == false || empty( $matches[ 1 ] ) ) {
			return [];
		}

		return $matches[ 1 ];
	}

	private function setVideoIDs( $video_ids )
	{
		$this->video_ids = $video_ids;

		return $this;
	}

	private function setImageIDs( $image_ids )
	{
		$this->image_ids = $image_ids;

		return $this;
	}

	public function getVideoIDs()
	{
		return $this->video_ids;
	}

	public function getImageIDs()
	{
		return $this->image_ids;
	}

	public function setVideos()
	{
		$videos = [];
		$video_ids = $this->getVideoIDs();
		foreach ( $video_ids as $video_id ) {
			$video = $this->videoRepo->get( [ "*" ], [ "id" => $video_id ], "single" );
			if ( !is_null( $video ) ) {
				$videos[] = $video;
			}
		}

		$this->videos = $videos;

		return $this;
	}

	public function setImages()
	{
		$images = [];
		$image_ids = $this->getImageIDs();
		foreach ( $image_ids as $image_id ) {
			$image = $this->imageRepo->get( [ "*" ], [ "id" => $image_id ], "single" );
			if ( !is_null( $image ) ) {
				$images[] = $image;
			}
		}

		$this->images = $images;

		return $this;
	}

	public function replaceTags( $email_body )
	{
		foreach ( $videos as $video ) {
			$pattern = "/\[\*img" . $video->id . "\*\]/";
			preg_replace( $pattern );
		}
	}

	public function removeImageTagByImageID( $image_id )
	{
		$pattern = "/\[\*img" . $image_id . "\*\]/";
		$this->setEmailBody( preg_replace( $pattern, "", $this->email_body ) );
	}

	public function removeVideoTagByVideoID( $video_id )
	{
		$pattern = "/\[\*video" . $video_id . "\*\]/";
		$this->setEmailBody( preg_replace( $pattern, "", $this->email_body ) );
	}
}
