<?php
// src/AppBundle/Validators/Booking/NotPreviousDay.php

namespace AppBundle\Validators\Booking;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class NotPreviousDay extends Constraint
{
	public $message = "Vous ne pouvez pas commander un billet dont la date est antérieure à la date du jour";
	
	public function validatedBy()
	{
		return 'app_louvre_notpreviousday';
	}
} 