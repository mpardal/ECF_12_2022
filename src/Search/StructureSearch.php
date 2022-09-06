<?php

namespace App\Search;


class StructureSearch
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
     * @return StructureSearch
     */
    public function setName(?string $name): StructureSearch
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
     * @return StructureSearch
     */
    public function setActive(?bool $active): StructureSearch
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
     * @return StructureSearch
     */
    public function setCity(?string $city): StructureSearch
    {
        $this->city = $city;
        return $this;
    }

}