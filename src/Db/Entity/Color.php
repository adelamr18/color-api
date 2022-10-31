<?php

namespace Entity;
class Color
{

    private $id;

    private $colorName;

    private $hexValue;

    public function __construct()
    {
        $this->id = 0;
        $this->colorName = '';
        $this->hexValue = '';
    }


    public function getId(): int {
        return $this->id;
    }

    public function getColorName(): string {
       return $this->colorName;
    }

    public function getHexValue(): string {
        return $this->hexValue;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setColorName(string $colorName): void {
        $this->colorName = $colorName;
    }

    public function setHexValue(string $hexValue): void {
        $this->hexValue = $hexValue;
    }


}
