<?php
App::uses('View', 'View');
App::uses('BsHelper', 'BsHelpers.View/Helper');
App::uses('BsFormHelper', 'BsHelpers.View/Helper');

/**
 * BsHelper Test Case
 *
 */
class BsHelperTest extends CakeTestCase {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp()
	{
		parent::setUp();
		$View = new View();
		$this->Bs = new BsHelper($View);
		$this->BsForm = new BsFormHelper($View);
	}


	public function testHtml()
	{
		/////////////////////
		// WITHOUT OPTIONS //
		/////////////////////

		$result = $this->Bs->html();

		$expected = array(
			'<!DOCTYPE html',
			array('html' => array('lang' => 'fr')),
			'<head',
			array('meta' => array('charset' => 'utf-8')),
			'<title', '/title',
			array('meta' => array('name' => 'viewport', 'content' => 'width=device-width, initial-scale=1.0')),
			array('meta' => array('name' => 'description', 'content' => ''))
		);

		$this->assertTags($result, $expected);


		//////////////////
		// WITH OPTIONS //
		//////////////////

		$result = $this->Bs->html('my title', 'my description', 'en');

		$expected = array(
			'<!DOCTYPE html',
			array('html' => array('lang' => 'en')),
			'<head',
			array('meta' => array('charset' => 'utf-8')),
			'<title', 'my title', '/title',
			array('meta' => array('name' => 'viewport', 'content' => 'width=device-width, initial-scale=1.0')),
			array('meta' => array('name' => 'description', 'content' => 'my description'))
		);

		$this->assertTags($result, $expected);
	}

	public function testHtml5()
	{
		$result = $this->Bs->html5('my title', 'my description', 'en');

		// I don't know actually how to test the html comment return

		$expected = array(
			'<!DOCTYPE html',
			array('html' => array('lang' => 'en')),
			'<head',
			array('meta' => array('charset' => 'utf-8')),
			'<title', 'my title', '/title',
			array('meta' => array('name' => 'viewport', 'content' => 'width=device-width, initial-scale=1.0')),
			array('meta' => array('name' => 'description', 'content' => 'my description')),
		);

		$this->assertTags($result, $expected);
	}

	public function testBody()
	{
		///////////////////
		// WITHOUT CLASS //
		///////////////////

		$result = $this->Bs->body();

		$expected = array('/head', '<body');

		$this->assertTags($result, $expected);

		////////////////
		// WITH CLASS //
		////////////////

		$result = $this->Bs->body('classTest');

		$expected = array('/head', array('body' => array('class' => 'classTest')));

		$this->assertTags($result, $expected);
	}

	public function testEnd()
	{
		$result = $this->Bs->end();

		$expected = array('/body', '/html');

		$this->assertTags($result, $expected);
	}

	public function testCss()
	{
		////////////////
		// BASIC LOAD //
		////////////////

		$result = $this->Bs->css();

		$expected = array(
			array('link' => array('rel' => 'stylesheet', 'type' => 'text/css', 'href')),
			array('link' => array('rel' => 'stylesheet', 'type' => 'text/css', 'href')),
			array('link' => array('rel' => 'stylesheet', 'type' => 'text/css', 'href'))
		);

		$this->assertTags($result, $expected);

		//////////////
		// MORE CSS //
		//////////////

		$result = $this->Bs->css(array('myCss.css', 'myOther'));
		
		$expected = array(
			array('link' => array('rel' => 'stylesheet', 'type' => 'text/css', 'href')),
			array('link' => array('rel' => 'stylesheet', 'type' => 'text/css', 'href')),
			array('link' => array('rel' => 'stylesheet', 'type' => 'text/css', 'href')),
			array('link' => array('rel' => 'stylesheet', 'type' => 'text/css', 'href' => '/css/myCss.css')),
			array('link' => array('rel' => 'stylesheet', 'type' => 'text/css', 'href' => '/css/myOther.css'))
		);

		$this->assertTags($result, $expected);

		/////////////////////////
		// WITH DATEPICKER CSS //
		/////////////////////////

		$result = $this->Bs->css(array('myCss.css', 'myOther'));
		
		$expected = array(
			array('link' => array('rel' => 'stylesheet', 'type' => 'text/css', 'href')),
			array('link' => array('rel' => 'stylesheet', 'type' => 'text/css', 'href')),
			array('link' => array('rel' => 'stylesheet', 'type' => 'text/css', 'href')),
			array('link' => array('rel' => 'stylesheet', 'type' => 'text/css', 'href' => '/css/myCss.css')),
			array('link' => array('rel' => 'stylesheet', 'type' => 'text/css', 'href' => '/css/myOther.css'))
		);

		$this->assertTags($result, $expected);
	}

