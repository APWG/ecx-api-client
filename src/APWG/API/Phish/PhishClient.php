<?php

namespace APWG\API\Phish;

use APWG\API\AbstractClient;
use Psr\Http\Message\ResponseInterface;

/**
 * Interact with the Phish (UBL) API
 *
 * Class PhishClient
 * @package APWG\API\Phish
 * @author Andrew Breksa <andrew@apwg.org>
 * @copyright Copyright (c) 2017 The Anti-Phishing Working Group
 */
class PhishClient extends AbstractClient {

	/**
	 * Searches the Phish module
	 *
	 * @param array $options an associative array of query parameters
	 *
	 * @return ResponseInterface
	 */
	public function search($options = []) {
		return $this->_call('get', 'phish', [
			'query' => $options,
		]);
	}


	/**
	 * Gets a specific phish
	 *
	 * @param int $id the phish id
	 * @param array $options an associative array of query parameters
	 *
	 * @return ResponseInterface
	 */
	public function get($id, $options = []) {
		return $this->_call('get', 'phish/' . $id, [
			'query' => $options,
		]);
	}

	/**
	 * Submits a new phish
	 *
	 * @param array $data an associative array of phish data
	 * @param array $options an associative array pf query parameters
	 *
	 * @return ResponseInterface
	 */
	public function create($data, $options = []) {
		return $this->_call('post', 'phish', [
			'json'  => $data,
			'query' => $options,
		]);
	}


	/**
	 * Marks a phish as inactive
	 *
	 * @deprecated
	 *
	 * @param int $id the phish id
	 *
	 * @return ResponseInterface
	 */
	public function inactive($id) {
		return $this->_call('delete', 'phish/' . $id);
	}

	/**
	 * Checks that a phish by that ID exists and returns a last-modified header
	 *
	 * @param int $id the phish id
	 *
	 * @return ResponseInterface
	 */
	public function head($id) {
		return $this->_call('head', 'phish/' . $id);
	}


	/**
	 * Updates a phish
	 *
	 * @param int $id the phish id
	 * @param  array $data
	 *
	 * @return ResponseInterface
	 */
	public function patch($id, $data, $options = []) {
		return $this->_call('patch', 'phish/' . $id, [
			'json'  => $data,
			'query' => $options,
		]);
	}


	/**
	 * Revives an inactive phish
	 *
	 * @deprecated
	 *
	 * @param int $id the phish id
	 * @param array $data
	 *
	 * @return ResponseInterface
	 */
	public function revive($id, $data) {
		return $this->_call('put', 'phish/' . $id, [
			'json' => $data,
		]);
	}

	/**
	 * Searches the UBL activity listing
	 *
	 * @param array $options an associative array of query parameters
	 *
	 * @return ResponseInterface
	 */
	public function searchActivity($options = []) {
		return $this->_call('get', 'phish/activity', [
			'query' => $options,
		]);
	}

	/**
	 * Get the UBL activity listings for a specific phish
	 *
	 * @param $id
	 * @param $options
	 *
	 * @return ResponseInterface
	 */
	public function activity($id, $options = []) {
		return $this->_call('get', 'phish/' . $id . '/activity', [
			'query' => $options,
		]);
	}

	/**
	 * Return a JSON schema for the phish module's GET:/phish endpoint parameters, useful for validating Alert queries
	 *
	 * @param int $id the phish id
	 * @param array $options an associative array of query parameters
	 *
	 * @return ResponseInterface
	 */
	public function getParamSchema($options = []) {
		return $this->_call('get', 'phish/param_schema', [
			'query' => $options,
		]);
	}
}