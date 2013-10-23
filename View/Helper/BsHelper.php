<?php
/**
 * 
 * Helper CakePHP to create Twitter Bootstrap elements
 * @author AWL
 *
 */


class BsHelper extends HtmlHelper {
	

/**
 * The name of the helper
 *
 * @var string
 */
	public $name = 'Bs3';
	
/**
 * Path for CSS bootstrap 
 *
 * @var string
 */
	public $pathCSS = 'bootstrap';
	
/**
 * Path for JS bootstrap
 *
 * @var string
 */
	public $pathJS = 'bootstrap.js';
	
/**
 * Path for JQuery
 *
 * @var string
 */
	public $pathJquery = 'http://codeorigin.jquery.com/jquery-1.10.2.min.js';
	


/**
 * Initialize an HTML document and the head
 *
 * @param string $titre The name of the current page
 * @param string $description The description of the current page
 * @param string $lang The language of the current page. By default 'fr' because we are french
 * @return string
 */

	public function html($titre = '' , $description = '' , $lang = 'fr') {
	
		$out = '<!DOCTYPE html>' . BL;
		$out .= '<html lang="'.$lang.'">' . BL;
		$out .= '<head>' . BL;
		$out .= '<meta charset="utf-8">' . BL;
		$out .= '<title>'.$titre.'</title>' . BL;
		$out .= '<meta name="viewport" content="width=device-width, initial-scale=1.0">' . BL;
		$out .= '<meta name="description" content="'.$description.'">' . BL;
	
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

	public function html5($titre = '' , $description = '' , $lang = 'fr') {
	
		$out = $this->html($titre , $description , $lang);
		
		// Script JS for IE and HTML 5
		$out .= '<!--[if lt IE 9]>' . BL;
		$out .= '<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>' . BL;
		$out .= '<![endif]-->' . BL;
	
		return $out;
	}
	

/**
 * Close the head element and initialize the body element
 *
 * @return string
 */
	
	public function body() {
		
		$out =  '</head>' . BL;
		$out .= '<body class="cbp-spmenu-push">' . BL;
		
		return $out;
	}
	
	
/**
 * Close the body element and the html element
 *
 * @return string
 */

	public function end() {
		
		$out =  '</body>' . BL;
		$out .= '</html>';
		
		return $out;
	}
	

/**
 * Load CSS for the current page
 *
 * @param array $array_css Names of CSS for the current page
 * @return string A link tag for the head element
 */

	public function css($array_css = array(), $options = array()) {
		
		$out = parent::css($this->pathCSS). BL ;
		
		// Others CSS
		foreach($array_css as $css)
			$out .= parent::css($css, $options) . BL;
			
		return $out;
	}


/**
 * Load JS for the current page
 *
 * @param array $array_js Names of JS for the current page
 * @return string A script tag for the head element
 */

	public function js($array_js = array()) {		
		
		$out =  parent::script($this->pathJquery) . BL;
		$out .= parent::script($this->pathJS) . BL;
		
		// Others JS
		foreach($array_js as $js)
			$out .= parent::script($js). BL;
		
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
		for($i=0;$i<$nb;$i++)
			$out .= '</div>' . BL;
		return $out;
	}
	
/**
 * Open a Bootstrap container
 *
 * @param array $options Options of the div element
 * @return string Div element with the class 'container'
 */
	public function container($options = array()) {
		$out = '';
		$class = CONTAINER;
		if(isset($options['class']))
			$class .= SP . $options['class'];		
		$out .= parent::div($class , null, $options). BL;
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
		$class = ROW;
		if(isset($options['class']))
			$class .= SP . $options['class'];
		$out .= parent::div($class , null, $options). BL;
		return $out;
	}


/**
 * Open a header element
 *
 * @param array $options Options of the header element
 * @return string Tag header
 */
	public function header($options = array()) {
		$out = parent::tag('header', null, $options). BL;
		return $out;
	}

/**
 * Close the header element
 *
 * @return string End tag header
 */
	public function closeHeader() {
		return '</header>' . BL;
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
		if(isset($options['class'])){
			$options['class'] = 'img-responsive '.$options['class'];
		}else{
			$options['class'] = 'img-responsive';
		}
		return parent::image($path, $options);
	}
	



/*
 * 
 * --------------------
 *      THE GRID
 * --------------------
 * 
 */
	
	
	
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
 * LAYOUT -> not obligatory for the first param ('xs' by default).
 * SIZE -> size of the column in a grid of 12 columns.
 * OPTIONS -> Not obligatory. Offset, push or pull. Called like this : 'of', 'ph' or 'pl'.
 * SIZE -> size of the option.
 *
 *
 * ### Attributes
 *
 * Same options that HtmlHelper::div();
 *
 * @param string layout, size and options (offset, push and/or pull)
 * @param array $attributes Options of the div element
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
			}else{
				$attributes = $arg;
			}
		}

		$arrayDevice = array('xs' , 'sm' , 'md' , 'lg');
		$arrayOptions = array('of' , 'ph' , 'pl');

		foreach ($devices as $device) {
			$ecran = null;
			$taille = null;
			$opt = null;
			$replace = array('(', ')', '-', '_', '/', '\\', ';', ',', ':', ' ');
			$device = str_replace($replace, '.', $device);
			$device = explode('.', $device);

			// On doit obligatoirement définir un écran en premier sinon ça ne marche pas
			foreach ($device as $elem) {
				if (!$ecran) {
					$nom = substr($elem, 0, 2);
					if(in_array($nom , $arrayDevice)) {
						$ecran = $nom;
						$taille = substr($elem, 2);
					}
				}else{
					if ($opt) {
						$opt .= ' '.$this->optCol($elem, $ecran);
					}
					else{
						$opt = $this->optCol($elem, $ecran);
					}
				}
			}
			if (isset($ecran) && $taille) {
				if ($opt) {
					$class .= 'col-'.$ecran.'-'.$taille.' '.$opt.' ';
				}else{
					$class .= 'col-'.$ecran.'-'.$taille.' ';
				}
			}
		}
		$class = substr($class,0,-1);
		if(isset($attributes['class']))
			$class .= SP . $attributes['class'];
		$out = parent::div($class , null, $attributes). BL;
		return $out;
	}


/**
 * Complementary function with BsHelper::col()
 *
 * Add the correct class for the option in parameter
 *
 * @param array $elem // classe appliquée sur l'élément col {PARAMETRE OBLIGATOIRE}
 * @param string $ecran // layout concerné {PARAMETRE OBLIGATOIRE}
 * @return string The class corresponding to the option
 */

	private function optCol($elem, $ecran){
		$attr = substr($elem, 0, 2);
		$taille = substr($elem, 2);
		if (is_integer($taille) || !($taille == 0 && $ecran == 'sm'))  {
			switch ($attr) {
				case 'pl':
					return 'col-'.$ecran.'-pull-'.$taille;
					break;

				case 'ph':
					return 'col-'.$ecran.'-push-'.$taille;
					break;
				
				case 'of':
					return 'col-'.$ecran.'-offset-'.$taille;
					break;
				default:
					return null;
					break;
			}
		}
	}
	
}