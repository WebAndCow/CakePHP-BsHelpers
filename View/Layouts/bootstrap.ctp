<?php

echo $this->Bs->html($title_for_layout , $description_for_layout).

	// HEAD
		$this->Bs->css(array('style.css')).
		$this->fetch('cssTop').
	// \HEAD
	// BODY
		$this->Bs->body().

			// CONTENT
			$content_for_layout.

	// \BODY
		$this->Bs->js().
		$this->fetch('scriptBottom').
$this->Bs->end();
