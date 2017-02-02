<?php
namespace APWG\API;

use APWG\API\ClientInterface as APIClientInterface;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * The abstract client interface implementation
 *
 * Class AbstractClient
 * @package   APWG\API
 * @author    Andrew Breksa
 * @copyright Copyright (c) 2016. The Anti-Phishing Working Group
 */
abstract class AbstractClient implements APIClientInterface {

	/**
	 * The HTTP Client (GuzzleHTTP)
	 *
	 * @var ClientInterface
	 */
	protected $client;

	/**
	 * The API Key
	 *
	 * @var string
	 */
	protected $apiKey;

	/**
	 * The options to be merged into every request
	 *
	 * @var array
	 */
	protected $globalOptions = [];

	/**
	 * The API base URI
	 *
	 * @var string
	 */
	protected $base_uri;

	/**
	 * The default GuzzleHTTP options
	 *
	 * @var array
	 */
	protected $guzzleOptions = [
		'timeout' => 5,
	];

	/**
	 * The request cache, the most recent request
	 *
	 * @var ResponseInterface
	 */
	protected $cache;

	/**
	 * Get the global options that are merged with every request
	 *
	 * @return array
	 */
	public function getGlobalOptions() {
		return $this->globalOptions;
	}

	/**
	 * Set the global options that are merged with every request
	 *
	 * @param array $globalOptions
	 *
	 * @return AbstractClient
	 */
	public function setGlobalOptions($globalOptions) {
		$this->globalOptions = $globalOptions;
		return $this;
	}

	/**
	 * AbstractAPI constructor.
	 *
	 * @param string $apiKey        access token
	 * @param string $base_uri      the base uri of the api
	 * @param array  $guzzleOptions guzzle http options, overrides defaults
	 */
	public function __construct($base_uri, $apiKey, $guzzleOptions = []) {
		$this->setBaseUri($base_uri);
		$this->setApiKey($apiKey);
		$this->setGuzzleOptions($guzzleOptions);
		$this->setClient(new Client(array_merge($this->getGuzzleOptions(), ['base_uri' => $this->getBaseUri()])));
	}

	/**
	 * Get the default GuzzleHTTP options
	 *
	 * @return array
	 */
	public function getGuzzleOptions() {
		return $this->guzzleOptions;
	}

	/**
	 * Set the default GuzzleHTTP options
	 *
	 * @param array $guzzleOptions
	 *
	 * @return AbstractClient
	 */
	public function setGuzzleOptions($guzzleOptions) {
		if (!empty($guzzleOptions)) {
			$this->guzzleOptions = array_replace($this->getGuzzleOptions(), $guzzleOptions);
		}
		return $this;
	}

	/**
	 * Get the API base URI
	 *
	 * @return string
	 */
	public function getBaseUri() {
		return $this->base_uri;
	}

	/**
	 * Set the base API URI
	 *
	 * @param string $base_uri
	 *
	 * @return AbstractClient
	 */
	public function setBaseUri($base_uri) {
		$this->base_uri = $base_uri;
		return $this;
	}

	/**
	 * Internal method to call the API
	 *
	 * @param       $method
	 * @param       $path
	 * @param array $options
	 *
	 * @return ResponseInterface
	 */
	public function _call($method, $path, $options = []) {
		$this->setCache($this->getClient()->request(
			$method,
			$path,
			array_merge_recursive(
				$options,
				[
					'headers' => [
						'Authorization' => $this->getApiKey(),
					]
				],
				(array_key_exists('headers', $options) || array_key_exists('multipart', $options)) ? [] : ['headers' => ['Content-Type' => 'application/json']],
				$this->getGlobalOptions()
			)
		));
		return $this->cache;
	}

	/**
	 * Get the HTTP Client
	 *
	 * @return ClientInterface
	 */
	public function getClient() {
		return $this->client;
	}

	/**
	 * Set the HTTP Client
	 *
	 * @param ClientInterface $client
	 *
	 * @return AbstractClient
	 */
	public function setClient($client) {
		$this->client = $client;
		return $this;
	}

	/**
	 * Return the API Key
	 *
	 * @return string
	 */
	public function getApiKey() {
		return $this->apiKey;
	}

	/**
	 * Set the API key
	 *
	 * @param string $apiKey
	 *
	 * @return AbstractClient
	 */
	public function setApiKey($apiKey) {
		$this->apiKey = $apiKey;
		return $this;
	}

	/**
	 * Get the most recent request
	 *
	 * @return ResponseInterface
	 */
	public function getCache() {
		return $this->cache;
	}

	/**
	 * Set the most recent request
	 *
	 * @param ResponseInterface $cache
	 */
	public function setCache($cache) {
		$this->cache = $cache;
	}

}