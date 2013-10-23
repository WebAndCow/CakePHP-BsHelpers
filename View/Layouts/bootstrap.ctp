<?php

echo $this->Bp->html($title_for_layout , $description_for_layout).
		
	// HEAD
		$this->Bp->css().
		$this->Bp->js().
	// \HEAD

	// BODY
		$this->Bp->body().

			// CONTENT
			$content_for_layout;

	// \BODY
echo $this->Bp->endBodyHtml();