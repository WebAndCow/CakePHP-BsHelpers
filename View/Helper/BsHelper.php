<?php

App::uses('HtmlHelper', 'View/Helper');
App::uses('Inflector', 'Utility');

/**
 *
 * Helper CakePHP to create Twitter Bootstrap elements
 * @author AWL
 *
 */
class BsHelper extends AppHelper {

/**
 * Bs uses the HtmlHelper
 *
 * @var array
 */
	public $helpers = array('Html');


/**
 * The name of the helper
 *
 * @var string
 */
	public $name = 'Bs';

				/*--------------------------*
				*						    *
				*			CONFIG          *
				*					        *
				*--------------------------*/

/**
 * Path for Bootstrap CSS
 *
 * @var string
 */
	public $pathCSS = '//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css';

/**
 * Path for Font Awesome
 *
 * @var string
 */
	public $faPath = '//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css';

/**
 * Path for Bootstrap addon
 *
 * @var string
 */
	public $bsAddonPath = 'BsHelpers.bs_addon';

/**
 * Path for CSS datapicker bootstrap
 *
 * @var string
 */
	public $dpCssPath = 'BsHelpers.datepicker';

/**
 * Path for JS CkEditor
 *
 * @var string
 */
	public $ckEditorJsPath = 'BsHelpers./vendor/ckeditor/ckeditor/ckeditor';

/**
 * If CkEditor is loaded
 *
 * @var bool
 */
	public $ckEditorLoad = true;

/**
 * If Font Awesome is loaded
 * @var bool
 */
	public $faLoad = true;

/**
 * If Bootstrap addon is loaded
 * @var bool
 */
	public $bsAddonLoad = true;

/**
 * If Datepicker Bootrstrap is loaded
 * @var bool
 */
	public $dpLoad = false;

/**
 * Prefix version for Font Awesome
 * @var bool
 */
	public $faPrefix = 'fa';

/**
 * Path for JS bootstrap
 *
 * @var string
 */
	public $pathJS = '//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js';

/**
 * Path for JQuery
 *
 * @var string
 */
	public $pathJquery = 'http://code.jquery.com/jquery-1.11.1.min.js';

/**
 * Path for JS datapicker bootstrap
 *
 * @var string
 */
	public $dpJsPath = 'BsHelpers.datepicker';

