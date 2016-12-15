<?php
App::uses('Component', 'Controller');
App::uses('Hash', 'Utility');

class PiwikComponent extends Component {

/**
 * Settings for this Component
 *
 * @var array
 */
	public $settings = array(
		'apiUrl' => '',
		'idSite' => 0,
	);

/**
 * Constructor
 *
 * @param ComponentCollection $collection A ComponentCollection this component can use to lazy load its components
 * @param array $settings Array of configuration settings.
 */
	public function __construct(ComponentCollection $collection, $settings = array()) {
		$this->settings = Hash::merge($this->settings, $settings);

		App::import('Vendor', 'Piwik.PiwikTracker/PiwikTracker');
		if (empty($this->PiwikTracker)) {
			$this->PiwikTracker = new PiwikTracker($this->settings['idSite'], $this->settings['apiUrl']);
		}
	}

/**
 * Provide non fatal errors on missing method calls.
 *
 * @param string $method Method to invoke
 * @param array $params Array of params for the method.
 * @return void
 */
	public function __call($method, $params) {
		if (method_exists($this->PiwikTracker, $method)) {
			return $this->dispatchMethod(array($this->PiwikTracker, $method), $params);
		}
		trigger_error(__d('cake_dev', 'Method %1$s::%2$s does not exist', get_class($this), $method), E_USER_WARNING);
	}

}
