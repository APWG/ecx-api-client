<?php

namespace APWG\API\ReportPhishing;

use APWG\API\AbstractClient;
use Psr\Http\Message\ResponseInterface;


/**
 * Interact with the Report_Phishing API
 *
 * Class ReportPhishingClient
 * @package   APWG\API\ReportPhishing
 * @author Andrew Breksa <andrew@apwg.org>
 * @copyright Copyright (c) 2017 The Anti-Phishing Working Group
 */
class ReportPhishingClient extends AbstractClient {

	/**
	 * Searches the report_phishing module
	 *
	 * @param array $options an associative array of query parameters
	 *
	 * @return ResponseInterface
	 */
	public function search($options = []) {
		return $this->_call('get', 'report_phishing', [
			'query' => $options,
		]);
	}


	/**
	 * Gets a specific email
	 *
	 * @param int $id the email id
	 * @param array $options an associative array of query parameters
	 *
	 * @return ResponseInterface
	 */
	public function get($id, $options = []) {
		return $this->_call('get', 'report_phishing/' . $id, [
			'query' => $options,
		]);
	}

	/**
	 * Return a JSON schema for the report_phishing module's GET:/report_phishing endpoint parameters, useful for validating Alert queries
	 *
	 * @param int $id the phish id
	 * @param array $options an associative array of query parameters
	 *
	 * @return ResponseInterface
	 */
	public function getParamSchema($options = []) {
		return $this->_call('get', 'report_phishing/param_schema', [
			'query' => $options,
		]);
	}

}