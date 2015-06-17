<?php

App::uses('FormHelper', 'View/Helper');
App::uses('Set', 'Utility');

/**
 *
 * Helper CakePHP pour créer des éléments formulaires du Bootstrap Twitter version 3
 * @author Web&Cow - France
 *
 */
class BsFormHelper extends FormHelper {

/**
 * Check which addon is loaded and which is not
 *
 * @var array
 */
	protected $_loaded = array(
		'chosen' => false,
		'lengthDetector' => false,
	);

/**
 * BsForm uses the BsHelper so it can use some feature of it
 * BsForm uses the FormHelper
 *
 * @var array
 */
	public $helpers = array('Bs', 'Html', 'Js');

/**
 * The name of the helper
 *
 * @var string
 */
	public $name = 'BsForm';

/**
 * Right settings to have 2 columns (label and inputs) with an horizontal form
 * Default value is :  3
 *
 * @var int
 */
	private $__left = 3;

/**
 * Left settings to have 2 columns (label and inputs) with an horizontal form
 * Default value is :  9
 *
 * @var int
 */
	private $__right = 9;

/**
 * Device settings (xs, sm, md, lg)
 * Default value is :  md
 *
 * @var string
 */
	private $__device = 'md';

/**
 * Defines the type of form being created, horizontal form or inline form. Set by BsFormHelper::create()
 *
 * @var string
 */
	protected $_typeForm = 'horizontal';

/**
 * Defines the model of form being created. Set by BsFormHelper::create()
 *
 * @var string
 */
	protected $_modelForm = null;

/**
 * Defines the action of form being created. Set by BsFormHelper::create()
 *
 * @var string
 */
	protected $_actionForm = null;

	///////////////////
	//	A COMMENTER	 //
	///////////////////

/**
 * Return the current value of $_left
 *
 * @return int
 */
	public function getLeft() {
		return $this->__left;
	}

/**
 * Set the value of $left
 *
 * @param int $val Left value
 * @return void
 */
	public function setLeft($val) {
		$this->__left = $val;
	}

/**
 * Return the current value of $_right
 *
 * @return int
 */
	public function getRight() {
		return $this->__right;
	}

/**
 * Set the value of $right
 *
 * @param int $val Right value
 * @return void
 */
	public function setRight($val) {
		$this->__right = $val;
	}

/**
 * Return the current value of $_typeForm
 *
 * @return string
 */
	protected function _getFormType() {
		return $this->_typeForm;
	}

/**
 * Set the value of $_typeForm
 *
 * @param string $val Type of the form
 * @return void
 */
	public function setFormType($val) {
		$this->_typeForm = $val;
	}

/**
 * Return the current value of $_modelForm
 *
 * @return string
 */
	protected function _getModelForm() {
		return $this->_modelForm;
	}

/**
 * Set the value of $_typeForm
 *
 * @param string $val Model of the form
 * @return void
 */
	protected function _setModelForm($val) {
		$this->_modelForm = $val;
	}

/**
 * Return the current value of $_actionForm
 *
 * @return string
 */
	protected function _getActionForm() {
		return $this->_actionForm;
	}

/**
 * Set the value of $_actionForm
 *
 * @param string $val Action of the form
 * @return void
 */
	protected function _setActionForm($val) {
		$this->_actionForm = $val;
	}

/**
 * Set the value of $__device
 *
 * @param string $val New device
 * @return void
 */
	public function setDevice($val) {
		$this->__device = $val;
	}

/**
 * Return the correct class for the left column of the field
 *
 * @return string
 */
	private function __leftClass() {
		if ($this->_getFormType() == 'horizontal') {
			return 'control-label col-' . $this->__device . '-' . $this->__left;
		}
		if ($this->_getFormType() == 'inline') {
			return 'sr-only';
		}
		return 'control-label';
	}

/**
 * Return the correct class for the right column of the field
 *
 * @param bool $label If the field have a label
 * @return string
 */
	private function __rightClass($label = false) {
		if ($this->_getFormType() == 'horizontal') {
			return (!empty($label)) ? 'col-' . $this->__device . '-' . $this->__right : 'col-' . $this->__device . '-' . $this->__right . ' col-' . $this->__device . '-offset-' . $this->__left;
		}
		return '';
	}

/**
 * Returns an HTML FORM element.
 *
 * Extends of FormHelper::create() so get same options and params
 *
 * Initialize the value of $_typeForm, $_modelForm and give attribute 'role' to the form')`
 *
 * @param mixed $model The model name for which the form is being defined.
 *   If an array is passed and $options argument is empty, the array will be used as options.
 *   If `false` no model is used.
 * @param array $options An array of html attributes and options.
 * @return string An formatted opening FORM tag.
 */
	public function create($model = null, $options = array()) {
		if (!isset($options['role'])) {
			$options['role'] = 'form';
		}

		if (isset($options['class'])) {
			if (is_integer(strpos($options['class'], 'form-horizontal'))) {
				$this->setFormType('horizontal');
			} elseif (is_integer(strpos($options['class'], 'form-inline'))) {
				$this->setFormType('inline');
			} else {
				$this->setFormType('basic');
			}
		} else {
			$options['class'] = 'form-horizontal';
			$this->setFormType('horizontal');
		}

		$this->_setModelForm($model);

		if (isset($options['action'])) {
			$this->_setActionForm($options['action']);
		}

		return parent::create($model, $options);
	}

