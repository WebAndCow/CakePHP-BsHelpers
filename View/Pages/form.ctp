<?php 

// First Form

echo '<br/>'.

'<div class="container">'.
	'<div class="row">'.
		'<div class="col-xs-12">'.
			'<h1>Basic form</h1>'.
			$this->BsForm->create('Model').
				$this->BsForm->input('First name').
				$this->BsForm->input('Last name').
				$this->BsForm->input('Nickname').
				$this->BsForm->submit('Send').
			$this->BsForm->end().
		'</div>'.
	'</div>'.
'</div>';
echo '<br/>';




// Second Form

$select_options = array('M' => 'Man', 'W' => 'Woman');
$radio_options = array(0, 1, 2, 3, 4);

echo '<br/>'.

'<div class="container">'.
	'<div class="row">'.
		'<div class="col-xs-12">'.
			'<h1>Form with select, radio and checkbox</h1>'.
			$this->BsForm->create('Model').
				$this->BsForm->select('Sex', $select_options).
				$this->BsForm->checkbox('Married').
				$this->BsForm->radio('Kids', $radio_options).
				$this->BsForm->submit('Send').
			$this->BsForm->end().
		'</div>'.
	'</div>'.
'</div>';
echo '<br/>';




// Third Form

$this->BsForm->setLeft(2);
$this->BsForm->setRight(10);

$multiple_checkbox_options = array('Man' , 'Woman');

echo '<br/>'.

'<div class="container">'.
	'<div class="row">'.
		'<div class="col-xs-12">'.
			'<h1>Form more complicated and with a different columns size</h1>'.
			$this->BsForm->create('OtherModel').
				$this->BsForm->input('Name', array('help' => 'this input have the state "warning"', 'state' => 'warning')).
				$this->BsForm->select('Sex', $multiple_checkbox_options, array('multiple' => 'checkbox', 'inline' => 'inline', 'help' => 'what is your sex ?')).
				$this->BsForm->radio('Kids', $radio_options, array('label' => 'Kids', 'inline' => 'inline', 'help' => 'how many kids do you have ?')).
				$this->BsForm->submit('Send').
			$this->BsForm->end().
		'</div>'.
	'</div>'.
'</div>';

// Fourth Form

$tab = array(
	'1' => 'Choice 1',
 	'2' => 'Choice 2'
);

$tab2 = array(
	'group 1' => array(
		'1' => 'Choice 1',
		'2' => 'Choice 2'
	),
	'group 2' => array(
		'3' => 'Choice 3',
	 	'4' => 'Choice 4'
	)			
);

echo $this->BsForm->create('Test', array('action' => 'answer'));
echo $this->BsForm->chosen(
	'Tag.Tag', 
	$tab2, 
	array(
		'label'            => 'Chosen with options', 
		'data-placeholder' => 'Cliquez pour selectionner les valeurs recherchées',
		'default' => array('4'),
		'disabled' => array('1'),
		'multiple' => true,
	)
	
);
echo $this->BsForm->chosen(
	'Chien.name', 
	$tab, 
	array(
		'label'            => 'Simple chosen', 
		'data-placeholder' => 'Cliquez pour selectionner les valeurs recherchées',
		'default' => '2',
	)
);


echo $this->BsForm->input('field', array('data-mask' => '99-99-99-99-99'));

echo $this->BsForm->end('Send');