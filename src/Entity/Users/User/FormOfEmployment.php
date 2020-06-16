<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-17
 * Time: 13:29
 */

namespace App\Entity\Users\User;


final class FormOfEmployment
{
    const FORM_OF_EMPLOYMENT_INTERNAL = 'Internal';
    const FORM_OF_EMPLOYMENT_EXTERNAL = 'External';
    const FORM_OF_EMPLOYMENT_ORDER = 'Umowa zlecenie';

    private $formOfEmployment;

    public function __construct($formOfEmployment)
    {
        $this->formOfEmployment = $formOfEmployment;
    }

    public function isInternal()
    {
        return $this->formOfEmployment === self::FORM_OF_EMPLOYMENT_INTERNAL;
    }

    public function isExternal()
    {
        return $this->formOfEmployment === self::FORM_OF_EMPLOYMENT_EXTERNAL;
    }

    public function isOrder()
    {
        return $this->formOfEmployment === self::FORM_OF_EMPLOYMENT_ORDER;
    }

    public function __toString()
    {
        return $this->formOfEmployment;
    }
}