	/*--------------------------------*
	 *						          *
	 *			ERROR HANDLING        *
	 *					              *
	 *--------------------------------*/

/**
 * Change options if there are errors for the field
 *
 * @param string $fieldName Name of the field
 * @param array  $options   Options for the input
 * @return array
 */
	private function __errorBootstrap($fieldName, $options) {
		if (!$this->isFieldError($fieldName)) {
			return $options;
		}

		if (isset($options['errorBootstrap']) && false === $options['errorBootstrap']) {
			unset($options['errorBootstrap']);
			return $options;
		}

		$options['state'] = 'error';
		$options['help'] = '';
		$errors = $this->tagIsInvalid();

		foreach ($errors as $error) {
			$options['help'] .= $error . '<br />';
		}

		unset($options['errorBootstrap']);

		return $options;
	}

	/*------------------------*
	 *					      *
	 *			FIELDS        *
	 *					      *
	 *------------------------*/

/**
 * Generates a form input element complete with label and wrapper div
 *
 * Extends of FormHelper::input() so get same options and params
 *
 * ### New Options
 *
 * - `state` - Change the state of the input to 'error', 'warning' or 'success'
 * - `help` - Add a message under the input to give more informations
 *
 * ### Options by default for Twitter Bootstrap v3
 *
 * - 'before' - Add a 'form-group' div
 * - 'between' - Open the right column of the form
 * - 'after' - Close div tags
 * - 'div' - Set to 'false'
 * - 'class' - Add 'form-control'
 * - 'label' - Add a 'control-label' class and if the form is horizontal, put the label into the left column of it
 *
 * ### Options can be extends with no conflicts when the input is being created
 *
 * - 'class'
 * - 'label' - string and array
 *
 * @param string $fieldName This should be "Modelname.fieldname"
 * @param array $options Each type of input takes different options.
 * @return string Completed form widget.
 */
	public function input($fieldName, $options = array()) {
		$labelExist = (isset($options['label']) && false === $options['label']) ? false : true;

		$basicOptions = array(
			'before' => '<div class="form-group',
			'between' => $this->__buildInputBetween($labelExist),
			'after' => $this->__buildInputAfter($labelExist),
			'div' => false,
		);
		$bootstrapOptions = array('state', 'help', 'feedback');

		$options = $this->__errorBootstrapInput($fieldName, $options);
		$optionsDate = $this->__inputDate($basicOptions, $options);
		$basicOptions = $optionsDate['basic'];
		$options = $optionsDate['options'];

		foreach ($bootstrapOptions as $opt) {
			if (isset($options[$opt])) {
				$name = '__addInput' . $opt;
				$basicOptions = $this->$name($basicOptions, $options[$opt]);
				unset($options[$opt]);
			}
		}

		$basicOptions['before'] .= '">';

		if ($labelExist) {
			$label = $this->__addInputLabel($basicOptions, $options);
			$basicOptions = $label['basic'];
			$options = $label['options'];
		}

		if (isset($options['_isInputGroup'])) {
			$basicOptions = $this->__addInputGroup($basicOptions, $options);
			unset($options['_isInputGroup']);
		}

		$options = Hash::merge($basicOptions, $options);
		if (isset($options['data-mask'])) {
			if (!$this->Bs->loaded('jasny')) {
				echo $this->Bs->loadCSS('BsHelpers.jasny-bootstrap');
				echo $this->Bs->loadJS('BsHelpers.jasny-bootstrap');
				$this->Bs->load('jasny', true);
			}
		}
		if (!isset($options['type']) || strtolower($options['type']) != 'file') {
			$options['class'] = (isset($options['class'])) ? 'form-control ' . $options['class'] : 'form-control';
		}

		// ----- Length Detector ----- \\
		if (isset($options['length-detector-option']) || (isset($options['class']) && 'length-detector' === $options['class'])) {

			$jsOptions = '';
			$ldClass = 'defaults';
			if (isset($options['length-detector-option'])) {
				if (isset($options['length-detector-option']['class'])) {
					$ldClass = $options['length-detector-option']['class'];
					unset($options['length-detector-option']['class']);
				}
				// Length detector attribute encoded to pass it to JS
				$jsOptions = json_encode($options['length-detector-option']);
			}

			// Load JS
			if (!$this->_loaded['lengthDetector']) {
				$this->Bs->loadJS($this->Bs->lengthDetectorJsPath);
				$this->Bs->loadJS($this->Bs->lengthDetectorConfigJsPath);
				$this->_loaded['lengthDetector'] = true;
			}
			// JS send to the page
			$this->Bs->loadJS('$(document).ready(function(){$("[name*=' . $fieldName . '\].length-detector").attr("data-length-detector-class", "' . $ldClass . '").lengthDetector(' . $jsOptions . ');});', true, array('block' => 'scriptBottom'));
			unset($options['length-detector-option']);
		}
		return parent::input($fieldName, $options);
	}

/**
 * Build the 'between' option for the input
 *
 * @param bool $labelExist If the label exist
 * @return string
 */
	private function __buildInputBetween($labelExist) {
		return ($this->_getFormType() == 'horizontal') ? '<div class="' . $this->__rightClass($labelExist) . '">' : '';
	}

/**
 * Build the 'after' option for the input
 *
 * @param bool $labelExist If the label exist
 * @return string
 */
	private function __buildInputAfter($labelExist) {
		return ($this->_getFormType() == 'horizontal') ? '</div></div>' : '</div>';
	}

/**
 * Change input options if there are errors for the field
 *
 * @param string $fieldName Name of the field
 * @param array  $options   Options for the input
 * @return array
 */
	private function __errorBootstrapInput($fieldName, $options) {
		if (!$this->isFieldError($fieldName)) {
			return $options;
		}

		$options = $this->__errorBootstrap($fieldName, $options);

		$options['feedback'] = true;
		$options['errorMessage'] = false;

		return $options;
	}

/**
 * Change input options if the type of the input is date or datetime
 *
 * @param array $basicOptions Options by default for the input
 * @param array  $options   Options for the input
 * @return array
 */
	private function __inputDate($basicOptions, $options) {
		$inputsDate = array('date', 'datetime');

		if (isset($options['type']) && in_array($options['type'], $inputsDate)) {
			$options['class'] = (isset($options['class'])) ? 'input-date ' . $options['class'] : 'input-date';
		}

		if ($this->_getFormType() == 'basic') {
			$basicOptions['between'] = '<div>';
			$basicOptions['after'] = '</div></div>';
		}

		return array(
			'basic' => $basicOptions,
			'options' => $options,
		);
	}

/**
 * Change the state of the input (success, error, warning)
 *
 * @param array $basicOptions Options by default for the input
 * @param string $value        State
 * @return array
 */
	private function __addInputstate($basicOptions, $value) {
		$basicOptions['before'] .= ' has-' . $value;

		return $basicOptions;
	}

/**
 * Create a bootstrap help text for the input
 *
 * @param array $basicOptions Options by default for the input
 * @param string $value       Text
 * @return array
 */
	private function __addInputhelp($basicOptions, $value) {
		$basicOptions['after'] = '<span class="help-block">' . $value . '</span>' . $basicOptions['after'];

		return $basicOptions;
	}

/**
 * Add a 'feedback' bootstrap for the input (color + icon)
 *
 * @param array $basicOptions Options by default for the input
 * @param string $value     Type of the feedback
 * @return array
 */
	private function __addInputfeedback($basicOptions, $value) {
		$basicOptions['before'] .= ' has-feedback';

		$states = array(
			'success' => array(
				'text' => '(success)',
				'icon' => 'ok',
			),
			'warning' => array(
				'text' => '(warning)',
				'icon' => 'warning-sign',
			),
			'error' => array(
				'text' => '(error)',
				'icon' => 'remove',
			),
		);

		foreach ($states as $state => $stateOptions) {
			if (strpos($basicOptions['before'], 'has-' . $state)) {
				$basicOptions['after'] = '<span class="glyphicon glyphicon-' . $stateOptions['icon'] . ' form-control-feedback" aria-hidden="true"></span>
										<span class="sr-only">' . $stateOptions['text'] . '</span>' .
				$basicOptions['after'];
				break;
			}
		}

		return $basicOptions;
	}

/**
 * Define a label for the input
 *
 * @param array $basicOptions Options by default for the input
 * @param array  $options     Options for the input
 * @return array
 */
	private function __addInputLabel($basicOptions, $options) {
		if (isset($options['label'])) {
			if (!is_array($options['label'])) {
				$basicOptions['label']['text'] = $options['label'];
				$basicOptions['label']['class'] = $this->__leftClass();
			} else {
				if (isset($options['label']['text'])) {
					$basicOptions['label']['text'] = $options['label']['text'];
				}
				if (isset($options['label']['class'])) {
					$basicOptions['label']['class'] = $this->__leftClass() . ' ' . $options['label']['class'];
				} else {
					$basicOptions['label']['class'] = $this->__leftClass();
				}
			}
			unset($options['label']);

			return array(
				'basic' => $basicOptions,
				'options' => $options,
			);
		}

		$basicOptions['label']['class'] = $this->__leftClass();

		return array(
			'basic' => $basicOptions,
			'options' => $options,
		);
	}

/**
 * Special options for the input-group
 *
 * @param array $basicOptions Options by default for the input
 * @param array $options      Options for the input
 * @return array
 */
	private function __addInputGroup($basicOptions, $options) {
		$basicOptions['between'] .= '<div class="input-group">' . $options['_isInputGroup']['between'];
		$basicOptions['after'] = $options['_isInputGroup']['after'] . '</div>' . $basicOptions['after'];

		return $basicOptions;
	}

/**
 * Generate a form input element with an addon or button on his side.
 *
 *  ### Addon Options
 *
 * - 'content' - The addon content.
 * - 'side'    - Which side the addon will be. Be default 'left'.
 * - 'class'   - Add HTML class attribute.
 * - 'type'    - Change the type of the addon. Values : 'button', 'submit', 'image'.
 * - 'state'   - Change bootstrap button state. Values : 'default', 'primary', 'secondary', 'warning', 'danger'.
 * - 'src'	   - URL of the image, if 'type' = 'image'.
 *
 * @param string $fieldName    Extends of BsFormHelper::input()
 * @param array  $addonOptions Array of options, see above for more informations
 * @param mixed  $options      Extends of BsFormHelper::input() so get same options
 *
 * @return string Input-group de Bootstrap
 */
	public function inputGroup($fieldName, $addonOptions, $options = array()) {
		$options['_isInputGroup'] = array(
			'between' => '',
			'after' => '',
		);

		// Check if the addon is on the right
		if (isset($addonOptions['side']) && 'right' == $addonOptions['side']) {
			$options['_isInputGroup']['after'] = $this->__createAddon($addonOptions);
		} else {
			$options['_isInputGroup']['between'] = $this->__createAddon($addonOptions);
		}

		return $this->input($fieldName, $options);
	}

/**
 * Generate a span element for BsFormHelper::inputGroup() with his content.
 *
 * @param string/array $options Array of options
 *
 * @return string HTML <span> element
 */
	private function __createAddon($options) {
		if (is_array($options)) {

			// Check if the span content is a button
			if (isset($options['type'])) {

				$buttonOptions = array();

				if (isset($options['state'])) {
					$state = 'btn btn-' . $options['state'];
				} else {
					$state = 'btn btn-default';
				}

				$out = '<span class="input-group-btn">';

				if (isset($options['class'])) {
					$options['class'] .= ' ' . $state;
				} else {
					$options['class'] = $state;
				}

				$buttonOptions['div'] = false;
				$buttonOptions['escape'] = false;
				$buttonOptions['type'] = $options['type'];
				$buttonOptions['class'] = $options['class'];
				if ($options['type'] == 'image') {
					$buttonOptions['src'] = $options['src'];
					$buttonOptions['type'] = 'image';
					$buttonOptions['label'] = false;
					$out .= parent::input($options['content'], $buttonOptions);
				} else {
					$out .= parent::button($options['content'], $buttonOptions);
				}

				$out .= '</span>';

			} else {

				if (isset($options['class'])) {
					$options['class'] .= ' input-group-addon';
				} else {
					$options['class'] = 'input-group-addon';
				}

				$out = '<span class="' . $options['class'] . '">' . $options['content'] . '</span>';
			}
		} else {
			$out = '<span class="input-group-addon">' . $options . '</span>';
		}

		return $out;
	}

/**
 * Replace a classic input with a CkEditor
 *
 * $ckEditorLoad must be set to true in the BsHelper so this feature can work
 *
 * @param string $fieldName Name of a field, like this "Modelname.fieldname"
 * @param array $options Each type of input takes different options.
 * @return string An HTML text with a line of Javascript to launch CKEDITOR Script
 */
	public function ckEditor($fieldName, $options = array()) {
		$options['type'] = 'textarea';

		$out = $this->input($fieldName, $options);

		// If there is a point in the fieldName
		if (strpos($fieldName, '.') !== false) {
			$nameForReplace = Inflector::camelize($fieldName);
		} else {
			$nameForReplace = $this->_modelForm . Inflector::camelize($fieldName);
		}

		// Create the line of JS
		$out .= '<script>';
		$out .= 'CKEDITOR.replace("' . $nameForReplace . '");';
		$out .= '</script>';
		return $out;
	}

/**
 * Creates a checkbox input widget.
 *
 * Extends of FormHelper::checkbox() so get same options and params
 *
 * Prefer use this function and not BsFormHelper::input() to create checkbox - better results and automatically adapted to Twitter Bootstrap v3
 *
 * ### New Options:
 *
 * - `inline` - choose if you want inline checkbox - 'false' by default, can take 2 values : 'inline' or 'true'
 * - `help` - Add a message under the checkbox to give more informations
 *			  Use this option in an array with the label
 *			  Example : input('foo', array(
 *											'label' => 'name',
 *											'help' => 'informations'
 *										)
 *							);
 *
 * ### Options by default for Twitter Bootstrap v3
 *
 * - 'div' - Set to 'false'
 * - 'label' - Set to 'false'
 * - 'label' - Add a 'control-label' class and if the form is horizontal, put the label into the left column of it
 *
 * ### Options can be extends with no conflicts when the input is being created
 *
 * - 'class'
 * - 'label' - string and array
 *
 * ### In case of multiple checkboxes -> use the Bs3FormHelper::select()
 *
 * Some options are added
 * - 'help' - can be for each, always with an array in parameter
 * - 'hiddenField' - 'false' by default
 *
 * @param string $fieldName Name of a field, like this "Modelname.fieldname"
 * @param array $options Array of HTML attributes.
 *
 * @return string An HTML text input element.
 */
	public function checkbox($fieldName, $options = array()) {
		$basicOptions = array(
			'help' => false,
			'state' => false,
			'label' => Inflector::camelize($fieldName),
			'label-class' => '',
		);

		$options = $this->__errorBootstrap($fieldName, $options);

		foreach ($basicOptions as $opt => $valueOpt) {
			if (isset($options[$opt])) {
				$basicOptions[$opt] = $options[$opt];
				unset($options[$opt]);
			}
		}

		$checkbox = parent::checkbox($fieldName, $options);
		$checkbox .= ($basicOptions['label'] !== false) ? ' ' . $basicOptions['label'] : '';
		$checkbox .= ($basicOptions['help']) ? '<span class="help-block">' . $basicOptions['help'] . '</span>' : '';

		$options['type'] = 'checkbox';
		$label = array(
			'text' => $checkbox,
		);
		if (!empty($basicOptions['label-class'])) {
			$label['class'] = $basicOptions['label-class'];
		}

		return $this->__buildCheckboxBefore($basicOptions['state']) . $this->_inputLabel($fieldName, $label, $options) . $this->__buildCheckboxAfter($basicOptions['state']);
	}

/**
 * Build the html before the checkbox
 *
 * @param string $validationState State of the checkbox
 * @return string
 */
	private function __buildCheckboxBefore($validationState) {
		$out = '';

		if ($this->_getFormType() == 'horizontal') {
			$out .= '<div class="form-group">' .
			'<div class="' . $this->__rightClass(false) . '">';
		}

		if ($validationState) {
			$out .= '<div class="has-' . $validationState . '">';
		}

		return $out .= '<div class="checkbox">';
	}

/**
 * Build the html after the checkbox
 *
 * @param string $validationState State of the checkbox
 * @return string
 */
	private function __buildCheckboxAfter($validationState) {
		$out = '</div>';

		if ($validationState) {
			$out .= '</div>';
		}

		if ($this->_getFormType() == 'horizontal') {
			$out .= '</div>' . '</div>';
		}

		return $out;
	}

/**
 * Returns a formatted SELECT element.
 *
 * Extends of FormHelper::select() so get same attributes and params
 *
 * ### New Attributes:
 *
 * - `inline` - Only when attribute [multiple] is checkbox. Align all the checkboxes
 * - `help` - Add a message under the select element to give more informations
 * - 'label' - Add a label to the select element
 *
 * @param string $fieldName Name attribute of the SELECT
 * @param array $options Array of the OPTION elements (as 'value'=>'Text' pairs or as array('label' => 'text', 'help' => 'informations') in case of multiple checkbox) to be used in the
 *	SELECT element
 * @param array $attributes The HTML attributes of the select element.
 * @return string Formatted SELECT element
 */
	public function select($fieldName, $options = array(), $attributes = array()) {
		$out = '';
		$isDate = false;

		$inline = (isset($attributes['inline']) && ('inline' == $attributes['inline'] || true == $attributes['inline'])) ? true : false;

		// MULTIPLE CHECKBOX
		if ((isset($attributes['multiple']) && 'checkbox' != $attributes['multiple']) || !isset($attributes['multiple'])) {
			if (!isset($attributes['class'])) {
				$attributes['class'] = 'form-control';
			} else {
				$isDate = (strpos($attributes['class'], 'input-date') !== false) ? true : false;

				if (!$isDate) {
					$attributes['class'] = 'form-control ' . $attributes['class'];
				}
			}
		} else {
			//----- [checkobx simple] attribute for checkbox
			if (!isset($attributes['class'])) {
				$attributes['class'] = 'checkbox';
			} else {
				$attributes['class'] = 'checkbox ' . $attributes['class'];
			}
		}

		//----- [empty] attribute
		if (!isset($attributes['empty'])) {
			$attributes['empty'] = false;
		}

		$attributes = $this->__errorBootstrap($fieldName, $attributes);

		$attributesForSelect = $attributes;
		// Clean
		unset($attributesForSelect['state']);
		unset($attributesForSelect['help']);
		unset($attributesForSelect['label']);

		$select = parent::select($fieldName, $options, $attributesForSelect);

		if ($isDate) {
			return $select;
		}

		$out .= $this->__buildSelectBefore($fieldName, $attributes);
		$out .= $select;
		$out .= $this->__buildSelectAfter($attributes);

		if ((isset($attributes['multiple']) && 'checkbox' == $attributes['multiple'])) {

			$regex = '/(<label for=.*?>)/';
			if (preg_match_all($regex, $out, $labels)) {

				foreach ($labels[0] as $label) {

					$r1 = '/(<label.*.for="?)/';
					$r2 = '/(".*>)/';
					$field = preg_replace($r1, '', $label);
					$field = preg_replace($r2, '', $field);

					if ($inline) {
						$r3 = '/(class=".*?)(.*")/';
						if (preg_match($r3, $label, $labelClass)) {
							$label = preg_replace($r3, $labelClass[1] . 'checkbox-inline ' . $attributes['class'] . ' ' . $labelClass[2], $label);
						} else {
							$r4 = '/(<label for="' . $field . '".*)(.*>)/';
							$label = preg_replace($r4, '$1' . ' class="checkbox-inline" ' . '$2', $label);
						}

						$out = preg_replace('/(<div class="' . $attributes['class'] . '">)/', '', $out);
						$out = preg_replace('/(<\/label><\/div>)/', '</label>', $out);
					}

					$out = preg_replace(
						'/(<input type="checkbox".*)(.*id="' . $field . '".*?\/>)/',
						$label . '$1' . '$2',
						$out
					);
					$out = preg_replace('/(<input type="checkbox".*)(.*id="' . $field . '".*?\/>)(<label for=.*?>)/', '$1' . '$2', $out);
				}
			}
		}

		return $out;
	}

/**
 * Build the html before the select
 *
 * @param string $fieldName Name of the field
 * @param array $attributes Attributes of the select
 * @return string
 */
	private function __buildSelectBefore($fieldName, $attributes) {
		$out = '<div class="form-group">';
		$labelExist = false;

		//----- [label] attribute
		if (isset($attributes['label'])) {
			$labelExist = true;
			$attributes['type'] = 'text';
			$out .= $this->_inputLabel($fieldName, array('text' => $attributes['label'], 'class' => $this->__leftClass()), $attributes);
		}

		$out .= '<div class="' . $this->__rightClass($labelExist) . '">';

		if (isset($attributes['state'])) {
			$out .= '<div class="has-' . $attributes['state'] . '">';
		}

		return $out;
	}

/**
 * Build the html after the select
 *
 * @param array $attributes Attributes of the select
 * @return string
 */
	private function __buildSelectAfter($attributes) {
		$out = '';
		//----- [help] attribute
		if (isset($attributes['help'])) {
			$out .= '<span class="help-block">' . $attributes['help'] . '</span>';
		}

		if (isset($attributes['state'])) {
			$out .= '</div>';
		}

		return $out .= '</div></div>';
	}

/**
 * Creates a set of radio widgets.
 *
 * ### Attributes:
 *
 * - `label` - Create a label element for the radio buttons in the left column
 * - `value` - indicate a value that is should be checked
 * - `disabled` - Set to `true` or `disabled` to disable all the radio buttons.
 * - `help` - Add a message under the radio buttons to give more informations
 * - `inline` - Align all the radio buttons
 *
 * @param string $fieldName Name of a field, like this "Modelname.fieldname"
 * @param array $options Radio button options array (as 'value'=>'Text' pairs or as array('label' => 'text', 'help' => 'informations')
 * @param array $attributes Array of HTML attributes, and special attributes above.
 * @return string Completed radio widget set.
 */
	public function radio($fieldName, $options = array(), $attributes = array()) {
		$out = '';
		$inline = ((isset($attributes['inline']) && true === $attributes['inline'])) ? true : false;
		unset($attributes['inline']);
		$defaultAttributes = array(
			'legend' => false,
			'label' => false,
		);
		$defaultAttributes['separator'] = ($inline) ? '</label><label class="radio-inline">' : '</label></div><div class="radio"><label>';

		$attributes = $this->__errorBootstrap($fieldName, $attributes);

		$attributes = Hash::merge($defaultAttributes, $attributes);
		$attributesForBefore = $attributes;
		unset($attributes['state']);
		unset($attributes['help']);
		$attributes['label'] = false;

		$radio = parent::radio($fieldName, $options, $attributes);

		return $this->__buildRadioBefore($fieldName, $attributesForBefore, $inline) . $radio . $this->__buildRadioAfter($inline, $attributesForBefore);
	}

/**
 * Build the html before the radio
 *
 * @param string $fieldName Name of the field
 * @param array $attributes Attributes of the select
 * @param bool $inline      If radio buttons are inline
 * @return string
 */
	private function __buildRadioBefore($fieldName, $attributes, $inline) {
		$out = '';

		if ($this->_getFormType() == 'horizontal') {
			$out .= '<div class="form-group">';

			if ($attributes['label']) {
				$attributes['type'] = 'radio';

				$out .= $this->_inputLabel($fieldName, array('text' => $attributes['label'], 'class' => $this->__leftClass()), $attributes);
				$out .= '<div class="' . $this->__rightClass(true) . '">';
			} else {
				$out .= '<div class="' . $this->__rightClass(false) . '">';
			}
		}

		if (isset($attributes['state'])) {
			$out .= '<div class="has-' . $attributes['state'] . '">';
		}

		$out .= '<div class="radio">';
		$out .= ($inline) ? '<label class="radio-inline">' : '<label>';

		return $out;
	}

/**
 * Build the html after the radio
 *
 * @param bool $inline      If radio buttons are inline
 * @param array $attributes Attributes of the select
 * @return string
 */
	private function __buildRadioAfter($inline, $attributes) {
		$out = '</label>';

		//----- [help] attribute
		if (isset($attributes['help'])) {
			$out .= '<span class="help-block">' . $attributes['help'] . '</span>';
		}

		if (isset($attributes['state'])) {
			$out .= '</div>';
		}

		if ($this->_getFormType() == 'horizontal') {
			$out .= '</div></div>';
		}

		$out .= '</div>';

		return $out;
	}

/**
 * Creates a submit button element.
 *
 * Extends of FormHelper::submit() so get same options and params
 *
 * ### Options by default for Twitter Bootstrap v3
 *
 * - `div` - Set to 'false'
 * - 'label' - Set to 'false'
 * - 'class' - Set into a green button instead of a default button
 *
 *
 * The UX option is set to true by default
 * set 'ux' => false if you don't want to use it for one form
 * In order to correctly work, you need $faLoad and $bsAddonLoad set to true in the BsHelper
 *
 * @param string $caption The label appearing on the button OR if string contains :// or the
 *  extension .jpg, .jpe, .jpeg, .gif, .png use an image if the extension
 *  exists, AND the first character is /, image is relative to webroot,
 *  OR if the first character is not /, image is relative to webroot/img.
 * @param array $options Array of options. See above.
 * @return string A HTML submit button
 */
	public function submit($caption = null, $options = array()) {
		$out = '';
		$ux = (isset($options['ux']) && false === $options['ux']) ? false : true;
		unset($options['ux']);

		$basicOptions = array(
			'div' => false,
			'class' => 'btn btn-success',
			'before' => $this->__buildSubmitBefore(),
		);

		$typeOfButton = 'success';
		$types = array('danger', 'warning', 'info', 'primary');

		//----- [class] option
		if (isset($options['class'])) {
			$basicClass = $options['class'];
			$options['class'] = $basicOptions['class'] . ' ' . $options['class'];

			foreach ($types as $type) {
				if (strpos($options['class'], $type) > 0) {
					$typeOfButton = $type;
					$options['class'] = 'btn ' . $basicClass;
					break;
				}
			}
		}

		$basicOptions['after'] = $this->__buildSubmitAfter($ux, $typeOfButton);

		$options = Hash::merge($basicOptions, $options);

		return parent::submit($caption, $options);
	}

/**
 * Build the html before the submit
 *
 * @return string
 */
	private function __buildSubmitBefore() {
		if ($this->_getFormType() == 'horizontal') {
			return '<div class="form-group">' . '<div class="' . $this->__rightClass(false) . '">';
		}

		return '';
	}

/**
 * Build the html after the radio
 *
 * @param bool $ux     Check if ux animations are activated
 * @param string $type Type of the submit button
 * @return string
 */
	private function __buildSubmitAfter($ux, $type) {
		$out = '';

		if ($ux) {
			$out .= '<i class="fa fa-spinner fa-spin form-submit-wait text-' . $type . '"></i>';

			$idForm = '#' . Inflector::camelize($this->_modelForm . ' ' . $this->_actionForm . ' Form');

			$out .= '<script>';
			$out .= '$("' . $idForm . '").submit(function(){';
			$out .= '$("' . $idForm . ' input[type=\'submit\']").prop("disabled" , true);';
			$out .= '$("' . $idForm . ' .form-submit-wait").show();';
			$out .= '});';
			$out .= '</script>';
		}

		if ($this->_getFormType() == 'horizontal') {
			$out .= '</div></div>';
		}

		return $out;
	}