				/*--------------------------*
				*						    *
				*			LAYOUT          *
				*					        *
				*--------------------------*/

/**
 * Initialize an HTML document and the head
 *
 * @param string $titre The name of the current page
 * @param string $description The description of the current page
 * @param string $lang The language of the current page. By default 'fr' because we are french
 * @return string
 */
	public function html($titre = '', $description = '', $lang = 'fr') {
		$out = '<!DOCTYPE html>';
		$out .= '<html lang="' . $lang . '">';
		$out .= '<head>';
		$out .= '<meta charset="utf-8">';
		$out .= '<title>' . $titre . '</title>';
		$out .= '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
		$out .= '<meta name="description" content="' . $description . '">';

		return $out;
	}

/**
 * Initialize an HTML 5 document and the head
 *
 * @param string $titre The name of the current page
 * @param string $description The description of the current page
 * @param string $lang The language of the current page. By default 'fr' because we are french
 * @return string
 */
	public function html5($titre = '', $description = '', $lang = 'fr') {
		$out = $this->html($titre, $description, $lang);

		// Script JS for IE and HTML 5
		$out .= '<!--[if lt IE 9]>';
		$out .= '<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>';
		$out .= '<![endif]-->';

		return $out;
	}

/**
 * Close the head element and initialize the body element
 * 
 * @param string $classBody Class for the body element
 * @return string
 */
	public function body($classBody = '') {
		$out = '</head>';
		$out .= ($classBody != '') ? '<body class="' . $classBody . '">' : '<body>';
		return $out;
	}

/**
 * Close the body element and the html element
 *
 * @return string
 */
	public function end() {
		$out = '</body>';
		$out .= '</html>';

		return $out;
	}

/**
 * Load CSS for the current page
 *
 * @param array $path Names of CSS for the current page
 * @param array $options Options for the css element
 * @return string A link tag for the head element
 */
	public function css($path = array(), $options = array()) {
		$out = $this->Html->css($this->pathCSS);
		if ($this->faLoad) {
			$out .= $this->Html->css($this->faPath);
		}
		if ($this->bsAddonLoad) {
			$out .= $this->Html->css($this->bsAddonPath);
		}
		if ($this->dpLoad) {
			$out .= $this->Html->css($this->dpCssPath);
		}

		// Others CSS
		foreach ($path as $css) {
			$out .= $this->Html->css($css, $options);
		}

		return $out;
	}



/**
 * Load JS for the current page
 *
 * @param array $arrayJs Names of JS for the current page
 * @return string A script tag for the head element
 */
	public function js($arrayJs = array()) {
		$out = $this->Html->script($this->pathJquery);
		$out .= $this->Html->script($this->pathJS);
		if ($this->dpLoad) {
			$out .= $this->Html->script($this->dpJsPath);
		}

		// CkEditor JS
		if($this->ckEditorLoad) {
			$out .= $this->Html->script($this->ckEditorJsPath);
		}

		// Others JS
		foreach ($arrayJs as $js) {
			$out .= $this->Html->script($js);
		}

		return $out;
	}

/**
 * Close div elements
 *
 * @param int $nb Number of div you want to close
 * @return string End tags div
 */
	public function close($nb = 1) {
		$out = '';
		for ($i = 0; $i < $nb; $i++) {
			$out .= '</div>';
		}
		return $out;
	}

/**
 * Open a header element
 *
 * @param array $options Options of the header element
 * @return string Tag header
 */
	public function header($options = array()) {
		$out = $this->Html->tag('header', null, $options);
		return $out;
	}

/**
 * Close the header element
 *
 * @return string End tag header
 */
	public function closeHeader() {
		return '</header>';
	}


/**
 * Change the value of ckEditorLoad
 *
 * In a layout, this function must be called before the js function
 *
 * @param bool $load
 * @return void
 */
	public function setCkEditorLoad($load = true) {
		$this->ckEditorLoad = $load;
	}


				/*--------------------------*
				*						    *
				*			GRID            *
				*					        *
				*--------------------------*/

/**
 * Open a Bootstrap container
 *
 * @param array $options Options of the div element
 * @return string Div element with the class 'container'
 */
	public function container($options = array()) {
		$out = '';
		$class = 'container';
		if (isset($options['class'])) {
			$class .= ' ' . $options['class'];
		}
		$out .= $this->Html->div($class, null, $options);
		return $out;
	}

/**
 * Open a Bootstrap row
 *
 * @param array $options Options of the div element
 * @return string Div element with the class 'row'
 */
	public function row($options = array()) {
		$out = '';
		$class = 'row';
		if (isset($options['class'])) {
			$class .= ' ' . $options['class'];
		}
		$out .= $this->Html->div($class, null, $options);
		return $out;
	}

/**
 * Create a <div class="col"> element.
 *
 * Differents layouts with options.
 *
 * ### Construction
 *
 * $this->Bs->col('xs3 of1 ph9', 'md3');
 *
 * It means : - For XS layout, a column size of 3, offset of 1 and push of 9.
 *			  - For MD layout, a column size of 3.
 *
 * You can give all parameters you want before $attributes. The rule of params is :
 *
 * 'LAYOUT+SIZE OPTIONS+SIZE'
 *
 * LAYOUT -> not obligatory for the first param ('xs' by default) .
 * SIZE -> size of the column in a grid of 12 columns.
 * OPTIONS -> Not obligatory. Offset, push or pull. Called like this : 'of', 'ph' or 'pl'.
 * SIZE -> size of the option.
 *
 *
 * ### Attributes
 *
 * Same options that HtmlHelper::div();
 *
 * @return string DIV tag element
 */
	public function col() {
		$class = '';
		$devices = array();
		$attributes = array();

		$args = func_get_args();
		foreach ($args as $arg) {
			if (!is_array($arg)) {
				$devices[] = $arg;
			} else {
				$attributes = $arg;
			}
		}

		$arrayDevice = array('xs', 'sm', 'md', 'lg');
		$arrayOptions = array('of', 'ph', 'pl');

		foreach ($devices as $device) {
			$ecran = null;
			$taille = null;
			$opt = null;
			$replace = array('(', ')', '-', '_', '/', '\\', ';', ',', ':', ' ');
			$device = str_replace($replace, '.', $device);
			$device = explode('.', $device);

			// Sould define the device in first
			foreach ($device as $elem) {
				if (!$ecran) {
					$nom = substr($elem, 0, 2);
					if (in_array($nom, $arrayDevice)) {
						$ecran = $nom;
						$taille = substr($elem, 2);
					}
				} else {
					if ($opt) {
						$opt .= ' ' . $this->__optCol($elem, $ecran);
					} else {
						$opt = $this->__optCol($elem, $ecran);
					}
				}
			}
			if (isset($ecran) && $taille) {
				if ($opt) {
					$class .= 'col-' . $ecran . '-' . $taille . ' ' . $opt . ' ';
				} else {
					$class .= 'col-' . $ecran . '-' . $taille . ' ';
				}
			}
		}
		$class = substr($class, 0, - 1);
		if (isset($attributes['class'])) {
			$class .= ' ' . $attributes['class'];
		}
		$out = $this->Html->div($class, null, $attributes);
		return $out;
	}

/**
 * Complementary function with BsHelper::col()
 *
 * Add the correct class for the option in parameter
 *
 * @param array $elem // class apply on the col element {PARAMETRE OBLIGATOIRE}
 * @param string $screen // layout {PARAMETRE OBLIGATOIRE}
 * @return string The class corresponding to the option
 */
	private function __optCol($elem, $screen) {
		$attr = substr($elem, 0, 2);
		$size = substr($elem, 2);
		$res = null;
		if (is_integer($size) || !($size == 0 && $screen == 'sm')) {
			switch ($attr) {
				case 'pl':
					$res = 'col-' . $screen . '-pull-' . $size;
					break;

				case 'ph':
					$res = 'col-' . $screen . '-push-' . $size;
					break;

				case 'of':
					$res = 'col-' . $screen . '-offset-' . $size;
					break;
				default:
					$res = null;
					break;
			}
		}
		return $res;
	}

