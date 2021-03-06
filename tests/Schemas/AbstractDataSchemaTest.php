<?php
declare(strict_types=1);

namespace Tests\PostmanGenerator\Schemas;

use PostmanGenerator\Exceptions\InvalidMethodCallException;
use Tests\PostmanGenerator\SchemaTestCase;

/**
 * @covers \PostmanGenerator\Schemas\AbstractSchema
 */
class AbstractDataSchemaTest extends SchemaTestCase
{
    /**
     * Test data array to fill properties.
     *
     * @return void
     */
    public function testDataFill(): void
    {
        $dto = new SchemaStub(['dataAsString' => 'this is a string', 'dataAsInt' => 1, 'dataBol' => true]);

        self::assertEquals('this is a string', $dto->getDataAsString());
        self::assertEquals(1, $dto->getDataAsInt());
        self::assertTrue($dto->isDataBol());
    }

    public function testPrePopulateObject(): void
    {
        $dto = new PrePopulateSchemaStub();

        self::assertNotEmpty($dto->getObjectId());
    }

    /**
     * Test data object properties.
     *
     * @return void
     */
    public function testProperties(): void
    {
        $dto = new SchemaStub();

        $dto->setDataBol(false);
        $dto->setDataAsInt(10);
        $dto->setDataAsString('i-am-a-string');

        $this->assertProperties($dto, [
            'isDataBol' => false,
            'getDataAsInt' => 10,
            'getDataAsString' => 'i-am-a-string'
        ]);
    }

    /**
     * Test data object must throw InvalidMethodCallException when property not found.
     *
     * @return void
     */
    public function testPropertyNotFound(): void
    {
        $this->expectException(InvalidMethodCallException::class);

        $dto = new SchemaStub([]);
        $dto->getDummyProp();
    }

    /**
     * Test string `setter` and `getter` methods.
     *
     * @return void
     */
    public function testPropertyString(): void
    {
        $dto = new SchemaStub([]);
        $dto->setDataAsString('this is a string');

        self::assertEquals('this is a string', $dto->getDataAsString());
    }

    /**
     * Snake case as property must be acceptable for mass assignment.
     *
     * @return void
     */
    public function testSnakeCaseMassAssignment(): void
    {
        $dto = new SchemaStub(['another_property' => 'this is a property']);

        self::assertEquals('this is a property', $dto->getAnotherProperty());
    }

    /**
     * Test data object as array.
     *
     * @return void
     */
    public function testToArray(): void
    {
        $dto = new SchemaStub(['dataAsString' => 'this is a string', 'dataAsInt' => 1, 'dataBol' => true]);

        self::assertEquals([
            'int' => 1,
            'string' => 'this is a string',
            'bol' => true
        ], $dto->toArray());
    }
}
