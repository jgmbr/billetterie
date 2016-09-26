<?php
// src/AppBundle/Validator/NotHolidays.php

namespace AppBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class NotHolidays extends Constraint
{
	public $message = "Vous ne pouvez pas commander un billet un jour férié";
	
	public function validatedBy()
	{
		return 'app_louvre_notholidays';
	}
} 