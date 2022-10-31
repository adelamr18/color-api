<?php

namespace Repository;

use Entity\Color;

class ColorRepository
{
    private $TABLE = 'colors';
    private $connection;
    private $color;

    public function __construct($db, $color)
    {
        $this->connection = $db;
        $this->color = $color;
    }

    //PDO is a more like a data access layer which uses a unified API (Application Programming Interface).
    public function getColors()
    {
        $query =
            'SELECT
        *
      FROM
        ' . $this->TABLE;

        $stmt = $this->connection->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    public function addColor(): bool
    {
        $query = 'INSERT INTO ' . $this->TABLE . ' SET color_name = :color_name, hex_value = :hex_value';
        $stmt = $this->connection->prepare($query);

        $this->sanitizeData();
        $this->bindData($stmt);

        return $this->executeAndReturnQuery($stmt);
    }

    public function getColor(): Color
    {
        return $this->color;
    }

    public function sanitizeData(): void
    {
        $colorName = $this->getColor()->getColorName();
        $colorHexValue = $this->getColor()->getHexValue();
        $id = $this->getColor()->getId();

        $this->getColor()->setColorName(htmlspecialchars(strip_tags($colorName)));
        $this->getColor()->setHexValue(htmlspecialchars(strip_tags($colorHexValue)));
        $this->getColor()->setId(htmlspecialchars(strip_tags($id)));
    }

    public function bindData($stmt): void
    {
        $colorName = $this->getColor()->getColorName();
        $colorHexValue = $this->getColor()->getHexValue();

        $stmt->bindParam(':color_name', $colorName);
        $stmt->bindParam(':hex_value', $colorHexValue);
    }

    public function updateColor(): bool
    {
        $query =
            'UPDATE ' .
            $this->TABLE .
            '
            SET color_name = :color_name, hex_value = :hex_value
            WHERE id = :id';
        $id = $this->getColor()->getId();
        $stmt = $this->connection->prepare($query);

        $this->sanitizeData();
        $this->bindData($stmt);
        $stmt->bindParam(':id', $id);

        return $this->executeAndReturnQuery($stmt);
    }

    public function deleteColor(): bool
    {
        $query = 'DELETE FROM ' . $this->TABLE . ' WHERE id = :id';
        $id = $this->getColor()->getId();
        $stmt = $this->connection->prepare($query);

        $this->sanitizeData();
        $stmt->bindParam(':id', $id);

        return $this->executeAndReturnQuery($stmt);
    }

    public function executeAndReturnQuery($stmt): bool
    {
        if ($stmt->execute()) {
            return true;
        }
        printf("An Error occured here: %s.\n", $stmt->error);

        return false;
    }


}
