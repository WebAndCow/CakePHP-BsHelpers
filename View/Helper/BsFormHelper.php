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
	protected function _setFormType($val){
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

		//----- [before], [state] and [after] options
		if (!isset($options['before']) && !isset($options['after'])) {
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
			$options['after'] = '</div>';
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
		}else{
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
			$options['between'] = '<div class="col-md-'.$this->right.'">';
			if (isset($options['help']) && !empty($options['help'])) {
				$options['after'] = '<span class="help-block">'.$options['help'].'</span></div></div>';
			}else{
				$options['after'] = '</div></div>';
			}
		}

		return parent::input($fieldName, $options).SP;
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
 * @return string An HTML text input element.
 */

	public function checkbox($fieldName, $options = array()){

		//----- [div] option
		if (!isset($options['div'])) {
			$options['div'] = false;
		}

		//----- [label] option
		if (!isset($options['label'])) {
			$options['label'] = false;
		}

		$out = '';

		if ($this->_getFormType() == 'horizontal') {
			$out .= '<div class="form-group">';
			$out .= '<div class="col-md-offset-'.$this->left.' col-md-'.$this->right.'">';
		}

		//----- [inline] option
		if (!(isset($options['inline']) && ($options['inline'] == 'inline' || $options['inline'] == true))) {
			$out .= '<div class="checkbox">';
			$out .= '<label>';
		}else{
			$out .= '<label class="checkbox-inline">';
		}

		$out .= parent::checkbox($fieldName, $options);

		//----- [label] option
		if ($options['label'] != false) {
			// If options are array('label' => 'text')
			if (is_array($options['label'])) {
				$out .= ' '.$options['label']['label'];
			}else{
				$out .= ' '.$options['label'];
			}
		}else{
			$out .= ' '.Inflector::camelize($fieldName);
		}

		$out .= '</label>';



		//----- [help] option for multiple checkboxes ([label] is an array)
		if (is_array($options['label']) && isset($options['label']['help']) && !empty($options['label']['help'])) {
			$out .= '<span class="help-block">'.$options['label']['help'].'</span>';
		}

		//----- [inline] option
		if (!(isset($options['inline']) && ($options['inline'] == 'inline' || $options['inline'] == true))) {
			$out .= '</div>';
		}

		$out .= SP;

		//----- [help] option for single checkbox
		if ($this->_getFormType() == 'horizontal') {
			if (isset($options['help']) && !empty($options['help'])) {
				$out .= '<span class="help-block">'.$options['help'].'</span>';
			}
			$out .= '</div></div>';
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
			if(is_integer(strpos($options['class'], 'btn-danger')) || is_integer(strpos($options['class'], 'btn-warning'))){	
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
 * Closes an HTML form, cleans up values set by Bs3FormHelper::create(), and writes hidden
 * input fields where appropriate.
 *
 * @param string|array $options as a string will use $options as the value of button,
 * @return string a closing FORM tag optional submit button.
 */

	public function end($options = null){
		return parent::end($options);
	}
}