	/*--------------------------*
	 *						    *
	 *			TAG FORM        *
	 *					        *
	 *--------------------------*/

/**
 * Returns an HTML element
 *
 * @param string $text Title
 * @param int $h The level of the title 1-6
 * @return string the formatted HTML with a row, columns and the title
 */
	public function title($text, $h = 4) {
		return $this->__tagForm('h' . $h, $text);
	}

/**
 * Returns an HTML element
 *
 * @param string $text Indications
 * @param string $class a class for the p element
 * @return string the formatted HTML with a row, columns and the indications in a p
 */
	public function indications($text, $class = '') {
		if ('' != $class) {
			return $this->__tagForm('p', $text, array('class' => $class));
		} else {
			return $this->__tagForm('p', $text);
		}
	}

/**
 * Call the Tag function of the BsHelper in a row and a column like the Form
 *
 * @param string $tag Tag name.
 * @param string $text String content that will appear inside the element.
 * @param array $options Additional HTML attributes of the element
 * @return string The formatted tag element
 */
	private function __tagForm($tag, $text, $options = array()) {
		$out = $this->Bs->row();

		// Use of the _right and _left attributes to define with and offset of the column
		$out .= $this->Bs->col('md' . $this->getRight() . ' of' . $this->getLeft());

		$out .= $this->Bs->tag($tag, $text, $options);

		$out .= $this->Bs->close(2);

		return $out;
	}

/**
 * Return an html element with chosen attached
 *
 * @param String $fieldName name of the field
 * @param Array $options options of the select
 * @param Array $attr attributes of the select element (multiple etc...)
 * @param Array $chosenAttr attributes of the chosen js call
 * @return string
 */
	public function chosen($fieldName = 'fieldname', $options = array(), $attr = array(), $chosenAttr = array()) {
		$class = Inflector::slug($fieldName);
		// Default option for the select
		$defaultAttr = array(
			'label' => '',
			'class' => 'chosen-' . $class,
			'data-placeholder' => 'Cliquez pour choisir',
		);

		// Default option for chosen
		$defaultChosenAttr = array(
			'width' => '100%',
			'default_multiple_text' => 'Cliquez pour choisir',
			'default_single_text' => 'Cliquez pour choisir',
			'default_no_result_text' => 'Pas de correspondance pour : ',
		);

		// Chosen attribute encoded to pass it to JS
		$chosenAttr = json_encode(Hash::merge($defaultChosenAttr, $chosenAttr));

		// 3rd party libraries and css
		if ($this->Bs->loaded('chosen') === false) {
			echo $this->Bs->loadCSS('https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.css');
			echo $this->Bs->loadCSS('https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen-sprite.png');
			echo $this->Bs->loadJS('https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.js');
			$this->Bs->load('chosen', true);
		}

		// JS send to the page
		echo $this->Bs->loadJS('$(document).ready(function(){$(".chosen-' . $class . '").chosen(' . $chosenAttr . ');});', true, array('block' => 'scriptBottom'));
		// Chosen select created ->
		return $this->select($fieldName, $options, Hash::merge($defaultAttr, $attr));
	}

}