	public function testJs()
	{
		////////////////
		// BASIC LOAD //
		////////////////

		$result = $this->Bs->js();

		$expected = array(
			array('script' => array('type' => 'text/javascript', 'src')), '/script',
			array('script' => array('type' => 'text/javascript', 'src')), '/script'
		);

		$this->assertTags($result, $expected);
	}

	public function testJsDatepicker()
	{
		////////////////////////
		// WITH DATEPICKER JS //
		////////////////////////

		$this->Bs->dpLoad = true;
		$result = $this->Bs->js();

		$expected = array(
			array('script' => array('type' => 'text/javascript', 'src')), '/script',
			array('script' => array('type' => 'text/javascript', 'src')), '/script',
			array('script' => array('type' => 'text/javascript', 'src')), '/script'
		);

		$this->assertTags($result, $expected);
	}

	public function testMultipleJs(){

		/////////////
		// MORE JS //
		/////////////

		$this->Bs->ckEditorLoad = false;
		$result = $this->Bs->js(array('myJs', 'myOther'));

		$expected = array(
			array('script' => array('type' => 'text/javascript', 'src')), '/script',
			array('script' => array('type' => 'text/javascript', 'src')), '/script',
			array('script' => array('type' => 'text/javascript', 'src' => '/js/myJs.js')), '/script',
			array('script' => array('type' => 'text/javascript', 'src' => '/js/myOther.js')), '/script'
		);

		$this->assertTags($result, $expected);
	}

	public function testClose()
	{
		$result = $this->Bs->close();

		$expected = array('/div');

		$this->assertTags($result, $expected);
	}

	public function testHeader()
	{

		/////////////////////
		// WITHOUT OPTIONS //
		/////////////////////

		$result = $this->Bs->header();

		$expected = array('<header');

		$this->assertTags($result, $expected);


		//////////////////
		// WITH OPTIONS //
		//////////////////

		$result = $this->Bs->header(array('id' => 'myId', 'class' => 'classTest'));

		$expected = array(array('header' => array('id' => 'myId', 'class' => 'classTest')));

		$this->assertTags($result, $expected);
	}

	public function testCloseHeader()
	{
		$result = $this->Bs->closeHeader();

		$expected = array('/header');

		$this->assertTags($result, $expected);
	}


	public function testContainer() {

		///////////////////
		// WITHOUT CLASS //
		///////////////////

		$result = $this->Bs->container();

		$expected = array(
			array('div' => array('class' => 'container'))
		);

		$this->assertTags($result, $expected);

		////////////////
		// WITH CLASS //
		////////////////

		$result = $this->Bs->container(array('class' => 'classTest'));

		$expected = array(
			array('div' => array('class' => 'container classTest'))
		);

		$this->assertTags($result, $expected);
	}

	public function testRow() {

		///////////////////
		// WITHOUT CLASS //
		///////////////////

		$result = $this->Bs->row();

		$expected = array(
			array('div' => array('class' => 'row'))
		);

		$this->assertTags($result, $expected);

		////////////////
		// WITH CLASS //
		////////////////

		$result = $this->Bs->row(array('class' => 'classTest'));

		$expected = array(
			array('div' => array('class' => 'row classTest'))
		);

		$this->assertTags($result, $expected);
	}


	public function testCol()
	{
		$result = $this->Bs->col('xs12', 'sm3 of1', 'md2 pl2', 'lg4 ph9 of2', array('id' => 'idTest', 'class' => 'classeTest'));

		$expected = array(
			array('div' => array(
				'id' => 'idTest',
				'class' => 'col-xs-12 col-sm-3 col-sm-offset-1 col-md-2 col-md-pull-2 col-lg-4 col-lg-push-9 col-lg-offset-2 classeTest')
			)
		);

		$this->assertTags($result, $expected);

		///////////////////////
		// WITH WRONG PARAMS //
		///////////////////////

		$result = $this->Bs->col('xs12 md-3', 'sm3 or2');

		$expected = array(
			array('div' => array(
				'class' => 'col-xs-12 col-sm-3')
			)
		);

		$this->assertTags($result, $expected);
	}


