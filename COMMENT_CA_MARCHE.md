# BsHelper

BsHelper::modal(string $header, string $body, array $options = array(), array $buttons = array())

_param string $header_ :
Contenu de l'en-tête
_param string $body_ :
Contenu du corps
_param array $options_ :
Tableau indiquant l'ID du modal, classes supplémentaires et la présence ou non dans un formulaire.
_param array $buttons_ :
Tableau caractérisant les 3 boutons du modal.

Créer un modal de Bootstrap :

		echo $this->Bs->modal('Mon en-tête', 'Mon contenu');

Crée une modal simple sans bouton close et confirm.

Pour personnalisé vos boutons, utilisez le tableau $buttons :

		$this->Bs->modal(
			'Mon en-tête',
			'Mon contenu',
			array(
				'id' => 'abc123',
				'class' => 'modal-form',
			),
			array(
				'open' => array(
					'name' => 'S'inscrire',
					'class' => 'btn-success'
					),
				'close' => array(
					'name' => 'Annuler',
					'class' => 'btn-link'
					),
				'confirm' => array(
					'name' => 'Confirmer',
					'link' => array(
						'controller' => 'monController',
						'action' => 'monAction'
					),
					'class' => 'btn-success'
				)
			)
		);

Si vous voulez naviguer en dehors du projet en cliquant sur le bouton confirmer, utilisez une URL absolue à la place du tableau de CakePHP.

Pour insérer un formulaire dans le body :

		$this->Bs->modal('Mon en-tête', $form);

La variable $form désigne ici le code HTML de votre formulaire.


BeHelper::alert(string $text, string $state, array $options = array())

$text : Définit le contenu de l'alerte.
$state : L'état bootrstrap de l'alerte.
$options : Tableau d'options caractérisant l'alerte.

		$this->Bs->alert('monTexte', 'warning');

Donnera :

		'<div  class="alert alert-warning" style="display:none;"> monTexte </div>'

Le tableau $options prend des attributs HTML classiques, mais aussi l'index 'dismiss' (true/false) pour définir si l'alerte peut être fermée ou non. Par défaut à true.

		$this->Bs->alert('monTexte', 'warning', array('dismiss' => 'true', 'id' => 'monId', 'style' => 'color:purple	;'));


# BsFormHelper

BsFormHelper::inputGroup(string $fieldName, array $addonOptions, array $options = array())

$fieldName : Voir $fieldName du BsFormHelper::input().
$addonOptions : Tableau d'options caractérisant l'addon.
$options :	Voir $options du BsFormHelper::input().

		$this->BsForm->inputGroup('Field.name', array('content' => 'MonContenu'));

Donnera :

		<div class="form-group">
			<label for="FieldName" class="control-label col-md-3">Name</label>
			<div class="col-md-9">
				<div class="input-group">
					<span class="input-group-addon">MonContenu</span>
					<input name="data[Field][name]" class="form-control" type="text" id="FieldName"/>
				</div>
			</div>
		</div>

Pour avoir un bouton à la place de l'addon, il vous suffit d'ajouter, dans $addonOptions, l'index 'button' => 'true' pour un simple bouton, ou 'button' => array() pour un bouton personnalisé. Par défaut le bouton est de type 'submit'.

Ce qui donnera :

		<div class="form-group">
			<label for="FieldName" class="control-label col-md-3">Name</label>
			<div class="col-md-9">
				<div class="input-group">
					<span class="input-group-btn">
						<button type="submit" class="btn btn-default">MonContenu</button>
					</span>
					<input name="data[Field][name]" class="form-control" type="text" value="" id="FieldName"/>
				</div>
			</div>
		</div>

Les options possibles pour l'addon/bouton sont :

* 'content' : Définit le contenu de l'addon.
* 'side'    : Définit de quel côté se situera l'addon.
* 'class'   : Permet d'ajouter des classes à l'input.
* 'button'  : Permet d'avoir un bouton à la place d'un addon. Plusieurs options lui sont associées :
	* 'state' : Définit le type bootstrap du bouton. Valeurs possibles : 'default', 'primary', 'secondary', 'warning', 'danger'.
	* 'type'  : Définit le type du bouton. Par défaut 'submit'.
	* 'class' : Permet d'ajouter des classes au bouton.


BsFormHelper::datepicker($mixed $fieldName, array $optionsDP, array $options = array())

$fieldName : Voir $fieldName du BsFormHelper::input().
$optionsDP : Tableau d'options caractérisant le datepicker.
$options   : Voir $options du BsFormHelper::input().


		$this->BsForm->datepicker('Field.name');

Donnera :

		<div id="sandbox-container">
			<div class="form-group">
				<label for="FieldName" class="control-label col-md-3">Date</label>
				<div class="col-md-9">
					<input name="data[Field][date]" class="form-control" type="text" value="2014-06-28 00:00:00" id="FieldName"/>
				</div>
			</div>
			<input type="hidden" name="data[Field][date]" id="alt_dp" class="form-control" value="2014-06-28 00:00:00"/>
		</div>

Les options possibles pour le datepicker sont disponible sur ce [datepicker]'http://eternicode.github.io/bootstrap-datepicker/ "site").

Un tableau type du $optionsDP serait de la forme :

		$mesOptions = array(
			'format' => 'dd/mm/yyyy',
			'language' => 'fr',
			'orientation' => 'top-right'
		)

Cette fonction permet également un double datepicker (range) avec un date de début, et une date de fin. Pour ce faire, il suffit de passer un tableau de $fieldName.

	$this->BsForm->datepicker(array('Field.debut', 'Field.fin'), array('label' => 'Date'));

Ce qui donne :

		<div class="form-group">
			<label class="control-label col-md-3">Date</label>
			<div class="dp-container">
				<div class=" col-md-9">
					<div class="input-daterange input-group" id="datepicker">
						<label for="FieldDebut" class="control-label col-md-0"></label>
						<input name="data[Field][debut]" class="form-control" type="text" id="FieldDebut"/>
						<input type="hidden" name="data[Field][debut]" id="alt_dp_0" class="form-control"/>
						<span class="input-group-addon">à</span>
						<label for="FieldFin" class="control-label col-md-0"></label>
						<input name="data[Field][fin]" class="form-control" type="text" id="FieldFin"/>
						<input type="hidden" name="data[Field][fin]" id="alt_dp_1" class="form-control"/>
					</div>
				</div>
			</div>
		</div>

Vous pouvez également spécifier des options différentes pour les deux input, en passant deux tableau d'options dans les paramètres $options.

		$this->BsForm->datepicker(array('Field.debut', 'Field.fin'), array('label' => 'Date'), array($optionsDebut, $optionsFin));
