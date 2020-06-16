<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-26
 * Time: 11:00
 */

namespace App\Entity\Users\ReadModel;


use App\Entity\Onboardings\Onboarding;

class User
{
    private $id;
    private $name;
    private $surname;
    private $division;
    private $department;
    private $managerName;
    private $managerSurname;
    private $partnerName;
    private $partnerSurname;
    private $formOfEmployment;
    private $onboardingDays;
    private $statusAdditional;
    private $statusNotAdditional;
    private $active;
    private $block;

    public function __construct(
        int $id,
        string $name,
        string $surname,
        string $division,
        string $department,
        ?string $managerName,
        ?string $managerSurname,
        ?string $partnerName,
        ?string $partnerSurname,
        string $formOfEmployment,
        ?array $onboardingDays,
        ?int $statusAdditional,
        ?int $statusNotAdditional,
        bool $active,
        bool $block
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
        $this->division = $division;
        $this->department = $department;
        $this->managerName = $managerName;
        $this->managerSurname = $managerSurname;
        $this->partnerName = $partnerName;
        $this->partnerSurname = $partnerSurname;
        $this->formOfEmployment = $formOfEmployment;
        $this->onboardingDays = $onboardingDays;
        $this->statusAdditional = $statusAdditional;
        $this->statusNotAdditional = $statusNotAdditional;
        $this->active = $active;
        $this->block = $block;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * @return string
     */
    public function getDivision(): string
    {
        return $this->division;
    }

    /**
     * @return string
     */
    public function getDepartment(): string
    {
        return $this->department;
    }

    /**
     * @return null|string
     */
    public function getManagerName(): ?string
    {
        return $this->managerName;
    }

    /**
     * @return null|string
     */
    public function getManagerSurname(): ?string
    {
        return $this->managerSurname;
    }

    /**
     * @return null|string
     */
    public function getPartnerName(): ?string
    {
        return $this->partnerName;
    }

    /**
     * @return null|string
     */
    public function getPartnerSurname(): ?string
    {
        return $this->partnerSurname;
    }

    /**
     * @return string
     */
    public function getFormOfEmployment(): string
    {
        return $this->formOfEmployment;
    }

    /**
     * @return array|null
     */
    public function getOnboardingDays(): ?array
    {
        return $this->onboardingDays;
    }
    public function getOnboardingDate()
    {
        if($this->getOnboardingDays())
            return $this->getOnboardingDays()[0]['day'];
        return null;
    }

    /**
     * @return int|null
     */
    public function getStatusAdditional(): ?int
    {
        return $this->statusAdditional;
    }

    /**
     * @return int|null
     */
    public function getStatusNotAdditional(): ?int
    {
        return $this->statusNotAdditional;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    public function activeString()
    {
        return $this->active?'Aktywny':'Nieakt.';
    }

    /**
     * @return bool
     */
    public function isBlock(): bool
    {
        return $this->block;
    }

    public function blockString()
    {
        return 'Zablok.';
    }

}