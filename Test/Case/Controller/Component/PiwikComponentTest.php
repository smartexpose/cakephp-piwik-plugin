<?php
App::uses('ComponentCollection', 'Controller');
App::uses('Component', 'Controller');
App::uses('PiwikComponent', 'Piwik.Controller/Component');

/**
 * PiwikComponent Test Case
 */
class PiwikComponentTest extends CakeTestCase {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$Collection = new ComponentCollection();
		$this->Piwik = new PiwikComponent($Collection);
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Piwik);

		parent::tearDown();
	}

}
