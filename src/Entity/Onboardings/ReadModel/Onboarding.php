<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-18
 * Time: 14:20
 */

namespace App\Entity\Onboardings\ReadModel;


use App\Entity\Divisions\Division;
use App\Entity\Onboardings\ReadModel\Onboarding\Status;

class Onboarding
{
    private $id;
    private $days;
    private $status;
    private $pharma;
    private $onco;
    private $sandoz;
    private $countUser;

    public function __construct(
        int $id,
        array $days,
        Status $status,
        ?array $pharma,
        ?array $onco,
        ?array $sandoz,
        int $countUser
    )
    {
        $this->id = $id;
        $this->days = $days;
        $this->status = $status;
        $this->pharma = $pharma;
        $this->onco = $onco;
        $this->sandoz = $sandoz;
        $this->countUser = $countUser;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getDays()
    {
        return $this->days;
    }

    /**
     * @return Status
     */
    public function getStatus(): Status
    {
        return $this->status;
    }

    /**
     * @return string|null
     */
    public function getPharma(): ?string
    {
        if($this->pharma) {
            return reset($this->pharma)["day"].' - '.end($this->pharma)["day"];
        }

        return null;
    }

    /**
     * @return string|null
     */
    public function getOnco(): ?string
    {
        if($this->onco) {
            return reset($this->onco)["day"].' - '.end($this->onco)["day"];
        }

        return null;
    }

    /**
     * @return string|null
     */
    public function getSandoz(): ?string
    {
        if($this->sandoz) {
            return reset($this->sandoz)["day"].' - '.end($this->sandoz)["day"];
        }

        return null;
    }

    /**
     * @return int
     */
    public function getCountUser(): int
    {
        return $this->countUser;
    }

    public function getFirstDay()
    {
        return reset($this->days)["day"];
    }

    public function getLastDay()
    {
        return end($this->days)["day"];
    }

    public function checkDivisionData(Division $division)
    {
        switch ($division->getName()) {
            case 'Pharma':
                return $this->pharma?false:true;
                break;
            case 'Oncology':
                return $this->onco?false:true;
                break;
            case 'Sandoz':
                return $this->sandoz?false:true;
                break;
        }
    }
}