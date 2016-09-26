<?php
// src/AppBundle/Validator/NotAfterHours.php

namespace AppBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class NotAfterHours extends Constraint
{
	public $message = "Vous ne pouvez pas commander un billet journée après 14h";
	
	public function validatedBy()
	{
		return 'app_louvre_notafterhours';
	}
} 