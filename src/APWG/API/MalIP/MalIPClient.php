<?php

namespace APWG\API\MalIP;

use APWG\API\AbstractClient;
use Psr\Http\Message\ResponseInterface;

/**
 * Interact with the Mal_IP API
 *
 * Class MalIPClient
 * @package APWG\API\MalIP
 * @author Andrew Breksa <andrew@apwg.org>
 * @copyright Copyright (c) 2017 The Anti-Phishing Working Group
 */
class MalIPClient extends AbstractClient {

	/**
	 * Searches the mal_ip module
	 *
	 * @param array $options an associative array of query parameters
	 *
	 * @return ResponseInterface
	 */
	public function search($options = []) {
		return $this->_call('get', 'mal_ip', [
			'query' => $options,
		]);
	}

	/**
	 * Gets a specific phish
	 *
	 * @param int $id the mal_ip id
	 * @param array $options an associative array of query parameters
	 *
	 * @return ResponseInterface
	 */
	public function get($id, $options = []) {
		return $this->_call('get', 'mal_ip/' . $id, [
			'query' => $options,
		]);
	}

	/**
	 * Checks that a mal_ip by that ID exists and returns a last-modified header
	 *
	 * @param int $id the mal_ip id
	 *
	 * @return ResponseInterface
	 */
	public function head($id) {
		return $this->_call('head', 'mal_ip/' . $id);
	}

	/**
	 * Submits a new mal_ip entry
	 *
	 * @param array $data an associative array of mal_ip data
	 * @param array $options an associative array of query parameters
	 *
	 * @return ResponseInterface
	 */
	public function create($data, $options = []) {
		return $this->_call('post', 'mal_ip', [
			'json'  => $data,
			'query' => $options,
		]);
	}

	/**
	 * Get a Last-Modified header with the timestamp of the last collaboration activity for a specific entity
	 *
	 * @param int $id
	 *
	 * @return ResponseInterface
	 */
	public function lastCollaboration($id) {
		return $this->_call('head', 'mal_ip/' . $id . '/collaborate', []);
	}

	/**
	 * Return a JSON schema for the mal_ip module's GET:/mal_ip endpoint parameters, useful for validating Alert queries
	 *
	 * @param int $id the phish id
	 * @param array $options an associative array of query parameters
	 *
	 * @return ResponseInterface
	 */
	public function getParamSchema($options = []) {
		return $this->_call('get', 'mal_ip/param_schema', [
			'query' => $options,
		]);
	}

}