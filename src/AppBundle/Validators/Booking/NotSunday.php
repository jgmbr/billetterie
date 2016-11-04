<?php
// src/AppBundle/Validators/Booking/NotSunday.php

namespace AppBundle\Validators\Booking;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class NotSunday extends Constraint
{
    public $message = "Vous ne pouvez pas commander un billet le dimanche (jour de fermeture)";
	
	public function validatedBy()
	{
		return 'app_louvre_notsunday';
	}
} 