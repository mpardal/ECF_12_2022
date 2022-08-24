<?php

namespace App\Search;


class FranchiseSearch
{
    private ?string $name = null;


    private ?bool $active = null;


    private ?string $city = null;

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return FranchiseSearch
     */
    public function setName(?string $name): FranchiseSearch
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function isActive(): ?bool
    {
        return $this->active;
    }

    /**
     * @param bool|null $active
     * @return FranchiseSearch
     */
    public function setActive(?bool $active): FranchiseSearch
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string|null $city
     * @return FranchiseSearch
     */
    public function setCity(?string $city): FranchiseSearch
    {
        $this->city = $city;
        return $this;
    }


}