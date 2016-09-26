<?php
// src/AppBundle/Validator/NotAfterHoursValidator.php

namespace AppBundle\Validator;
 
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NotAfterHoursValidator extends ConstraintValidator
{   
	public function validate($value, Constraint $constraint)
    {
        $booking = $this->context->getRoot()->getData();

        $ticketType = $booking->getTicketType();

        $ticketTypeConditions = $ticketType->getConditions();

		if($ticketTypeConditions!==NULL) {

			$arrConditions = explode(' ',$ticketTypeConditions);
			$filter = $arrConditions[0];
			$hours = $arrConditions[1];
			$arrHours = explode(':',$hours);
			$hour = $arrHours[0];
			$minut = $arrHours[1];
			$ampm = $arrConditions[2];

			$dateBooking = $value;

			if (!$dateBooking instanceof \DateTime){
				$dateBooking = new \DateTime($dateBooking);
			}

			$today 		= new \DateTime('now');
			$limit 		= new \DateTime('now '.$hour.':'.$minut.' '.$ampm);

			// Si on commande pour le jour même
			if($dateBooking->format('Y-m-d') == $today->format('Y-m-d'))
			{
				// Si on dépasse la limite autorisée de x heures am/pm
				if($today->getTimestamp()>$limit->getTimestamp())
				{
					$this->context->addViolation($constraint->message);
				}
			}
		}
    }
}
