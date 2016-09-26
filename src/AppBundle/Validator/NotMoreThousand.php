<?php
// src/AppBundle/Validator/NotMoreThousand.php

namespace AppBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class NotMoreThousand extends Constraint
{
	public $message = "Plus de ticket(s) disponible(s) pour cette date";
	
	public function validatedBy()
	{
		return 'app_louvre_notmorethousand';
	}
} 