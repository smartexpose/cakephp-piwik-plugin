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
			return $this->dispatchPiwikTrackerMethod($method, $params);
		}
		trigger_error(__d('cake_dev', 'Method %1$s::%2$s does not exist', get_class($this), $method), E_USER_WARNING);
	}

/**
 * Calls a method on PiwikTracker object with the given parameters. Provides an OO wrapper
 * for `call_user_func_array`
 *
 * @param string $method Name of the method to call
 * @param array $params Parameter list to use when calling $method
 * @return mixed Returns the result of the method call
 */
	public function dispatchPiwikTrackerMethod($method, $params = array()) {
		switch (count($params)) {
			case 0:
				return $this->PiwikTracker->{$method}();
			case 1:
				return $this->PiwikTracker->{$method}($params[0]);
			case 2:
				return $this->PiwikTracker->{$method}($params[0], $params[1]);
			case 3:
				return $this->PiwikTracker->{$method}($params[0], $params[1], $params[2]);
			case 4:
				return $this->PiwikTracker->{$method}($params[0], $params[1], $params[2], $params[3]);
			case 5:
				return $this->PiwikTracker->{$method}($params[0], $params[1], $params[2], $params[3], $params[4]);
			default:
				return call_user_func_array(array(&$this->PiwikTracker, $method), $params);
		}
	}

}
