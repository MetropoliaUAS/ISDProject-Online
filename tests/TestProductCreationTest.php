<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TestProductCreationTest extends TestCase
{
    /**
     * Test the product creating by sending a post to the product creation route
     *
     * @return void
     */
    public function testProductCreationWithPost()
    {
        $newProduct = factory(App\Product::class)->make();
        $genericSensorIdsCollection = App\GenericSensor::all("id");
        $genericSensorIds = array();
        foreach ($genericSensorIdsCollection->all() as $genericSensor) {
            $genericSensorIds[] = $genericSensor->id;
        }

        $this->post("/products/create", array(
            "id" => $newProduct->id,
            "version" => $newProduct->version,
            "sensors" => $genericSensorIds
        ));

        $this->assertNotNull(
            App\Product::find($newProduct->id)
        );
    }
}
