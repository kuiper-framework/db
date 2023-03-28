<?php

namespace kuiper\db\fixtures;

use kuiper\db\attribute\Column;
use kuiper\db\attribute\Enumerated;
use kuiper\db\attribute\Id;

class Student
{
    #[Id]
    private ?int $id = null;

    private ?Gender $gender = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return Gender|null
     */
    public function getGender(): ?Gender
    {
        return $this->gender;
    }

    /**
     * @param Gender|null $gender
     */
    public function setGender(?Gender $gender): void
    {
        $this->gender = $gender;
    }
}