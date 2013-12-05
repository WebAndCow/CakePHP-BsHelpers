<?php

echo $this->Bs->html($title_for_layout , $description_for_layout).

	// HEAD
		$this->Bs->css(array('style.css')).
		$this->Bs->js().
	// \HEAD
	// BODY
		$this->Bs->body().

			// CONTENT
			$content_for_layout;

	// \BODY

echo $this->Bs->end();
