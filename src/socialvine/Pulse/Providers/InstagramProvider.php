<?php

namespace Socialvine\Pulse\Providers;
use GuzzleHttp\Client;

class InstagramProvider extends \Socialvine\Pulse\Providers\AbstractProvider {
	
	protected $config;

	function __construct($config) {
		$this->config = $config;

		$this->client = new Client(['base_uri' => 'https://api.instagram.com/']);
	}
	
	public function followers($id) {
		
		$response = $this->client->get('v1/users/'.$id, [
				'query' => [
						'access_token' => $this->config['access_token']
					]
			]);
		return json_decode($response->getBody())->data->counts->followed_by;
	}

	public function userId($username) {
		$response = $this->client->get('v1/users/search', [
				'query' => [
					'q' => $username,
					'access_token' => $this->config['access_token']
				]
			]);
		return json_decode($response->getBody());
	}

	public function search($params) {
		$response = $this->client->get('v1/tags/diwali/media/recent', [
				'query' => [
					'access_token' => $this->config['access_token']
				]
			]);
			echo ($response->getBody());
		// return json_decode($response->getBody())->data;
	}

	private function prepUrl($params) {
		$url = "v1/tags";
		$url .= $params['term'];
		$url .= "/media/recent";
	}

	public function posts($id) {
		$response = $this->client->get('v1/users/'.$id.'/media/recent', [
				'query' => [
					'access_token' => $this->config['access_token']
				],
			]);
		return json_decode($response->getBody());
	}

}