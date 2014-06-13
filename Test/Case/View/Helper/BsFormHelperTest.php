<?php

	App::uses('Controller', 'Controller');
	App::uses('View', 'View');
	App::uses('BsFormHelper', 'View/Helper');
	App::uses('FormHelper', 'View/Helper');

	class BsFormHelperTest extends CakeTestCase {

		public $BsForm = null;

	    public function setUp()
	    {
	    	parent::setUp();
		    $Controller = new Controller();
		    $View = new View($Controller);
		    $this->BsForm = new BsFormHelper($View);
	    }


	    /////////////////////////////////
	    // BsFormHelper::inputGroup()  //
	    /////////////////////////////////


	    public function testInputGroupSimple()
	    {
	    	$result = $this->BsForm->inputGroup('User.test', array('content' => 'Simple'));

			$expected = array(
				array("div" => array("class" => "form-group")),
				array("div" => array("class" => "col-md-9")),
				array("div" => array("class" => "input-group")),
				array("span" => array("class" => "input-group-addon")),
				"Simple",
				"/span",
				"input" => array(
					"name" => "data[User][test]",
					"type" => "text",
					"id" => "UserTest",
					"class" => "form-control"
				),
				"/div",
				"/div",
				"/div"
			);

	    	$this->assertTags($result, $expected);
	    }

	    public function testInputGroupWithLabel()
	    {
	    	$result = $this->BsForm->inputGroup('User.test', array('content' => 'Simple'), array('label' => 'Mon Label'));

			$expected = array(
				array("div" => array("class" => "form-group")),
				"label" => array("class" => "control-label col-md-3", "for" => "UserTest"),
				"Mon Label",
				"/label",
				array("div" => array("class" => "col-md-9")),
				array("div" => array("class" => "input-group")),
				array("span" => array("class" => "input-group-addon")),
				'Simple',
				'/span',
				"input" => array(
					"name" => "data[User][test]",
					"type" => "text",
					"id" => "UserTest",
					"class" => "form-control"
				),
				"/div",
				"/div",
				"/div"
			);

	    	$this->assertTags($result, $expected);
	    }

	    public function testInputGroupWithButtonFullOptions()
	    {
	    	$result = $this->BsForm->inputGroup('User.test', array('content' => 'Simple', 'type' => 'button', 'state' => 'warning', 'side' => 'right', 'class' => 'ma-class'), array('label' => 'Mon Label'));
			$expected = array(
				array("div" => array("class" => "form-group")),
				"label" => array("class" => "control-label col-md-3", "for" => "UserTest"),
				"Mon Label",
				"/label",
				array("div" => array("class" => "col-md-9")),
				array("div" => array("class" => "input-group")),
				"input" => array(
					"name" => "data[User][test]",
					"type" => "text",
					"id" => "UserTest",
					"class" => "form-control"
				),
				array("span" => array("class" => "input-group-btn")),
				"button" => array("type" => "button", "class" => "ma-class btn btn-warning"),
				"Simple",
				"/button",
				"/span",
				"/div",
				"/div",
				"/div"
			);

	    	$this->assertTags($result, $expected);
	    }

	    // NE FONCTIONNE PAS

	    public function testInputGroupWithTypeImage()
	    {
	    	$result = $this->BsForm->inputGroup('User.test', array('content' => 'Simple', 'type' => 'image', 'side' => 'right', "src" => "my-image"), array('label' => 'Mon Label'));
			$expected = array(
				array("div" => array("class" => "form-group")),
				"label" => array("class" => "control-label col-md-3", "for" => "UserTest"),
				"Mon Label",
				"/label",
				array("div" => array("class" => "col-md-9")),
				array("div" => array("class" => "input-group")),
				array("input" => array(
					"name" => "data[User][test]",
					"type" => "text",
					"id" => "UserTest",
					"class" => "form-control"
				)),
				"span" => array("class" => "input-group-btn"),
				array("input" => array("type" => "image", "class" => "btn btn-default", "src" => "my-image")),
				"/span",
				"/div",
				"/div",
				"/div"
			);

	    	$this->assertTags($result, $expected);
	    }


	    /////////////////////////////////
	    // BsFormHelper::datepicker()  //
	    /////////////////////////////////

	    // NE FONCTIONNE PAS

	    public function testDatepickerSimple()
	    {
	    	$result = $this->BsForm->datepicker('Date.test');
	    	$expected = array(
	    			array("div" => array("class" => "dp-container")),
	    			array("div" => array("class" => "form-group")),
	    			"label" => array("for" => "DateTest", "class" => "control-label col-md-3"),
	    			"Test",
	    			"/label",
	    			array("div" => array("class" => "col-md-9")),
	    			array("input" => array(
	    				"class" => "form-control", "name" => "data[Date][test]", "type" => "text"
	    			)),
	    			"/div",
	    			"/div",
	    			array("input" => array(
	    				"type" => "hidden", "name" => "data[Date][test]", "id" => "alt_dp", "class" => "form-control"
	    			)),
	    			"/div"
	    	);

	    	$this->assertTags($result, $expected);
	    }

	    // NE FONCTIONNE PAS

	    public function testDatepickerRange()
	    {
	    	$result = $this->BsForm->datepicker(array('Date.start', 'Field.end'), array('label' => 'Date'));

	    	$expected = array(
	    			array("div" => array("class" => "form-group")),
	    			"label" => array("class" => "control-label col-md-3"),
	    			"Date",
	    			"/label",
	    			array("div" => array("class" => "dp-container")),
	    			array("div" => array("class" => "col-md-9")),
	    			array("div" => array("class" => "input-daterange input-group", "id" => "datepicker")),
	    			array("input" => array(
	    				"class" => "form-control", "name" => "data[Date][start]", "type" => "text", "id" => "DateStart"
	    			)),
	    			array("input" => array(
	    				"type" => "hidden", "name" => "data[Date][start]", "id" => "alt_dp_0", "class" => "form-control"
	    			)),
	    			"span" => array("class" => "input-group-addon"),
	    			"à",
	    			"/span",
	    			array("input" => array(
	    				"class" => "form-control", "name" => "data[Date][end]", "type" => "text", "id" => "DateEnd"
	    			)),
	    			array("input" => array(
	    				"type" => "hidden", "name" => "data[Date][end]", "id" => "alt_dp_1", "class" => "form-control"
	    			)),
	    			"/div",
	    			"/div",
	    			array("input" => array(
	    				"type" => "hidden", "name" => "data[Date][test]", "id" => "alt_dp", "class" => "form-control"
	    			)),
	    			"/div",
	    			"/div",
	    			"/div",
	    			"/div"
	    	);

	    	$this->assertTags($result, $expected);
	    }

	    // NE FONCTIONNE PAS

	    public function testDatepickerSimpleScript()
	    {
	    	$result = $this->BsForm->datepicker('Date.test');

	    	$this->assertContains("format : dd/mm/yyyy", $result);
	    	$this->assertContains("language : fr", $result);
	    }

	}
