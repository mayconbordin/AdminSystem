<?php

class Admin_Model_LoginAttempt_Entity extends Zf_Model_Entity
{
	protected $datetime;
	protected $ip;
	protected $success;
	protected $username;
	
	/**
	 * @return the $datetime
	 */
	public function getDatetime() {
		return $this->datetime;
	}

	/**
	 * @return the $ip
	 */
	public function getIp() {
		return $this->ip;
	}

	/**
	 * @return the $success
	 */
	public function getSuccess() {
		return $this->success;
	}

	/**
	 * @return the $username
	 */
	public function getUsername() {
		return $this->username;
	}

	/**
	 * @param $datetime the $datetime to set
	 */
	public function setDatetime($datetime) {
		$this->datetime = $datetime;
		return $this;
	}

	/**
	 * @param $ip the $ip to set
	 */
	public function setIp($ip) {
		$this->ip = $ip;
		return $this;
	}

	/**
	 * @param $success the $success to set
	 */
	public function setSuccess($success) {
		$this->success = $success;
		return $this;
	}

	/**
	 * @param $username the $username to set
	 */
	public function setUsername($username) {
		$this->username = $username;
		return $this;
	}
}
