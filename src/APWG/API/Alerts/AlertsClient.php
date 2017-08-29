<?php


namespace APWG\API\Alerts;


use APWG\API\AbstractClient;
use Psr\Http\Message\ResponseInterface;

/**
 * Interact with the Alert API
 *
 * Class AlertsClient
 * @package APWG\API\Alerts
 * @author Andrew Breksa <andrew@apwg.org>
 * @copyright Copyright (c) 2017 The Anti-Phishing Working Group
 */
class AlertsClient extends AbstractClient {

	/**
	 * Searches your Alerts
	 *
	 * @param array $options an associative array of query parameters
	 *
	 * @return ResponseInterface
	 */
	public function search($options = []) {
		return $this->_call('get', 'alerts', [
			'query' => $options,
		]);
	}

	/**
	 * Gets a specific Alert
	 *
	 * @param int $id the Alert id
	 * @param array $options an associative array of query parameters
	 *
	 * @return ResponseInterface
	 */
	public function get($id, $options = []) {
		return $this->_call('get', 'alerts/' . $id, [
			'query' => $options,
		]);
	}

	/**
	 * Creates a new Alert
	 *
	 * @param array $data an associative array of Alert data
	 * @param array $options an associative array pf query parameters
	 *
	 * @return ResponseInterface
	 */
	public function create($data, $options = []) {
		return $this->_call('post', 'alerts', [
			'json'  => $data,
			'query' => $options,
		]);
	}

	/**
	 * Updates an Alert to status: inactive
	 *
	 * @param int $id the Alert id
	 *
	 * @return ResponseInterface
	 */
	public function inactive($id, $options = []) {
		return $this->patch($id, [
			'status' => 'inactive',
		], $options);
	}

	/**
	 * Updates an Alert
	 *
	 * @param int $id the Alert id
	 * @param  array $data
	 *
	 * @return ResponseInterface
	 */
	public function patch($id, $data, $options = []) {
		return $this->_call('patch', 'alerts/' . $id, [
			'json'  => $data,
			'query' => $options,
		]);
	}

	/**
	 * Updates an Alert to status: active
	 *
	 * @param int $id the Alert id
	 *
	 * @return ResponseInterface
	 */
	public function active($id, $options = []) {
		return $this->patch($id, [
			'status' => 'active',
		], $options);
	}
}