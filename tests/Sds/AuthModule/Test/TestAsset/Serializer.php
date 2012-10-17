<?php
/**
 * @package    Sds
 * @license    MIT
 */
namespace Sds\AuthModule\Test\TestAsset;

use Sds\Common\Serializer\SerializerInterface;

class Serializer implements SerializerInterface
{

    public function toArray($object){
        return [
            'name' => $object->getName()
        ];
    }

    public function toJson($object){
        return null;
    }

    public function fromArray(array $data, $classNameKey = '_className', $className = null){
        return null;
    }

    public function fromJson($data, $classNameKey = '_className', $className = null){
        return null;
    }
}