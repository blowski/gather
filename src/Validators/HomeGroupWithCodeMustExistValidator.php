<?php
declare(strict_types=1);

namespace App\Validators;

use App\Repository\HomeGroupRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class HomeGroupWithCodeMustExistValidator extends ConstraintValidator
{

    /**
     * @var HomeGroupRepository
     */
    private $homeGroupRepository;

    public function __construct(HomeGroupRepository $homeGroupRepository)
    {
        $this->homeGroupRepository = $homeGroupRepository;
    }

    public function validate($value, Constraint $constraint)
    {
        if(6 !== strlen($value)) {
            $this->context->buildViolation("Your HomeGroup invite code should be exactly 6 characters long")
                ->setParameter('{{ code }}', $value)
                ->addViolation();
            return;
        }
        if($homeGroup = $this->homeGroupRepository->findOneBy(['code' => $value])) {
            return;
        }
        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ code }}', $value)
            ->addViolation();
    }


}