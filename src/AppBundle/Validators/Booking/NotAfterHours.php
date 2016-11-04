<?php
// src/AppBundle/Validators/Booking/NotAfterHours.php

namespace AppBundle\Validators\Booking;

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