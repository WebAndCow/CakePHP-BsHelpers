<?php

/**
 *
 * Helper CakePHP pour créer des éléments formulaires du Bootstrap Twitter version 3
 * @author Web&Cow - France
 *
 */


class BsFormHelper extends FormHelper {

/**
 * The name of the helper
 *
 * @var string
 */
	public $name = 'BsForm';

/**
 * Right and left settings to have 2 columns (label and inputs) with an horizontal form
 * Default values are : left -> 3 ; right -> 9
 *
 * @var int
 */
	private $left = 3;
	private $right = 9;

/**
 * Defines the type of form being created, horizontal form or inline form. Set by Bs3FormHelper::create()
 *
 * @var string
 */
	protected $_typeForm = 'horizontal';

/**
 * Defines the model of form being created. Set by Bs3FormHelper::create()
 *
 * @var string
 */
	protected $_modelForm = null;

/**
 * Return the current value of $left
 */
	public function getLeft(){
		return $this->left;
	}

/**
 * Set the value of $left
 *
 * @var int
 */
	public function setLeft($val){
		$this->left = $val;
	}

/**
 * Return the current value of $right
 */
	public function getRight(){
		return $this->right;
	}

/**
 * Set the value of $right
 *
 * @var int
 */
	public function setRight($val){
		$this->right = $val;
	}

/**
 * Return the current value of $_typeForm
 */
	protected function _getFormType(){
		return $this->_typeForm;
	}

/**
 * Set the value of $_typeForm
 *
 * @var string
 */
	public function _setFormType($val){
		$this->_typeForm = $val;
	}

/**
 * Return the current value of $_modelForm
 */
	protected function _getModelForm(){
		return $this->_modelForm;
	}

/**
 * Set the value of $_typeForm
 *
 * @var string
 */
	protected function _setModelForm($val){
		$this->_modelForm = $val;
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

	public function create($model = null, $options = array()){

		if (!isset($options['role'])){
			$options['role'] = 'form';
		}

		if (isset($options['class'])) {
			if (is_integer(strpos($options['class'], 'form-horizontal'))){
				$this->_setFormType('horizontal');
			}elseif (is_integer(strpos($options['class'], 'form-inline'))) {
				$this->_setFormType('inline');
			}
		}else{
			$options['class'] = 'form-horizontal';
		}

		$this->_setModelForm($model);

		return parent::create($model, $options);
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
	public function input($fieldName, $options = array()){

		if (isset($options['type']) and $options['type'] == 'date') {
			$options['between'] = '<div class="col-md-'.$this->right.'">';
			$options['after'] = '</div></div>';
			if (isset($options['class'])) {
				$options['class'] .= ' input_date';
			} else {
				$options['class'] = 'input_date';
			}

		}

		//----- [before], [state] and [after] options
		if (!isset($options['before'])) {
			if (isset($options['state'])) {
				switch ($options['state']) {
					case 'error':
						$state = ' has-error';
						break;
					case 'warning':
						$state = ' has-warning';
						break;
					case 'success':
						$state = ' has-success';
						break;

					default:
						$state = '';
						break;
				}
				$options['before'] = '<div class="form-group'.$state.'">';
			}else{
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

		//----- [class] option
		if (isset($options['class'])) {
			$options['class'] .= ' form-control';
		}else{
			$options['class'] = 'form-control';
		}

		//----- [label] option
		if (!isset($options['label'])) {
			if ($this->_getFormType() == 'horizontal') {
				$options['label'] = array('class' => 'control-label col-md-'.$this->left);
			}else{
				$options['label'] = array('class' => 'control-label sr-only');
			}
		} else {
			if (!is_array($options['label'])) {
				$options['label'] = array('class' => 'control-label col-md-'.$this->left, 'text' => $options['label']);
			}else{
				if (isset($options['label']['class'])) {
					$options['label']['class'] .= ' control-label col-md-'.$this->left;
				}else{
					$options['label']['class'] = 'control-label col-md-'.$this->left;
				}
			}
		}

		//----- [between], [after] and [help] options
		if ($this->_getFormType() == 'horizontal') {
			if (!isset($options['between'])) {
				$options['between'] = '<div class="col-md-'.$this->right.'">';
			}
			if ($options['after'] == '</div>'){
				if (isset($options['help']) && !empty($options['help'])) {
					$options['after'] = '<span class="help-block">'.$options['help'].'</span></div></div>';
				}else{
					$options['after'] = '</div></div>';
				}
			}
		}

		return parent::input($fieldName, $options).SP;
	}


/**
 * Generate a form input element with an addon or button on his side.
 *
 *  * ### Addon Options
 *
 * - 'content' - The addon content.
 * - 'side'    - Which side the addon will be. Be default 'left'.
 * - 'state'   - Change bootstrap button state. Values : 'default', 'primary', 'secondary', 'warning', 'danger'.
 * - 'class'   - Add HTML class attribute.
 * - 'button'  - Define if the addon is a submit button. By default 'false'.
 *
 * @param array $options      Extends of BsFormHelper::input() so get same options
 * @param array $addonOptions Array of options
 *
 * @return string Input-group de Bootstrap
 */
	public function inputGroup($fieldName, $options, $addonOptions)
	{

		$between = '<div class="col-md-'.$this->right.'">'. BL;
		$between .= '<div class="input-group">'. BL;

		// Check if the addon is on the right
		if (isset($addonOptions	['side']) && $addonOptions['side'] == 'right') {
			$after = $this->_createAddon($addonOptions).'</div>'.'</div>'. BL;
			unset($addonOptions['side']);
		} else {
			$between .= $this->_createAddon($addonOptions). BL;
			$after = '</div>'.'</div>'. BL;
		}

		$after .= '</div>'. BL;
		$options['between'] = $between;
		$options['after'] = $after;
		$options['before'] = null;
		$options['div'] = false;

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
	private function _createAddon($options)
	{
		if (is_array($options)) {

			// Check if the span content is a button
			if (isset($options['button'])) {

				$buttonOptions = $options['button'];
				$state = 'btn btn-default';

				if (isset($options['class'])) {
					$options['class'] .= ' input-group-btn';
				} else {
					$options['class'] = 'input-group-btn';
				}

				$out = '<span class="'.$options['class'].'">'. BL;

				if (isset($buttonOptions['state'])) {
					$state = 'btn btn-'.$buttonOptions['state'];
					unset($buttonOptions['state']);
				}

				if (isset($buttonOptions['class'])) {
					$buttonOptions['class'] .= ' '.$state;
				} else {
					$buttonOptions['class'] = $state;
				}

				if (!isset($buttonOptions['type'])) {
					$buttonOptions['type'] = 'button';
				}

				if ($buttonOptions['type'] == 'submit') {
					$buttonOptions['div'] = false;
					$out .= parent::submit($options['content'], $buttonOptions). BL;
				} else {
					$out .= parent::button($options['content'], $buttonOptions). BL;
				}

				$out .= '</span>'. BL;

			} else {

				if (isset($options['left']['class'])) {
					$options['class'] .= ' input-group-addon';
				} else {
					$options['class'] = 'input-group-addon';
				}

				$out = '<span class="'.$options['class'].'">'.$options['content'].'</span>'. BL;
			}
		} else {
			$out = '<span class="input-group-addon">'.$options.'</span>'. BL;
		}

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
 * ### labelOptions use two key
 *
 * - 'label' - Define the label content
 * - 'class' - Define the label class
 *
 *
 * ### In case of multiple checkboxes -> use the Bs3FormHelper::select()
 *
 * Some options are added
 * - 'help' - can be for each, always with an array in parameter
 * - 'hiddenField' - 'false' by default
 *
 * @param string $fieldName Name of a field, like this "Modelname.fieldname"
 * @param array $options Array of HTML attributes.
 * @param array $labelOptions Array of options
 * @return string An HTML text input element.
 */

	public function checkbox($fieldName, $options = array()){

		//----- [label]
		if(isset($options['label'])) {
			$label = $options['label'];
		} else {
			$label = Inflector::camelize($fieldName);
		}

		//----- [label] class
		if (isset($options['label-class'])) {
			$label_class = array('class' => $options['label-class']);
		} else {
			$label_class = array();
		}

		$out = '';

		if ($this->_getFormType() == 'horizontal' && !isset($options['inline'])) {
			$out .= '<div class="form-group">';
			$out .= '<div class="col-md-offset-'.$this->left.' col-md-'.$this->right.'">';
		}

		//----- [inline] option
		if (!(isset($options['inline']) && ($options['inline'] == 'inline' || $options['inline'] == true))) {
			$out .= '<div class="checkbox">';
			$out .= parent::label($fieldName, parent::checkbox($fieldName, $options).' '.$label, $label_class);
		}else{
			if (isset($labelOptions['class']) and !is_array($labelOptions['class'])) {
				$labelOptions['class'] .= ' checkbox-inline';
			} else {
				$labelOptions['class'] = 'checkbox-inline';
			}
			$out .= parent::label($fieldName, parent::checkbox($fieldName, $options).' '.$label, $labelOptions);
		}

		//----- [help] option for multiple checkboxes ([label] is an array)
		if (is_array($options['label']) && isset($options['label']['help']) && !empty($options['label']['help'])) {
			$out .= '<span class="help-block">'.$options['label']['help'].'</span>';
		}

		$out .= SP;

		//----- [help] option for single checkbox
		if ($this->_getFormType() == 'horizontal' && !isset($options['inline'])) {
			if (isset($options['help']) && !empty($options['help'])) {
				$out .= '<span class="help-block">'.$options['help'].'</span>';
			}
			$out .= '</div></div></div>';
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

	public function select($fieldName, $options = array(), $attributes = array()){

		$out = '';

		// MULTIPLE CHECKBOX
		if ((isset($attributes['multiple']) && $attributes['multiple'] != 'checkbox') || !isset($attributes['multiple'])) {
			if (!isset($attributes['class'])) {
				$attributes['class'] = 'form-control';
			}else{
				$attributes['class'] .= ' form-control';
			}
		}else{
			//----- [inline] attribute for checkbox
			if(isset($attributes['inline']) && ($attributes['inline'] == 'inline' || $attributes['inline'] == true)){
				if (!isset($attributes['class'])) {
					$attributes['class'] = 'checkbox checkbox-inline';
				}else{
					$attributes['class'] = 'checkbox checkbox-inline '.$attributes['class'];
				}
			}else{
				if (!isset($attributes['class'])) {
					$attributes['class'] = 'checkbox';
				}else{
					$attributes['class'] = 'checkbox '.$attributes['class'];
				}
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
				$out .= '<label class="control-label col-md-'.$this->left.'">'.$attributes['label'].'</label>';
				$out .= '<div class="col-md-'.$this->right.'">';
			}else{
				$out .= '<div class="col-md-offset-'.$this->left.' col-md-'.$this->right.'">';
			}
		}

		$out .= parent::select($fieldName, $options, $attributes);

		if ($this->_getFormType() == 'horizontal') {
			//----- [help] attribute
			if (isset($attributes['help']) && !empty($attributes['help'])) {
				$out .= '<span class="help-block">'.$attributes['help'].'</span>';
			}
			$out .= '</div></div>';
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

	public function radio($fieldName, $options = array(), $attributes = array()){

		$out = '';

		if ($this->_getFormType() == 'horizontal') {

			$out .= '<div class="form-group">';

			//----- [label] attribute
			if (isset($attributes['label']) && !empty($attributes['label'])) {
				$out .= '<label class="control-label col-md-'.$this->left.'">'.$attributes['label'].'</label>';
				$out .= '<div class="col-md-'.$this->right.'">';
			}else{
				$out .= '<div class="col-md-offset-'.$this->left.' col-md-'.$this->right.'">';
			}
		}

		foreach ($options as $key => $value) {

			//----- [inline] attribute
			if (!(isset($attributes['inline']) && ($attributes['inline'] == 'inline' || $attributes['inline'] == true))) {
				$out .= '<div class="radio">';
				$out .= '<label>';
			}else{
				$out .= '<label class="radio-inline">';
			}

			$out .= '<input type="radio" name="data['.$this->_getModelForm().']['.$fieldName.']" id="'.$this->_getModelForm().Inflector::camelize($fieldName).$key.'" value="'.$key.'"';

			//----- [value] attribute
			if (isset($attributes['value']) && $attributes['value'] == $key) {
				$out .= ' checked';
			}

			//----- [disabled] attribute
			if (isset($attributes['disabled'])){
				if (!is_array($attributes['disabled'])){
					if ($attributes['disabled'] == true || $attributes['disabled'] == 'disabled') {
						$out .= ' disabled';
					}
				}else{
					foreach ($attributes['disabled'] as $elem) {
						if ($elem == $key) {
							$out .= ' disabled';
						}
					}
				}
			}

			// If options are array('label' => 'text')
			if (is_array($value)) {
				$out .= '>'.' '.$value['label'];
			}else{
				$out .= '>'.' '.$value;
			}

			$out .= '</label>';

			//----- [help] option
			if (isset($value['help']) && !empty($value['help']) && is_array($options[$key])) {
				$out .= '<span class="help-block">'.$options[$key]['help'].'</span>';
			}

			//----- [inline] attribute
			if (!(isset($attributes['inline']) && ($attributes['inline'] == 'inline' || $attributes['inline'] == true))) {
				$out .= '</div>';
			}

			$out .= SP;
		}

		if ($this->_getFormType() == 'horizontal') {

			//----- [help] attribute
			if (isset($attributes['help']) && !empty($attributes['help'])) {
				$out .= '<span class="help-block">'.$attributes['help'].'</span>';
			}
			$out .= '</div></div>';
		}

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
 * @param string $caption The label appearing on the button OR if string contains :// or the
 *  extension .jpg, .jpe, .jpeg, .gif, .png use an image if the extension
 *  exists, AND the first character is /, image is relative to webroot,
 *  OR if the first character is not /, image is relative to webroot/img.
 * @param array $options Array of options. See above.
 * @return string A HTML submit button
 */

	public function submit($caption = null, $options = array()){

		$out = '';

		if ($this->_getFormType() == 'horizontal') {
			$out .= '<div class="form-group">';
			$out .= '<div class="col-md-offset-'.$this->left.' col-md-'.$this->right.'">';
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
		}else{
			if(is_integer(strpos($options['class'], 'btn-danger')) || is_integer(strpos($options['class'], 'btn-warning')) || is_integer(strpos($options['class'], 'btn-info'))){
				$options['class'] = 'btn '.$options['class'];
			}else{
				$options['class'] = 'btn '.$options['class'].' btn-success';
			}
		}

		$out .= parent::submit($caption, $options);

		if ($this->_getFormType() == 'horizontal') {
			$out .= '</div></div>';
		}

		return $out;
	}


	/**
	 * Create an input-datepicker element
	 *
	 * ### options datepicker
	 * - format 		Input Date format.
	 * - startview      Datepicker startview (days, months, years).
	 * - orientation    Orientation of the datepicker window (top left, bottom right, ...).
	 * - language       Datepicker langage (en, fr, ...).
	 * - autoclose      True to close automaticly the window when you clic.
	 * - ... and more at http://eternicode.github.io/bootstrap-datepicker/
	 *
	 * @param string $fieldName This should be "Modelname.fieldname"
	 * @param array  $options   Each type of input takes different options.
	 * @param array  $optionsDP Datepicker options.
	 *
	 * @return string Input datepicker element
	 */
	public function datepicker($fieldName, $options = array(), $optionsDP = array())
	{
		// Set some default parameters
		if (!isset($optionsDP['format'])) {
			$optionsDP['format'] = 'dd/mm/yyyy';
		}
		if (!isset($optionsDP['language'])) {
			$optionsDP['language'] = 'fr';
		}

		// If it's a datepicker range
		if (is_array($fieldName)) {

			$script = "$('#sandbox-container .input-daterange').datepicker({". BL;
			$script .= $this->_scriptDP($optionsDP).'})'. BL;
			$script .= '.on(\'changeDate\', function(){'. BL;

			$_left = $this->left;

			if (!isset($optionsDP['addon'])) {
				$optionsDP['addon'] = 'à';
			}
			if (!isset($optionsDP['label'])) {
				$optionsDP['label'] = '';
			}

			$out = '<div class="form-group">';
			$out .= '<label class="control-label col-md-3">'.$optionsDP['label'].'</label>';
			unset($optionsDP['label']);
			$out .= '<div id="sandbox-container">';
			$out .= '<div class=" col-md-9">';
			$out .= '<div class="input-daterange input-group" id="datepicker">';

			$this->left= 0;

			foreach ($fieldName as $key => $field) {
				if($key == 1){
					$out .= '<span class="input-group-addon">'.$optionsDP['addon'].'</span>'. BL;
					unset($optionsDP['addon']);
				}

				$options[$field]['label'] = false;
				$options[$field]['before'] = '';
    			$options[$field]['between'] = '';
				$options[$field]['after'] = '';

				if (isset($options[$field])) {
					$out .= $this->input($field, $options[$field]). BL;
				}else{
					$out .= $this->input($field, $options). BL;
				}
				$options[$field]['type'] = 'hidden';
    			$options[$field]['id'] = 'alt_dp_'.$key;

    			if (isset($options[$field])) {
					$out .= $this->input($field, $options[$field]). BL;
				}else{
					$out .= $this->input($field, $options). BL;
				}

				$script .= 'var date_'.$key.' = $(\'#'.parent::domId($field).'\').datepicker(\'getDate\');
				date_'.$key.'.setHours(0, -date_'.$key.'.getTimezoneOffset(), 0, 0);
				date_'.$key.' = date_'.$key.'.toISOString().slice(0,19).replace(\'T\', " ");
			    $(\'#alt_dp_'.$key.'\').attr(\'value\', date_'.$key.');';

			}

    		$this->left = $_left;
    		$out.= '</div></div>';
    		$out .= '</div></div>';

			$script .= '});';

			$out.= '<script>'.$script.'</script>';

		} else {
			$out = '<div id="sandbox-container">'. BL;
			$out .= $this->input($fieldName, $options). BL;
			$options['id'] = 'alt_dp';
			$options['type'] = 'hidden';
			$out .= $this->input($fieldName, $options). BL;
			$out .= '</div>'. BL;

			$script = "$('#sandbox-container input').datepicker({". BL;
			$script .= $this->_scriptDP($optionsDP).'})'. BL;

			$script .= '.on(\'changeDate\', function(){
				var date = $(\'#'.parent::domId($fieldName).'\').datepicker(\'getDate\');
				date.setHours(0, -date.getTimezoneOffset(), 0, 0);
				date = date.toISOString().slice(0,19).replace(\'T\', " ");
			    $(\'#alt_dp\').attr(\'value\', date);';
			$script .= '});';

			$out.= '<script>'.$script.'</script>';

		}
		return $out;
	}


/**
 * Create a datepicker script body.
 *
 * @param array $options $optionsDP from $this->datepicker()
 *
 * @return string Formated script body
 */
	private function _scriptDP($options)
	{
		$script = '';
		foreach ($options as $key => $value) {
			if (is_bool($value)) {
				if ($value === true) {
					$script .= $key.' : true,'. BL;
				} else {
					$script .= $key.' : false,'. BL;
				}
			} else {
				if (is_int($value) or is_bool($value)) {
					$script .= $key.' : '.$value.','. BL;
				} else {
					$script .= $key.' : "'.$value.'",'. BL;
				}
			}
		}
		return $script;
	}


/**
 * Closes an HTML form, cleans up values set by Bs3FormHelper::create(), and writes hidden
 * input fields where appropriate.
 *
 * @param string|array $options as a string will use $options as the value of button,
 * @return string a closing FORM tag optional submit button.
 */

	public function end($options = null, $secureAttributes = array()){
		return parent::end($options, $secureAttributes);
	}
}
