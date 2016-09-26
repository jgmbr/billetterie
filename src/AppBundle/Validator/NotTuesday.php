<?php
// src/AppBundle/Validator/NotTuesday.php

namespace AppBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class NotTuesday extends Constraint
{
	public $message = "Vous ne pouvez pas commander un billet le mardi (jour de fermeture)";
	
	public function validatedBy()
	{
		return 'app_louvre_nottuesday';
	}
} 