	public function testTable()
	{
		$titles = array(
			array('title' => 'Cell1', 'width' => '50', 'hidden' => array('xs')),
			array('title' => 'Cell2', 'width' => '50'),
		);

		$result = $this->Bs->table($titles);

		$expected = array(
			array('div' => array('class' => 'table-responsive')),
				array('table' => array('class' => 'table')),
					'<thead',
						'<tr',
							array('th' => array('class' => 'l_50 hidden-xs')),
								'Cell1',
							'/th',
							array('th' => array('class' => 'l_50')),
								'Cell2',
							'/th',
						'/tr',
					'/thead',
					'<tbody'
		);

		$this->assertTags($result, $expected);

		//////////////////
		// WITH OPTIONS //
		//////////////////

		$titles = array(
			array('title' => 'Cell1', 'width' => '50', 'hidden' => array('xs')),
			array('title' => 'Cell2', 'width' => '50'),
		);

		$result = $this->Bs->table($titles, array('hover', 'striped'));

		$expected = array(
			array('div' => array('class' => 'table-responsive')),
				array('table' => array('class' => 'table table-hover table-striped')),
					'<thead',
						'<tr',
							array('th' => array('class' => 'l_50 hidden-xs')),
								'Cell1',
							'/th',
							array('th' => array('class' => 'l_50')),
								'Cell2',
							'/th',
						'/tr',
					'/thead',
					'<tbody'
		);

		$this->assertTags($result, $expected);
	}

	public function testCell()
	{
		$titles = array(
			array('title' => 'Cell1', 'width' => '50', 'hidden' => array('xs')),
			array('title' => 'Cell2', 'width' => '50'),
		);
		$this->Bs->table($titles);

		$result = $this->Bs->cell('Test1').
				  $this->Bs->cell('Test2');

		$this->Bs->endTable();

		$expected = array(
			'<tr',
				array('td' => array('class' => 'hidden-xs')),
					'Test1',
				'/td',
				'<td',
					'Test2',
				'/td',
			'/tr'
		);

		$this->assertTags($result, $expected);

		//////////////////
		// WITH OPTIONS //
		//////////////////

		$this->Bs->table($titles);
		$result = $this->Bs->cell('Test1', 'classTest').
				  $this->Bs->cell('Test2', '', false);
		$this->Bs->endTable();

		$expected = array(
			'<tr',
				array('td' => array('class' => 'classTest hidden-xs')),
					'Test1',
				'/td',
				'<td',
					'Test2'
		);

		$this->assertTags($result, $expected);

		$this->Bs->table($titles);
		$result = $this->Bs->cell('Test1', 'classTest', false).
				  $this->Bs->cell('Test2', '', false).
				  $this->Bs->cell('Test3', '', false);
		$this->Bs->endTable();

		$expected = array(
			'<tr',
				array('td' => array('class' => 'classTest hidden-xs')),
					'Test1',
				'<td',
					'Test2',
			'<tr',
				array('td' => array('class' => 'hidden-xs')),
					'Test3',
		);

		$this->assertTags($result, $expected);
	}

	public function testLineColor()
	{
		$titles = array(
			array('title' => 'Cell1', 'width' => '50'),
			array('title' => 'Cell2', 'width' => '50'),
		);
		$this->Bs->table($titles);

		$result = $this->Bs->lineColor('success').
				  $this->Bs->cell('Test1').
				  $this->Bs->cell('Test2').
				  $this->Bs->cell('Test3').
				  $this->Bs->cell('Test4');

		$expected = array(
			array('tr' => array('class' => 'success')),
				'<td',
					'Test1',
				'/td',
				'<td',
					'Test2',
				'/td',
			'/tr',
			'<tr',
				'<td',
					'Test3',
				'/td',
				'<td',
					'Test4',
				'/td',
			'/tr',
		);

		$this->assertTags($result, $expected);
	}

	public function testEndTable()
	{
		$result = $this->Bs->endTable();

		$expected = array(
			'/tbody',
			'/table',
			'/div'
		);

		$this->assertTags($result, $expected);
	}

