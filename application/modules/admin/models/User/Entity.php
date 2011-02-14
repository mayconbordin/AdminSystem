<?php

class Admin_Model_User_Entity extends Zf_Model_Entity
{
	protected $id;
	protected $name;
	protected $email;
	protected $password;
	protected $challenge;
	protected $level;
	protected $lastActivity;
	
	/**
	 * @return the $id
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @return the $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @return the $email
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * @return the $password
	 */
	public function getPassword() {
		return $this->password;
	}

	/**
	 * @return the $challenge
	 */
	public function getChallenge() {
		return $this->challenge;
	}

	/**
	 * @return the $level
	 */
	public function getLevel() {
		return $this->level;
	}

	/**
	 * @return the $lastActivity
	 */
	public function getLastActivity() {
		return $this->lastActivity;
	}

	/**
	 * @param $id the $id to set
	 */
	public function setId($id) {
		$this->id = $id;
		return $this;
	}

	/**
	 * @param $name the $name to set
	 */
	public function setName($name) {
		$this->name = $name;
		return $this;
	}

	/**
	 * @param $email the $email to set
	 */
	public function setEmail($email) {
		$this->email = $email;
		return $this;
	}

	/**
	 * @param $password the $password to set
	 */
	public function setPassword($password) {
		$this->password = $password;
		return $this;
	}

	/**
	 * @param $challenge the $challenge to set
	 */
	public function setChallenge($challenge) {
		$this->challenge = $challenge;
		return $this;
	}

	/**
	 * @param $level the $level to set
	 */
	public function setLevel(Login_Model_UserLevel_Entity $level) {
		$this->level = $level;
		return $this;
	}

	/**
	 * @param $lastActivity the $lastActivity to set
	 */
	public function setLastActivity($lastActivity) {
		$this->lastActivity = $lastActivity;
		return $this;
	}
	
	public function __toArray() {
		$array = parent::__toArray();
		
		$array['level'] = $this->level->getLevel();
		
		return $array;
	}
}
