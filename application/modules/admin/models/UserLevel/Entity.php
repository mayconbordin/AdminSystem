<?php

class Admin_Model_UserLevel_Entity extends Zf_Model_Entity
{
	protected $level;
	protected $alias;
	
	/**
	 * @return the $level
	 */
	public function getLevel() {
		return $this->level;
	}

	/**
	 * @return the $alias
	 */
	public function getAlias() {
		return $this->alias;
	}

	/**
	 * @param $level the $level to set
	 */
	public function setLevel($level) {
		$this->level = $level;
		return $this;
	}

	/**
	 * @param $alias the $alias to set
	 */
	public function setAlias($alias) {
		$this->alias = $alias;
		return $this;
	}

}