	public function testAlert() {

		/////////////////
		// BASIC ALERT //
		/////////////////

		$result = $this->Bs->alert('myAlert', 'warning');

		$expected = array(
			array('div' => array('class' => 'alert alert-warning')),
				array('button' => array('type' => 'button', 'class' => 'close', 'data-dismiss' => 'alert', 'aria-hidden' => 'true')),
					'&times;',
				'/button',
				'myAlert',
			'/div'
		);

		$this->assertTags($result, $expected);

		////////////////////////
		// ALERT WITH OPTIONS //
		////////////////////////

		$result = $this->Bs->alert('myAlert', 'warning', array('id' => 'myId', 'class' => 'classTest'));

		$expected = array(
			array('div' => array('id' => 'myId', 'class' => 'alert alert-warning classTest')),
				array('button' => array('type' => 'button', 'class' => 'close', 'data-dismiss' => 'alert', 'aria-hidden' => 'true')),
					'&times;',
				'/button',
				'myAlert',
			'/div'
		);

		$this->assertTags($result, $expected);
	}

	public function testImage()
	{

		///////////////////
		// WITHOUT CLASS //
		///////////////////

		$result = $this->Bs->image('random.jpg');

		$expected = array(
			array(
				'img' => array(
					'src',
					'class' => 'img-responsive',
					'alt' => ''
				)
			)
		);

		$this->assertTags($result, $expected);

		////////////////
		// WITH CLASS //
		////////////////

		$result = $this->Bs->image('random.jpg', array('class' => 'classTest'));

		$expected = array(
			array(
				'img' => array(
					'src',
					'class' => 'img-responsive classTest',
					'alt' => ''
				)
			)
		);

		$this->assertTags($result, $expected);
	}

	public function testIcon()
	{
		$result = $this->Bs->icon('user', array('class' => 'classeTest'), array('title' => 'test'));

		$expected = array(
			array('i' => array(
				'title' => 'test',
				'class' => 'fa fa-user fa-classeTest'
				)
			),
			'/i'
		);

		$this->assertTags($result, $expected);
	}

	public function testBtn() {

		//////////////////
		// BASIC BUTTON //
		//////////////////

		$result = $this->Bs->btn('Link', array('controller' => 'pages', 'action' => 'col'));

		$expected = array(
			array('a' => array('class' => 'btn', 'href')), 'Link', '/a'
		);

		$this->assertTags($result, $expected);

		//////////////////////////////
		// BUTTON WITH MANY OPTIONS //
		//////////////////////////////

		$result = $this->Bs->btn('Link', array('controller' => 'pages', 'action' => 'col'), array('type' => 'primary', 'size' => 'lg', 'class' => 'classTest', 'tag' => 'button'));

		$expected = array(
			array('button' => array('class' => 'btn btn-primary btn-lg classTest')), 'Link', '/button'
		);

		$this->assertTags($result, $expected);
	}


