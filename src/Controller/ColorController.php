<?php

declare(strict_types=1);

namespace Controller;

use PDO;
use Repository\ColorRepository;
use Sunrise\Http\ServerRequest\ServerRequest;

final class ColorController
{
    /** @var ColorRepository */
    private $repository;
    private const METHOD_GET = 'GET';
    private const METHOD_POST = 'POST';
    private const METHOD_DELETE = 'DELETE';
    private const METHOD_UPDATE = 'PUT';

    public function __construct(ColorRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handleRequest(ServerRequest $request)
    {
        $requestMethod = $request->getMethod();

        switch ($requestMethod) {
            case ColorController::METHOD_GET:
                $queryResult = $this->repository->getColors();
                $resultCount = $queryResult->rowCount();

                $this->getColors($resultCount, $queryResult);
                break;

            case ColorController::METHOD_POST:
                $this->setAndReturnSentData();
                $this->addColor();
                break;

            case ColorController::METHOD_UPDATE:
                $data = $this->setAndReturnSentData();

                $this->updateColor($data);
                break;

            case ColorController::METHOD_DELETE:
                $data = $this->setAndReturnSentData();

                $this->deleteColor($data);
        }
    }

    public function getColors(int $colorsCount, $queryResult)
    {
        if ($colorsCount > 0) {
            $colors = [];

            while ($row = $queryResult->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                //pdo is PHP Data Objects
                //PDO is a more like a data access layer which uses a unified API (Application Programming Interface)
                //assoc array is an array with strings as an index
                //here whats being returned is an array having a key of column_name
                //and value of the column value in that row
                //extract($row) takes out the key that has the value of the coloumn in that row
                //extracts each variable independently
                $color_item = [
                    'id' => $id,
                    'colorName' => $color_name,
                    'hexValue' => $hex_value,
                ];
                //push to data
                array_push($colors, $color_item);
            }
            echo json_encode(['status' => '200', 'data' => $colors]);
        } else {
            echo json_encode(['status' => '404']);
        }
    }

    public function addColor(): void
    {
        if ($this->repository->addColor()) {
            echo json_encode(['status' => '201']);
        } else {
            echo json_encode(['status' => '400']);
        }
    }

    public function setAndReturnSentData()
    {
        $data = json_decode(file_get_contents('php://input'));

        if(isset($data->colorName)){
            $this->repository->getColor()->setColorName($data->colorName);
        }
        if(isset($data->hexValue)){
            $this->repository->getColor()->setHexValue($data->hexValue);
        }

        return $data;
    }

    public function updateColor($data): void
    {
        $this->repository->getColor()->setId(intval($data->id));

        if($this->repository->updateColor()) {
            echo json_encode(['status' => '200']);
        } else {
            echo json_encode(['status' => '400']);
        }
    }

    public function deleteColor($data): void
    {
        $this->repository->getColor()->setId(intval($data->id));

        if($this->repository->deleteColor()) {
            echo json_encode(['status' => '200']);
        } else {
            echo json_encode(['status' => '400']);
        }
    }
}