				/*--------------------------*
				*						    *
				*			TABLES          *
				*					        *
				*--------------------------*/

/**
 * Number of column
 *
 * @var int
 */
	protected $_nbColumn = 0;

/**
 * Visibility of cells
 *
 * @var array
 */
	protected $_tableClassesCells = array();

/**
 * Position of the cell
 *
 * @var int
 */
	protected $_cellPos = 0;

/**
 * To know if a line is open or not
 *
 * @var bool
 */
	protected $_openLine = 0;

/**
 * Initialize the table with the head and the body element.
 * 
 * @param array $titles 'title' => title of the cell
 * 'width' => width in percent of the cell
 * 'hidden' => layout
 * @param array $class classes of the table (hover, striped, etc)
 * @return string
 */
	public function table($titles, $class = array()) {
		$classes = '';
		$out = '<div class="table-responsive">';

		if (!empty($class)) {
			foreach ($class as $opt) {
				$classes .= ' table-' . $opt;
			}
		}

		$out .= '<table class="table' . $classes . '">';

		if ($titles != null) {

			$out .= '<thead>';
			$out .= '<tr>';

			$tableClassesCells = array();
			$tablePos = 0;
			$nbColumn = count($titles);
			$width = false;

			foreach ($titles as $title) {
				$classVisibility = '';
				if (isset($title['hidden'])) {
					foreach ($title['hidden'] as $h) {
						$classVisibility .= ($classVisibility != '') ? ' ' : '';
						$classVisibility .= 'hidden-' . $h;
					}
				}
				$tableClassesCells[$tablePos] = $classVisibility;

				$out .= '<th class="';
				if (isset($title['width'])) {
					$out .= 'l_' . $title['width'];
					if (!$width) {
						$width = true;
					}
				}
				$out .= ($classVisibility != '') ? ' ' : '';
				$out .= $classVisibility . '">' . $title['title'] . '</th>';
				$tablePos ++;
			}

			$out .= '</tr>';
			$out .= '</thead>';
			$out .= '<tbody>';

			$this->_nbColumn = $nbColumn - 1;
			$this->_tableClassesCells = $tableClassesCells;
			$this->_cellPos = 0;
			$this->_openLine = 0;
		}
		return $out;
	}

/**
 * Create a cell (<td>)
 * 
 * @param string $content Informations in the cell
 * @param string $class Classe(s) of the cell
 * @param bool $autoformat Close or not the cell when it is the last of the line
 * @return string
 */
	public function cell($content, $class = '', $autoformat = true) {
		$out = '';
		$classVisibility = '';
		$cellPos = $this->_cellPos;

		if ($cellPos == 0 && $this->_openLine == 0) {
			$out .= '<tr>';
		}

		$this->_openLine = 0;

		if ($this->_tableClassesCells[$cellPos]) {
			$classVisibility = $this->_tableClassesCells[$cellPos];
		}

		if ($classVisibility != '' || $class != '') {
			$out .= '<td class="' . $class;
			$out .= ($class != '') ? ' ' : '';
			$out .= $classVisibility . '">';
		} else {
			$out .= '<td>';
		}

		$out .= $content;

		if ($autoformat) {

			$out .= '</td>';

			if ($cellPos == $this->_nbColumn) {
				$out .= '</tr>';
				$this->_cellPos = 0;
			} else {
				$this->_cellPos = $cellPos + 1;
			}
		} else {
				if ($cellPos == $this->_nbColumn) {
					$this->_cellPos = 0;
				} else {
					$this->_cellPos = $cellPos + 1;
				}
		}
		return $out;
	}

/**
 * Color a line (<tr>)
 * 
 * @param string $color Colorof the line (active, warning, danger or success)
 * @return string
 */
	public function lineColor($color) {
		$out = '<tr class="' . $color . '">';
		$this->_openLine = 1;
		return $out;
	}

/**
 * Close the table
 * 
 * @return string
 */
	public function endTable() {
		$out = '</tbody>';
		$out .= '</table>';
		$out .= '</div>';
		return $out;
	}

