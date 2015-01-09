<?php

App::uses('FormHelper', 'View/Helper');
App::uses('Set', 'Utility');

/**
 *
 * Helper CakePHP pour créer des éléments formulaires du Bootstrap Twitter version 3
 * @author Web&Cow - France
 *
 */
class BsFormHelper extends AppHelper {

/**
 * BsForm uses the BsHelper so it can use some feature of it
 * BsForm uses the FormHelper
 *
 * @var array
 */
	public $helpers = array('Bs' , 'Form');

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
			}
		} else {
			$options['class'] = 'form-horizontal';
			$this->setFormType('horizontal');
		}

		$this->_setModelForm($model);

		if(isset($options['action'])) {
			$this->_setActionForm($options['action']);
		}

		return $this->Form->create($model, $options);
	}

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
		$formType = $this->_getFormType();
		// If we have a 'state', record then delete from the array
		if (isset($options['state'])) {
			$state = $options['state'];
			unset($options['state']);
		} else {
			$state = false;
		}
		// The same thing with 'help'
		if (isset($options['help'])) {
			$help = $options['help'];
			unset($options['help']);
		} else {
			$help = false;
		}
		// To know if it's data case
		$date = (isset($options['type']) && ($options['type'] == 'date' || $options['type'] == 'datetime')) ? true : false;

		// Dans le cas d'un input de type date ou datetime
		if ($date) {
			$this->setFormType('inline');
			if (isset($options['class'])) {
				$options['class'] .= ' input_date';
			} else {
				$options['class'] = 'input_date';
			}
		}

		//----- [before], [state] and [after] options
		if (!isset($options['before'])) {
			$states = array('error', 'warning', 'success');
			if ($state) {
				$state = (in_array($state, $states)) ? ' has-' . $state : '';
				$options['before'] = '<div class="form-group' . $state . '">';
			} else {
				$options['before'] = '<div class="form-group">';
			}
			if (!isset($options['after'])) {
				$options['after'] = '</div>';
			}
		}

		//----- [div] option
		if (!isset($options['div'])) {
			$options['div'] = false;
		}

		if (!$date) {
			//----- [class] option
			if (isset($options['class'])) {
				$options['class'] .= ' form-control';
			} else {
				$options['class'] = 'form-control';
			}
		}

		//----- [label] option
		if (!isset($options['label'])) {
			if ($this->_getFormType() == 'horizontal' || ($date && $formType == 'horizontal')) {
				$options['label'] = array('class' => 'control-label col-md-' . $this->__left);
			} else {
				$options['label'] = array('class' => 'control-label sr-only');
			}
		} elseif ($options['label'] != false) {
			if (!is_array($options['label'])) {
				$options['label'] = array('class' => 'control-label col-md-' . $this->__left, 'text' => $options['label']);
			} else {
				if (isset($options['label']['class'])) {
					$options['label']['class'] .= ' control-label col-md-' . $this->__left;
				} else {
					$options['label']['class'] = 'control-label col-md-' . $this->__left;
				}
			}
		}

		//----- [between], [after] and [help] options
		if ($this->_getFormType() == 'horizontal' || ($date && $formType == 'horizontal')) {
			if (!isset($options['between'])) {
				$options['between'] = '<div class="col-md-' . $this->__right;
				$options['between'] .= ($options['label'] == false) ? ' col-md-offset-' . $this->__left : '';
				$options['between'] .= '">';
			}
			if ($options['after'] == '</div>') {
				if ($help && !empty($help)) {
					$options['after'] = '<span class="help-block">' . $help . '</span></div></div>';
				} else {
					$options['after'] = '</div></div>';
				}
			}
		}

		// debug($options);

		return $this->Form->input($fieldName, $options) . $this->setFormType($formType);
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
		$between = '<div class="col-md-' . $this->__right . ' col-md-offset-' . $this->__left . '">';
		$between .= '<div class="input-group">';

		// Check if the addon is on the right
		if (isset($addonOptions['side']) && $addonOptions['side'] == 'right') {
			$after = $this->__createAddon($addonOptions) . '</div>' . '</div>';
			unset($addonOptions['side']);
		} else {
			$between .= $this->__createAddon($addonOptions);
			$after = '</div>' . '</div>';
		}

		$after .= '</div>';
		$options['between'] = $between;
		$options['after'] = $after;
		if (!isset($options['before'])) {
			$options['before'] = null;
		}
		if (!isset($options['div'])) {
			$options['div'] = false;
		}
		if (!isset($options['label'])) {
			$options['label'] = false;
		}
		$out = $this->input($fieldName, $options);
		return $out;
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
					$out .= $this->Form->input($options['content'], $buttonOptions);
				} else {
					$out .= $this->Form->button($options['content'], $buttonOptions);
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
* 
* @return string An HTML text with a line of Javascript to launch CKEDITOR Script
*/
public function ckEditor($fieldName) {

		// If there is a point in the fieldName
		if(strpos($fieldName, '.') !== false) {
			$nameForReplace = Inflector::camelize($fieldName);
		} else {
			$nameForReplace = $this->_modelForm.Inflector::camelize($fieldName);
		}

		// Create the line of JS
		$out  = '<script>';
		$out .= 'CKEDITOR.replace("'.$nameForReplace.'");';
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
		if (isset($options['help']) && !empty($options['help'])) {
			$help = $options['help'];
			unset($options['help']);
		} else {
			$help = false;
		}

		//----- [div] option
		if (!isset($options['div'])) {
			$options['div'] = false;
		}

		//----- [label]
		if (isset($options['label'])) {
			if (is_array($options['label']) && isset($options['label']['help']) && !empty($options['label']['help'])) {
				$labelHelp = $options['label']['help'];
			} else {
				$labelHelp = null;
			}
			$label = $options['label'];
			unset($options['label']);
		} else {
			$label = Inflector::camelize($fieldName);
		}

		//----- [label] class
		if (isset($options['label-class'])) {
			$labelClass = array('class' => $options['label-class']);
			unset($options['label-class']);
		} else {
			$labelClass = array();
		}

		$out = '';

		if ($this->_getFormType() == 'horizontal' && !isset($options['inline'])) {
			$out .= '<div class="form-group">';
			$out .= '<div class="col-md-offset-' . $this->__left . ' col-md-' . $this->__right . '">';
		}

		//----- [help] option for multiple checkboxes ([label] is an array)
		if (isset($options['label']) && isset($labelHelp)) {
			$out .= '<span class="help-block">' . $options['label']['help'] . '</span>';
		}

		//----- [inline] option
		if (!(isset($options['inline']) && ($options['inline'] == 'inline' || $options['inline'] == true))) {
			$out .= '<div class="checkbox">';
			$out .= $this->Form->label($fieldName, $this->Form->checkbox($fieldName, $options) . ' ' . $label, $labelClass);
		} else {
			unset($options['inline']);
			if (isset($labelClass['class'])) {
				$label = $labelClass['class'] . ' checkbox-inline';
			}

			$out .= $this->Form->label($fieldName, $this->Form->checkbox($fieldName, $options) . ' ' . $label, $labelClass);
		}

		//----- [help] option for single checkbox
		if ($this->_getFormType() == 'horizontal' && !isset($options['inline'])) {
			if ($help) {
				$out .= '<span class="help-block">' . $help . '</span>';
			}
			$out .= '</div></div></div>';
		} else {
			$out .= '</div>';
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
		$inline = (isset($attributes['inline']) && ($attributes['inline'] == 'inline' || $attributes['inline'] == true)) ? true : false;

		// MULTIPLE CHECKBOX
		if ((isset($attributes['multiple']) && $attributes['multiple'] != 'checkbox') || !isset($attributes['multiple'])) {
			if (!isset($attributes['class'])) {
				$attributes['class'] = 'form-control';
			} else {
				$attributes['class'] .= ' form-control';
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

		if ($this->_getFormType() == 'horizontal') {

			$out .= '<div class="form-group">';
			//----- [label] attribute
			if (isset($attributes['label']) && !empty($attributes['label'])) {
				$out .= '<label class="control-label col-md-' . $this->__left . '">' . $attributes['label'] . '</label>';
				$out .= '<div class="col-md-' . $this->__right . '">';
			} else {
				$out .= '<div class="col-md-offset-' . $this->__left . ' col-md-' . $this->__right . '">';
			}
		}

		$out .= $this->Form->select($fieldName, $options, $attributes);

		if ($this->_getFormType() == 'horizontal') {
			//----- [help] attribute
			if (isset($attributes['help']) && !empty($attributes['help'])) {
				$out .= '<span class="help-block">' . $attributes['help'] . '</span>';
			}
			$out .= '</div></div>';
		}

		if ((isset($attributes['multiple']) && $attributes['multiple'] == 'checkbox')) {

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
		$inline = ($this->_getFormType() == 'inline' || (isset($attributes['inline']) && $attributes['inline'] == true)) ? true : false;
		$defaultAttributes = array(
			'legend' => false,
			'label' => false,
		);

		if (!$inline) {

			$defaultAttributes['separator'] = '</label></div><div class="radio"><label>';

			$out .= '<div class="form-group">';

			//----- [label] attribute
			if (isset($attributes['label']) && !empty($attributes['label'])) {
				$out .= '<label class="control-label col-md-' . $this->__left . '">' . $attributes['label'] . '</label>';
				$out .= '<div class="col-md-' . $this->__right . '">';
			} else {
				$out .= '<div class="col-md-offset-' . $this->__left . ' col-md-' . $this->__right . '">';
			}

			$out .= '<div class="radio">';
		} else {
			$defaultAttributes['separator'] = '</label><label class="radio-inline">';
		}

		$out .= ($inline) ? '<label class="radio-inline">' : '<label>';

		$attributes = Hash::merge($defaultAttributes, $attributes);

		$out .= $this->Form->radio($fieldName, $options, $attributes);

		$out .= '</label>';
		$out .= (!$inline) ? '</div></div></div>' : '';

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

		if ($this->_getFormType() == 'horizontal') {
			$out .= '<div class="form-group">';
			$out .= '<div class="col-md-offset-' . $this->__left . ' col-md-' . $this->__right . '">';
		}

		//----- [div] option
		if (!isset($options['div'])) {
			$options['div'] = false;
		}

		//----- [label] option
		if (!isset($options['label'])) {
			$options['label'] = false;
		}

		//----- [class] option
		if (!isset($options['class'])) {
			$options['class'] = 'btn btn-success';
		} else {
			if (is_integer(strpos($options['class'], 'btn-danger')) || is_integer(strpos($options['class'], 'btn-warning')) || is_integer(strpos($options['class'], 'btn-info')) || is_integer(strpos($options['class'], 'btn-primary'))) {
				$options['class'] = 'btn ' . $options['class'];
			} else {
				$options['class'] = 'btn ' . $options['class'] . ' btn-success';
			}
		}

		$out .= $this->Form->submit($caption, $options);

		//----- [ux] option
		$scriptUX = true;
		if(isset($options['ux']) and $options['ux'] == false)
			$scriptUX = false;

		if($scriptUX) {
			$out .= '<i class="fa fa-spinner fa-spin form-submit-wait"></i>';

			$idForm = '#'.Inflector::camelize($this->_modelForm.' '.$this->_actionForm.' Form');

			$out .= '<script>';
			$out .= '$("'.$idForm.'").submit(function(){';
			$out .= '$("'.$idForm.' input[type=\'submit\']").prop("disabled" , true);';
			$out .= '$("'.$idForm.' .form-submit-wait").show();';
			$out .= '});';
			$out .= '</script>';
		}


		if ($this->_getFormType() == 'horizontal') {
			$out .= '</div></div>';
		}

		return $out;
	}


/**
 * Closes an HTML form, cleans up values set by Bs3FormHelper::create(), and writes hidden
 * input fields where appropriate.
 * Almost the same function as the classic FormHelper, neeeded to user correctly the submit function of BsFormHelper
 *
 * @param string|array $options as a string will use $options as the value of button,
 * @param array $secureAttributes like the secureAttributes in the parent function
 * @return string a closing FORM tag optional submit button.
 */
	public function end($options = null, $secureAttributes = array()) {
		$out = null;
		$submit = null;

		if ($options !== null) {
			$submitOptions = array();
			if (is_string($options)) {
				$submit = $options;
			} else {
				if (isset($options['label'])) {
					$submit = $options['label'];
					unset($options['label']);
				}
				$submitOptions = $options;
			}
			$out .= $this->submit($submit, $submitOptions);
		}
		if ($this->requestType !== 'get' &&
			isset($this->Form->request['_Token']) &&
			!empty($this->Form->request['_Token'])
		) {
			$out .= $this->Form->secure($this->Form->fields, $secureAttributes);
			$this->Form->fields = array();
		}
		$this->Form->setEntity(null);
		$out .= $this->Form->Html->useTag('formend');

		$this->Form->_View->modelScope = false;
		$this->Form->requestType = null;
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
 * @param string $title Title
 * @param int $h The level of the title 1-6
 * @return string the formatted HTML with a row, columns and the title
 */
	public function title($text , $h = 4) {

		return $this->_tagForm('h'.$h , $text);
	}

/**
 * Returns an HTML element
 *
 * @param string $indications Indications
 * @param string $class a class for the p element
 * @return string the formatted HTML with a row, columns and the indications in a p
 */
	public function indications($text , $class = '') {

		if($class != '') {
			return $this->_tagForm('p' ,$text , array('class' => $class));
		} else {
			return $this->_tagForm('p' ,$text);
		}
		
	}

/**
 * Call the Tag function of the BsHelper in a row and a column like the Form
 *
 * @param string $name Tag name.
 * @param string $text String content that will appear inside the element.
 * @param array $options Additional HTML attributes of the element
 * @return string The formatted tag element
 */
	private function _tagForm($tag , $text, $options = array()) {

		$out  = $this->Bs->row();
		
		// Use of the _right and _left attributes to define with and offset of the column
		$out .= $this->Bs->col('md'.$this->getRight().' of'.$this->getLeft());

		$out .= $this->Bs->tag($tag , $text , $options);

		$out .= $this->Bs->close(2);

		return $out;
	}
}