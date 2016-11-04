<?php
// src/AppBundle/Validators/Booking/NotTuesday.php

namespace AppBundle\Validators\Booking;

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