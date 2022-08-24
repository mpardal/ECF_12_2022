<?php

namespace App\Search;


class StructureSearch
{
    private ?string $name = null;

    private ?bool $active = null;

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
    public function getActive(): ?bool
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
}