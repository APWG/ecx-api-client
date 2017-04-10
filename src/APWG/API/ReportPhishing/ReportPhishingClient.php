<?php
namespace APWG\API\ReportPhishing;

use APWG\API\AbstractClient;
use Psr\Http\Message\ResponseInterface;


/**
 * Class ReportPhishingClient
 * @package   APWG\API\ReportPhishing
 * @author    Andrew Breksa
 * @copyright Copyright (c) 2016. The Anti-Phishing Working Group
 */
class ReportPhishingClient extends AbstractClient {

	/**
	 * Searches the report_phishing module
	 *
	 * @param array $options an associative array of query parameters
	 * @return ResponseInterface
	 */
	public function search($options = []) {
		return $this->_call('get', 'report_phishing', [
			'query' => $options
		]);
	}


	/**
	 * Gets a specific email
	 *
	 * @param int $id the email id
	 * @param array $options an associative array of query parameters
	 * @return ResponseInterface
	 */
	public function get($id, $options = []) {
		return $this->_call('get', 'report_phishing/' . $id, [
			'query' => $options
		]);
	}

}