	public function testModal()
	{

		/////////////////
		// BASIC MODAL //
		/////////////////

		$result = $this->Bs->modal('Modal title', 'Modal content');

		$expected = array(
			array('button' => array('class' => 'btn btn-primary btn-lg', 'data-target', 'data-toggle' => 'modal')), 'Voir', '/button',
			array('div' => array('class' => 'modal fade ', 'id', 'tabindex', 'role', 'aria-labelledby', 'aria-hidden')),
				array('div' => array('class' => 'modal-dialog')),
					array('div' => array('class' => 'modal-content')),
						array('div' => array('class' => 'modal-header')),
							array('button' => array('type', 'class' => 'close', 'data-dismiss' => 'modal', 'aria-hidden' => 'true')), '&times;', '/button',
							array('h4' => array('class' => 'modal-title', 'id')), 'Modal title', '/h4',
						'/div',
						array('div' => array('class' => 'modal-body')),
							'<p',
								'Modal content',
							'/p',
						'/div',
					'/div',
				'/div',
			'/div'
		);

		$this->assertTags($result, $expected);


		//////////////////
		// MORE OPTIONS //
		//////////////////

		$options = array(
			'id' => 'myId',
			'class' => 'classTest'
		);

		$result = $this->Bs->modal('Modal title', 'Modal content', $options);

		$expected = array(
			array('button' => array('class' => 'btn btn-primary btn-lg', 'data-target' => '#myId', 'data-toggle' => 'modal')), 'Voir', '/button',
			array('div' => array('class' => 'modal fade classTest', 'id' => 'myId', 'tabindex', 'role', 'aria-labelledby', 'aria-hidden')),
				array('div' => array('class' => 'modal-dialog')),
					array('div' => array('class' => 'modal-content')),
						array('div' => array('class' => 'modal-header')),
							array('button' => array('type', 'class' => 'close', 'data-dismiss' => 'modal', 'aria-hidden' => 'true')), '&times;', '/button',
							array('h4' => array('class' => 'modal-title', 'id')), 'Modal title', '/h4',
						'/div',
						array('div' => array('class' => 'modal-body')),
							'<p',
								'Modal content',
							'/p',
						'/div',
					'/div',
				'/div',
			'/div'
		);

		$this->assertTags($result, $expected);


		////////////////
		// MODAL FORM //
		////////////////

		$options = array(
			'id' => 'myId',
			'class' => 'classTest',
			'form' => true
		);

		$body = $this->BsForm->create('myModel' , array('action' => 'myAction'));
		$body .= $this->BsForm->input('myField');
		$body .= $this->BsForm->submit('Send');
		$body .= $this->BsForm->end();

		$result = $this->Bs->modal('Modal title', $body, $options);

		$expected = array(
			array('button' => array('class' => 'btn btn-primary btn-lg', 'data-target' => '#myId', 'data-toggle' => 'modal')), 'Voir', '/button',
			array('div' => array('class' => 'modal fade classTest', 'id' => 'myId', 'tabindex', 'role', 'aria-labelledby', 'aria-hidden')),
				array('div' => array('class' => 'modal-dialog')),
					array('div' => array('class' => 'modal-content')),
						array('form' => array('action' => '/my_models/myAction', 'role' => 'form', 'class' => 'form-horizontal', 'id', 'method' => 'post', 'accept-charset')),
							array('div' => array('class' => 'modal-header')),
								array('button' => array('type', 'class' => 'close', 'data-dismiss' => 'modal', 'aria-hidden' => 'true')), '&times;', '/button',
								array('h4' => array('class' => 'modal-title', 'id')), 'Modal title', '/h4',
							'/div',
							array('div' => array('class' => 'modal-body')),
								array('div' => array('style' => 'display:none;')),
									array('input' => array('type' => 'hidden', 'name', 'value')),
								'/div',
								array('div' => array('class' => 'form-group')),
									array('label' => array('for', 'class' => 'control-label col-md-3')), 'My Field' ,'/label',
									array('div' => array('class' => 'col-md-9')),
										array('input' => array('name', 'class' => 'form-control', 'type', 'id')),
									'/div',
								'/div',
								array('div' => array('class' => 'form-group')),
									array('div' => array('class' => 'col-md-9 col-md-offset-3')),
										array('input' => array('value' => 'Send', 'class' => 'btn btn-success', 'type')),
										array('i' => array('class' => 'fa fa-spinner fa-spin form-submit-wait text-success')),
										'/i',
										'<script',
											'$("#MyModelMyActionForm").submit(function(){$("#MyModelMyActionForm input[type=\'submit\']").prop("disabled" , true);$("#MyModelMyActionForm .form-submit-wait").show();});',
										'/script',
									'/div',
								'/div',
							'/div',
						'/form',
					'/div',
				'/div',
			'/div'
		);

	
		$this->assertTags($result, $expected);

		///////////////////////////////
		// MODAL WITH CUSTOM BUTTONS //
		///////////////////////////////

		$buttons = array(
			'open' => 'Open'
		);
		$result = $this->Bs->modal('Modal title', 'Modal content', array(), $buttons);

		$expected = array(
			array('button' => array('class' => 'btn btn-primary btn-lg', 'data-target', 'data-toggle' => 'modal')), 'Open', '/button',
			array('div' => array('class' => 'modal fade ', 'id', 'tabindex', 'role', 'aria-labelledby', 'aria-hidden')),
				array('div' => array('class' => 'modal-dialog')),
					array('div' => array('class' => 'modal-content')),
						array('div' => array('class' => 'modal-header')),
							array('button' => array('type', 'class' => 'close', 'data-dismiss' => 'modal', 'aria-hidden' => 'true')), '&times;', '/button',
							array('h4' => array('class' => 'modal-title', 'id')), 'Modal title', '/h4',
						'/div',
						array('div' => array('class' => 'modal-body')),
							'<p',
								'Modal content',
							'/p',
						'/div',
					'/div',
				'/div',
			'/div'
		);

		$this->assertTags($result, $expected);

		$buttons = array(
			'open' => array('button' => false, 'name' => 'users'),
			'close' => 'Close'
		);
		$result = $this->Bs->modal('Modal title', 'Modal content', array(), $buttons);

		$expected = array(
			array('i' => array('class' => 'fa fa-users fa-open-modal', 'data-target', 'data-toggle' => 'modal')), '/i',
			array('div' => array('class' => 'modal fade ', 'id', 'tabindex', 'role', 'aria-labelledby', 'aria-hidden')),
				array('div' => array('class' => 'modal-dialog')),
					array('div' => array('class' => 'modal-content')),
						array('div' => array('class' => 'modal-header')),
							array('button' => array('type', 'class' => 'close', 'data-dismiss' => 'modal', 'aria-hidden' => 'true')), '&times;', '/button',
							array('h4' => array('class' => 'modal-title', 'id')), 'Modal title', '/h4',
						'/div',
						array('div' => array('class' => 'modal-body')),
							'<p',
								'Modal content',
							'/p',
						'/div',
						array('div' => array('class' => 'modal-footer')),
							array('button' => array('class' => 'btn btn-link', 'data-dismiss' => 'modal')),
								'Close',
							'/button',
						'/div',
					'/div',
				'/div',
			'/div'
		);

		$this->assertTags($result, $expected);

		$buttons = array(
			'close' => array('name' => 'Close', 'class' => 'closeClass'),
			'confirm'
		);

		$result = $this->Bs->modal('Modal title', 'Modal content', array(), $buttons);

		$expected = array(
			array('button' => array('class' => 'btn btn-primary btn-lg', 'data-target', 'data-toggle' => 'modal')), 'Voir', '/button',
			array('div' => array('class' => 'modal fade ', 'id', 'tabindex', 'role', 'aria-labelledby', 'aria-hidden')),
				array('div' => array('class' => 'modal-dialog')),
					array('div' => array('class' => 'modal-content')),
						array('div' => array('class' => 'modal-header')),
							array('button' => array('type', 'class' => 'close', 'data-dismiss' => 'modal', 'aria-hidden' => 'true')), '&times;', '/button',
							array('h4' => array('class' => 'modal-title', 'id')), 'Modal title', '/h4',
						'/div',
						array('div' => array('class' => 'modal-body')),
							'<p',
								'Modal content',
							'/p',
						'/div',
						array('div' => array('class' => 'modal-footer')),
							array('button' => array('class' => 'btn closeClass', 'data-dismiss' => 'modal')),
								'Close',
							'/button',
							array('button' => array('class' => 'btn btn-button btn-success')),
								'Confirmer',
							'/button',
						'/div',
					'/div',
				'/div',
			'/div'
		);

		$this->assertTags($result, $expected);

		//////////////////////////////////////
		// SPECIAL CASE : FORM WITH CONFIRM //
		//////////////////////////////////////

		$options = array(
			'form' => true
		);
		$buttons = array(
			'confirm' => array('name' => 'Confirm', 'class' => 'confirmClass')
		);

		$body = $this->BsForm->create('myModel' , array('action' => 'myAction'));
		$body .= $this->BsForm->input('myField');
		$body .= $this->BsForm->end();

		$result = $this->Bs->modal('Modal title', $body, $options, $buttons);

		$expected = array(
			array('button' => array('class' => 'btn btn-primary btn-lg', 'data-target', 'data-toggle' => 'modal')), 'Voir', '/button',
			array('div' => array('class' => 'modal fade ', 'id', 'tabindex', 'role', 'aria-labelledby', 'aria-hidden')),
				array('div' => array('class' => 'modal-dialog')),
					array('div' => array('class' => 'modal-content')),
						array('form' => array('action' => '/my_models/myAction', 'role' => 'form', 'class' => 'form-horizontal', 'id', 'method' => 'post', 'accept-charset')),
							array('div' => array('class' => 'modal-header')),
								array('button' => array('type', 'class' => 'close', 'data-dismiss' => 'modal', 'aria-hidden' => 'true')), '&times;', '/button',
								array('h4' => array('class' => 'modal-title', 'id')), 'Modal title', '/h4',
							'/div',
							array('div' => array('class' => 'modal-body')),
								array('div' => array('style' => 'display:none;')),
									array('input' => array('type' => 'hidden', 'name', 'value')),
								'/div',
								array('div' => array('class' => 'form-group')),
									array('label' => array('for', 'class' => 'control-label col-md-3')), 'My Field' ,'/label',
									array('div' => array('class' => 'col-md-9')),
										array('input' => array('name', 'class' => 'form-control', 'type', 'id')),
									'/div',
								'/div',
							'/div',
							array('div' => array('class' => 'modal-footer')),
								array('button' => array('class' => 'btn btn-submit confirmClass')),
									'Confirm',
								'/button',
							'/div',
						'/form',
					'/div',
				'/div',
			'/div'
		);

		$this->assertTags($result, $expected);	
	}