				/*--------------------------*
				*						    *
				*			OTHERS          *
				*					        *
				*--------------------------*/

/**
 * Create a bootstrap alert element.
 *
 * @param string $text    Alert content
 * @param string $state   Bootstrap state
 * @param array  $options HTML attributes
 *
 * @return string
 */
	public function alert($text, $state, $options = array()) {
		if (!isset($options['class'])) {
			$options['class'] = 'alert alert-' . $state;
		} else {
			$options['class'] = 'alert alert-' . $state . ' ' . $options['class'];
		}
		if (!isset($options['dismiss']) || $options['dismiss'] == 'true') {
			$dismiss = '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
		}
		unset($options['dismiss']);
		$out = '<div ';
		foreach ($options as $key => $value) {
			$out .= ' ' . $key . '="' . $value . '"';
		}
		$out .= '>';
		if (isset($dismiss)) {
			$out .= $dismiss;
		}
		$out .= $text;
		$out .= '</div>';
		return $out;
	}

/**
 * Picture responsive
 *
 * Extends from HtmlHelper:image()
 *
 * @param string $path Path to the image file, relative to the app/webroot/img/ directory.
 * @param array $options Array of HTML attributes. See above for special options.
 * @return string End tag header
 */
	public function image($path, $options = array()) {
		if (isset($options['class'])) {
			$options['class'] = 'img-responsive ' . $options['class'];
		} else {
			$options['class'] = 'img-responsive';
		}
		return $this->Html->image($path, $options);
	}

/**
 * Create a Font Awesome Icon
 *
 * @param string $iconLabel label of the icon
 * @param array $classes like 'fixed-width', 'large', '2x', etc.
 * @param array $attributes more attributes for the tag
 * @return string
 */
	public function icon($iconLabel, $classes = array(), $attributes = array()) {
		$class = '';
		$more = '';

		if (!empty($classes)) {
			foreach ($classes as $opt) {
				$class .= ' ' . $this->faPrefix . '-' . $opt;
			}
		}

		if (!empty($attributes)) {
			foreach ($attributes as $key => $attr) {
				$more .= ' ' . $key . '="' . $attr . '"';
			}
		}
		return '<i class="' . $this->faPrefix . ' ' . $this->faPrefix . '-' . $iconLabel . $class . '"' . $more . '></i>';
	}

/**
 * Create a Bootstrap Button or Link
 *
 * @param string $text text in the button
 * @param string $url url of the link
 * @param array $options 'size' => lg, sm or xs, to change the size of the button
 *						 'type' => primary, success, etc, to change the color
 *						 'tag' => to change the tag
 *						 and more... (like 'class')
 * @param array $confirmMessage to add a confirm pop-up
 * @return string
 */
	public function btn($text, $url = array(), $options = array(), $confirmMessage = false) {
		$tag = 'a';
		if (!empty($options['tag'])) {
			$tag = $options['tag'];
		}

		$class = 'btn';
		$class .= (!empty($options['type'])) ? ' btn-' . $options['type'] : '';
		$class .= (!empty($options['size'])) ? ' btn-' . $options['size'] : '';
		$class .= (isset($options['class'])) ? ' ' . $options['class'] : '';
		$options['class'] = $class;

		if ($tag != 'a') {
			unset($options['tag']);
			unset($options['type']);
			unset($options['size']);
		}

		if ($tag != 'a') {
			return $this->Html->tag($tag, $text, $options);
		} else {
			return $this->Html->link($text, $url, $options, $confirmMessage);
		}
	}

/**
 * Create a Bootstrap Modal.
 * 
 * @param string $header The text in the header
 * @param string $body The content of the body
 * @param array $options Used to add custom ID, class or a form into the modal
 * @param array $buttons Informations about open, close and confirm buttons
 * @return string Bootstrap modal
 */
	public function modal($header, $body, $options = array(), $buttons = array()) {
		$classes = (isset($options['class'])) ? $options['class'] : '';
		// Is it a form ?
		$form = (isset($options['form']) && $options['form'] == true) ? true : false;
		// If it's a form then there is a submit button
		$type = ($form) ? 'submit' : 'button';

		// Generate a random id if it doesn't exist
		if (isset($options['id']) && $options['id'] != '') {
			$id = $options['id'];
		} else {
			$cle1 = "zarnfjdlvjezprizejrjpzojazjpodffp";
			$cle2 = "251848416487764197191944948794449";
			$cle = '';
			for ($i = 0; $i < 15; $i++) {
				$tab = array($cle1, $cle2);
				if ($i == 0) {
					$cle .= $cle1[rand(0, strlen($cle1) - 1)];
				} else {
					$t = $tab[rand(0, 1)];
					$cle .= $t[rand(0, strlen($t) - 1)];
				}
			}
			$id = $cle;
		}

		// Create the open button
		if (!empty($buttons)) {
			if (isset($buttons['open']) && $buttons['open'] != '') {
				if (is_array(($buttons['open']))) {
					// Create a simple font-awesome icon instead of a button
					if (isset($buttons['open']['button']) && $buttons['open']['button'] === false) {
						$out = $this->icon($buttons['open']['name'], array('open-modal'), array('data-toggle' => 'modal', 'data-target' => '#' . $id));
					} else {
						$out = $this->btn(__($buttons['open']['name']), null, array('tag' => 'button', 'class' => $buttons['open']['class'], 'data-toggle' => 'modal', 'data-target' => '#' . $id));
					}
				} else {
					$out = $this->btn(__($buttons['open']), null, array('tag' => 'button', 'class' => 'btn-primary btn-lg', 'data-toggle' => 'modal', 'data-target' => '#' . $id));
				}
			} else {
				$out = $this->btn(__('Voir'), null, array('tag' => 'button', 'class' => 'btn-primary btn-lg', 'data-toggle' => 'modal', 'data-target' => '#' . $id));
			}
		} else {
			$out = $this->btn(__('Voir'), null, array('tag' => 'button', 'class' => 'btn-primary btn-lg', 'data-toggle' => 'modal', 'data-target' => '#' . $id));
		}

		// Modal
		$out .= '<div class="modal fade ' . $classes . '" id="' . $id . '" tabindex="-1" role="dialog" aria-labelledby="' . $id . 'Label" aria-hidden="true">';
		$out .= '<div class="modal-dialog">';

		// Content
		$out .= '<div class="modal-content">';

		if ($form) {
			$close = strpos($body, '>');
			$out .= substr($body, strpos($body, '<form'), $close + 1);
			$body = substr($body, $close + 1, strpos($body, '</form>') - ($close + 1));
		}

		// Header
		$out .= '<div class="modal-header">';
		$out .= '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
		$out .= '<h4 class="modal-title" id="' . $id . 'Label">' . $header . '</h4>';
		$out .= '</div>';
		// End header

		// Body
		$out .= '<div class="modal-body">';
		// if the body dont begin by a html tag
		$out .= (strpos($body, '<') !== 0 ) ? '<p>' . $body . '</p>' : $body;
		$out .= '</div>';
		// End body

		// Footer
		$outFooter = '';
		if (!empty($buttons)) {
			if (isset($buttons['close'])) {

				// If the value of 'close' is an array (like 'close' => array('name' => 'Close') )
				if (is_array(($buttons['close']))) {
					$outFooter .= $this->btn(__($buttons['close']['name']), null, array('tag' => 'button', 'class' => $buttons['close']['class'], 'data-dismiss' => 'modal'));
				} else {
					$outFooter .= $this->btn(__($buttons['close']), null, array('tag' => 'button', 'class' => 'btn-link', 'data-dismiss' => 'modal'));
				}

				// If 'close' index exist => create the button
			} elseif (in_array('close', $buttons)) {
				$outFooter .= $this->btn(__('Fermer'), null, array('tag' => 'button', 'class' => 'btn-link', 'data-dismiss' => 'modal'));
			}
			if (isset($buttons['confirm'])) {

				// Check if it's a form
				if ($form) {
					$class = (isset($buttons['confirm']['class'])) ? $buttons['confirm']['class'] : 'btn-success';
					$outFooter .= $this->btn(__($buttons['confirm']['name']), null, array('tag' => 'button', 'class' => $class, 'type' => $type));
				} else {
					$class = (isset($buttons['confirm']['class'])) ? $buttons['confirm']['class'] : 'btn-success';
					$outFooter .= $this->btn(__($buttons['confirm']['name']), $buttons['confirm']['link'], array('class' => $class));
				}

				// If 'confirm' index exist => create the button
			} elseif (in_array('confirm', $buttons)) {
				$outFooter .= $this->btn(__('Confirmer'), null, array('tag' => 'button', 'class' => 'btn-success', 'type' => $type));
			}

			if ($outFooter != '') {
				$out .= '<div class="modal-footer">';
				$out .= $outFooter;
				$out .= '</div>';
			}
		}
		$out .= ($form) ? '</form>' : '';
		// End footer

		$out .= '</div>';
		// End Content

		$out .= '</div>';
		$out .= '</div>';

		return $out;
	}

/**
 * Create a button with a confirm like a Bootstrap Modal
 * 
 * @param string $button the name of the button, the header and the confirm button in the modal
 * @param string $link the link to redirect after the confirm
 * @param array $options Options for the confirm (button, texte, header, color)
 * @return string
 */
	public function confirm($button, $link, $options = array()) {
		$buttons = array(
			'open' => array(
				'name' => $button
			),
			'close',
			'confirm' => array(
				'link' => $link
			)
		);

		$buttons['open']['class'] = $buttons['confirm']['class'] = (isset($options['color']) && $options['color'] != '') ? 'btn-' . $options['color'] : 'btn-success';
		$buttons['confirm']['name'] = (isset($options['button']) && $options['button'] != '') ? $options['button'] : $button;
		$body = (isset($options['texte']) && $options['texte'] != '') ? $options['texte'] : 'Voulez-vous vraiment continuer votre action ?';
		$header = (isset($options['header']) && $options['header'] != '') ? $options['header'] : $button;

		return $this->modal($header, $body, null, $buttons);
	}

/**
 * Just call the Tag function of the HtmlHelper
 *
 * @param string $name Tag name.
 * @param string $text String content that will appear inside the div element.
 *   If null, only a start tag will be printed
 * @param array $options Additional HTML attributes of the DIV tag, see above.
 * @return string The formatted tag element
 */
 	public function tag($tag , $text = null, $options = array()) {
		return $this->Html->tag($tag , $text , $options);
	}		
}
