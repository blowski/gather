<?php
declare(strict_types=1);

namespace App\Validators;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class HomeGroupWithCodeMustExist extends Constraint
{
    public $message = 'HomeGroup with code "{{ code }}" does not exist';
}