	public function testConfirm()
	{

		///////////////////
		// BASIC CONFIRM //
		///////////////////

		$result = $this->Bs->confirm('Link', array('controller' => 'pages', 'action' => 'col'));

		$expected = array(
		 array('button' => array('class' => 'btn btn-success', 'data-target', 'data-toggle' => 'modal')), 'Link', '/button',
		 array('div' => array('class' => 'modal fade ', 'id', 'tabindex', 'role', 'aria-labelledby', 'aria-hidden')),
			 array('div' => array('class' => 'modal-dialog')),
				 array('div' => array('class' => 'modal-content')),
					 array('div' => array('class' => 'modal-header')),
						 array('button' => array('type', 'class' => 'close', 'data-dismiss' => 'modal', 'aria-hidden' => 'true')), '&times;', '/button',
						 array('h4' => array('class' => 'modal-title', 'id')), 'Link', '/h4',
					 '/div',
					 array('div' => array('class' => 'modal-body')),
						 '<p',
							 'Voulez-vous vraiment continuer votre action ?',
						 '/p',
					 '/div',
					 array('div' => array('class' => 'modal-footer')),
						 array('button' => array('class' => 'btn btn-link', 'data-dismiss' => 'modal')), 'Fermer', '/button',
						 array('a' => array('href', 'class' => 'btn btn-success')), 'Link', '/a',
					 '/div',
				 '/div',
			 '/div',
		 '/div'
		);

		$this->assertTags($result, $expected);


		//////////////////////////////////
		// CONFIRM WITH LOTS OF OPTIONS //
		//////////////////////////////////


		$options = array(
		 'color' => 'primary',
		 'texte' => 'my text',
		 'button' => 'Send',
		 'header' => 'Confirm action'
		);

		$result = $this->Bs->confirm('Link', array('controller' => 'pages', 'action' => 'col'), $options);

		$expected = array(
		 array('button' => array('class' => 'btn btn-primary', 'data-target', 'data-toggle' => 'modal')), 'Link', '/button',
		 array('div' => array('class' => 'modal fade ', 'id', 'tabindex', 'role', 'aria-labelledby', 'aria-hidden')),
			 array('div' => array('class' => 'modal-dialog')),
				 array('div' => array('class' => 'modal-content')),
					 array('div' => array('class' => 'modal-header')),
						 array('button' => array('type', 'class' => 'close', 'data-dismiss' => 'modal', 'aria-hidden' => 'true')), '&times;', '/button',
						 array('h4' => array('class' => 'modal-title', 'id')), 'Confirm action', '/h4',
					 '/div',
					 array('div' => array('class' => 'modal-body')),
						 '<p',
							 'my text',
						 '/p',
					 '/div',
					 array('div' => array('class' => 'modal-footer')),
						 array('button' => array('class' => 'btn btn-link', 'data-dismiss' => 'modal')), 'Fermer', '/button',
						 array('a' => array('href', 'class' => 'btn btn-primary')), 'Send', '/a',
					 '/div',
				 '/div',
			 '/div',
		 '/div'
		);

		$this->assertTags($result, $expected);
	}


/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Bs);

		parent::tearDown();
	}

}
