<?php

namespace APWG\API\Groups;

use APWG\API\AbstractClient;
use GuzzleHttp\Psr7\Request;

/**
 * Interact with the Groups API
 *
 * Class GroupsClient
 * @package APWG\API\Groups
 * @author Andrew Breksa <andrew@apwg.org>
 * @copyright Copyright (c) 2017 The Anti-Phishing Working Group
 */
class GroupsClient extends AbstractClient {

	/**
	 * The group ID
	 *
	 * @var string
	 */
	private $group_id = NULL;

	/**
	 * Returns the YAML Swagger 2 specification for the API
	 *
	 * @param string|null $group_id
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	public function getSpec($group_id = NULL) {
		return $this->_call('get', $this->getGroupUrl($group_id) . '/spec');
	}

	/**
	 * Get the URL for a group
	 *
	 * @param null|string $group_id
	 *
	 * @return string
	 */
	public function getGroupUrl($group_id = NULL) {
		if(is_null($group_id)) {
			$group_id = $this->getGroupId();
		}
		if(is_null($group_id)) {
			throw  new \InvalidArgumentException('no group id provided via the method call and none set');
		}

		return 'groups/' . $group_id;
	}

	/**
	 * Get the stored group id
	 * @return string
	 */
	public function getGroupId() {
		return $this->group_id;
	}

	/**
	 * Set the stored group id, used as the default when none is provided to the class methods
	 *
	 * @param string $group_id
	 */
	public function setGroupId($group_id) {
		$this->group_id = $group_id;
	}

	/**
	 * Returns the JSON schema for a specific action, defaults to the full group threat model schema (GET)
	 *
	 * @param array $options
	 * @param string|null $action
	 * @param string|null $group_id
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	public function getSchema($options = [], $action = NULL, $group_id = NULL) {
		if(is_null($action)) {
			$action = 'get';
		}

		return $this->_call('get', $this->getGroupUrl($group_id) . '/schema/' . $action, [
			'query' => $options,
		]);
	}

	/**
	 * Return a JSON schema for the group's GET:/groups/<group_id> endpoint parameters, useful for validating Alert queries
	 *
	 * @param array $options
	 * @param null $group_id
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	public function getParamSchema($options = [], $group_id = NULL) {
		return $this->_call('get', $this->getGroupUrl($group_id) . '/param_schema', [
			'query' => $options,
		]);
	}

	/**
	 * Search the activity listing for the group's entities
	 *
	 * @param array $options
	 * @param null|string $group_id
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	public function activity($options = [], $group_id = NULL) {
		return $this->_call('get', $this->getGroupUrl($group_id) . '/activity', [
			'query' => $options,
		]);
	}

	/**
	 * Get header information for a specific entity
	 *
	 * @param int $entity_id
	 * @param null|string $group_id
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	public function assetHead($entity_id, $group_id = NULL) {
		return $this->_call('head', $this->getGroupUrl($group_id) . '/' . $entity_id);
	}

	/**
	 * Search the activity listing for a specific entity
	 *
	 * @param int $entity_id
	 * @param array $options
	 * @param null|string $group_id
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	public function assetActivity($entity_id, $options = [], $group_id = NULL) {
		return $this->_call('get', $this->getGroupUrl($group_id) . '/' . $entity_id . '/activity', [
			'query' => $options,
		]);
	}

	/**
	 * Edit a group entity
	 *
	 * @param int $entity_id
	 * @param array $data
	 * @param array $options
	 * @param null|string $group_id
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	public function patch($entity_id, $data = [], $options = [], $group_id = NULL) {
		return $this->_call('patch', $this->getGroupUrl($group_id) . '/' . $entity_id, [
			'json'  => $data,
			'query' => $options,
		]);
	}

	/**
	 * Get a specific entity
	 *
	 * @param int $entity_id
	 * @param array $options
	 * @param null|string $group_id
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	public function get($entity_id, $options = [], $group_id = NULL) {
		return $this->_call('get', $this->getGroupUrl($group_id) . '/' . $entity_id, [
			'query' => $options,
		]);
	}

	/**
	 * Search the group's entities
	 *
	 * @param array $options
	 * @param null|string $group_id
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	public function search($options = [], $group_id = NULL) {
		return $this->_call('get', $this->getGroupUrl($group_id), [
			'query' => $options,
		]);
	}

	/**
	 * Submit a new entity to this group
	 *
	 * @param array $data
	 * @param array $options
	 * @param null|string $group_id
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	public function create($data = [], $options = [], $group_id = NULL) {
		return $this->_call('post', $this->getGroupUrl($group_id), [
			'json'  => $data,
			'query' => $options,
		]);
	}

	/**
	 * @param int $entity_id
	 * @param string $file_path
	 * @param array $options
	 * @param null|string $group_id
	 * @param callable $progress_callback Callback to be executed on transfer progress, as per http://docs.guzzlephp.org/en/latest/request-options.html#progress
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	public function uploadFile($entity_id, $file_path, $options = [], $group_id = NULL, $progress_callback = NULL) {
		return $this->_call('post', $this->getGroupUrl($group_id) . '/' . $entity_id . '/files',
			array_merge(
				[
					'query'     => $options,
					'multipart' => [
						[
							'name'     => 'file',
							'contents' => fopen($file_path, 'r'),
							'filename' => pathinfo($file_path, PATHINFO_BASENAME),
						],
					],
				],
				is_null($progress_callback) ? [] : ['progress' => $progress_callback]
			));
	}

	/**
	 * @param int $entity_id
	 * @param string $file_hash
	 * @param array $options
	 * @param null $group_id
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	public function getFile($entity_id, $file_hash, $options = [], $group_id = NULL) {
		return $this->_call('get', $this->getGroupUrl($group_id) . '/' . $entity_id . '/files/' . $file_hash,
			[
				'query' => $options,
			]
		);
	}

	/**
	 * @param int $entity_id
	 * @param string $file_hash
	 * @param array $options
	 * @param null $group_id
	 * @param callable $progress_callback Callback to be executed on transfer progress, as per http://docs.guzzlephp.org/en/latest/request-options.html#progress
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	public function downloadFile($entity_id, $file_hash, $options = [], $group_id = NULL, $progress_callback = NULL) {
		$response = $this->_call('get', $this->getGroupUrl($group_id) . '/' . $entity_id . '/files/' . $file_hash,
			[
				'query' => $options,
			]
		);
		$request  = new Request('GET',
			json_decode($response->getBody()->getContents(), TRUE)['_links']['download']['href']);

		return $this->getClient()->send($request,
			is_null($progress_callback) ? [] : ['progress' => $progress_callback]);
	}

	/**
	 * @param int $entity_id
	 * @param array $options
	 * @param null|int $group_id
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	public function getFiles($entity_id, $options = [], $group_id = NULL) {
		return $this->_call('get', $this->getGroupUrl($group_id) . '/' . $entity_id . '/files',
			[
				'query' => $options,
			]
		);
	}

	/**
	 * @param int $entity_id
	 * @param array $options
	 * @param null|int $group_id
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	public function getNotes($entity_id, $options = [], $group_id = NULL) {
		return $this->_call('get', $this->getGroupUrl($group_id) . '/' . $entity_id . '/notes',
			[
				'query' => $options,
			]
		);
	}

	/**
	 * @param  int $entity_id
	 * @param  string $note
	 * @param null|int $group_id
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	public function addNote($entity_id, $note, $group_id = NULL) {
		return $this->_call('post', $this->getGroupUrl($group_id) . '/' . $entity_id . '/notes', [
			'json' => ['note' => $note],
		]);
	}
}