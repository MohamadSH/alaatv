<?php

namespace Tests\Feature;

use App\Attribute;
use App\Attributevalue;
use App\Bon;
use App\User;
use App\Product;
use App\Userbon;
use Tests\TestCase;
use App\Traits\OrderCommon;
use Illuminate\Http\Response;
//use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderProductTest extends TestCase
{
//    use RefreshDatabase;
    use OrderCommon;

    public function testAddToOrder() {

        $user = factory(User::class)->create();
        $bon = Bon::find(1);
        $gift = factory(Product::class)->create([
            'producttype_id' => 1
        ]);

        $orderId = $user->getOpenOrder()->id;

        $this->assertion0(); // logout user
        $this->assertion1($user, $bon, $orderId, $gift); // simple product with gift and bon
        $this->assertion2($user, $bon, $orderId, $gift); // simple product has father and father has gift and bon
        $this->assertion3($user, $bon, $orderId, $gift); // selectable product with gift and bon
        $this->assertion4($user, $bon, $orderId, $gift); // configurable product with gift and bon

        $user->forceDelete();
        $gift->forceDelete();
    }

    /**
     * logout user
     */
    public function assertion0()
    {
        /** @var User $user */
        $user = factory(User::class)->create();

        $product = factory(Product::class)->create([
            'producttype_id' => 1
        ]);

        $data = [
            'product_id' => $product->id,
            'products' => [],
            'attribute' => [],
            'extraAttribute' => [],
            'withoutBon' => false
        ];


        $response = $this
            /*->actingAs($user)*/
            ->call('POST', 'orderproduct', $data);
        $response
            ->assertStatus(Response::HTTP_FOUND);
        $user->forceDelete();
        $product->forceDelete();
    }

    /**
     * simple product with gift
     * @param User $user
     * @param Bon $bon
     * @param Userbon $userbon
     * @param int $orderId
     * @param Product $gift
     */
    public function assertion1(User $user, Bon $bon, int $orderId, Product $gift)
    {
        $product = factory(Product::class)->create([
            'producttype_id' => 1
        ]);
        $bonDiscount = 10;
        $product->bons()
            ->attach($bon->id, ['discount'=>$bonDiscount]);
        $userbon = factory(Userbon::class)->create([
            'user_id' => $user->id,
            'bon_id' => $bon->id,
            'totalNumber' => 10,
            'usedNumber' => 0
        ]);

        $product->gifts()
            ->attach($gift->id, ['relationtype_id' => config("constants.PRODUCT_INTERRELATION_GIFT")]);

        $data = [
            /*'order_id' => $orderId,*/
            'product_id' => $product->id,
            'products' => [],
            'attribute' => [],
            'extraAttribute' => [],
            'withoutBon' => false
        ];

        $response = $this
            ->actingAs($user)
            ->call('POST', 'orderproduct', $data);
        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'product saved'
            ]);
        $this->assertDatabaseHas('orders', [
            'id' => $orderId
        ]);
        $this->assertDatabaseHas('orderproducts', [
            'order_id' => $orderId,
            'product_id' => $product->id
        ]);
        $this->assertDatabaseHas('orderproduct_userbon', [
            'userbon_id' => $userbon->id,
            'discount' => $bonDiscount
        ]);
        $this->assertDatabaseHas('orderproducts', [
            'order_id' => $orderId,
            'product_id' => $gift->id
        ]);
        $product->forceDelete();
    }

    /**
     * simple product has father and father has gift
     * @param User $user
     * @param Bon $bon
     * @param Userbon $userbon
     * @param int $orderId
     * @param Product $gift
     */
    public function assertion2(User $user, Bon $bon, int $orderId, Product $gift)
    {
        $fatherProduct = factory(Product::class)->create([
            'producttype_id' => 1
        ]);
        $bonDiscount = 10;
        $fatherProduct->bons()
            ->attach($bon->id, ['discount'=>$bonDiscount]);
        $userbon = factory(Userbon::class)->create([
            'user_id' => $user->id,
            'bon_id' => $bon->id,
            'totalNumber' => 10,
            'usedNumber' => 0
        ]);
        $childProduct = factory(Product::class)->create([
            'producttype_id' => 1
        ]);
        $fatherProduct->children()
            ->attach($childProduct->id);
        $fatherProduct->gifts()
            ->attach($gift->id, ['relationtype_id' => config("constants.PRODUCT_INTERRELATION_GIFT")]);

        $data = [
            /*'order_id' => $orderId,*/
            'product_id' => $childProduct->id,
            'products' => [],
            'attribute' => [],
            'extraAttribute' => [],
            'withoutBon' => false
        ];

        $response = $this
            ->actingAs($user)
            ->call('POST', 'orderproduct', $data);
        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'product saved'
            ]);
        $this->assertDatabaseHas('orders', [
            'id' => $orderId
        ]);
        $this->assertDatabaseHas('orderproducts', [
            'order_id' => $orderId,
            'product_id' => $childProduct->id
        ]);
        $this->assertDatabaseHas('orderproducts', [
            'order_id' => $orderId,
            'product_id' => $gift->id
        ]);
        $this->assertDatabaseHas('orderproduct_userbon', [
            'userbon_id' => $userbon->id,
            'discount' => $bonDiscount
        ]);
        $fatherProduct->forceDelete();
        $childProduct->forceDelete();
    }

    /**
     * selectable product with gift
     * @param User $user
     * @param Bon $bon
     * @param Userbon $userbon
     * @param int $orderId
     * @param Product $gift
     */
    public function assertion3(User $user, Bon $bon, int $orderId, Product $gift)
    {
        $grandfatherProduct = factory(Product::class)->create([
            'producttype_id' => 3
        ]);
        $bonDiscount = 10;
        $grandfatherProduct->bons()
            ->attach($bon->id, ['discount'=>$bonDiscount]);
        $userbon = factory(Userbon::class)->create([
            'user_id' => $user->id,
            'bon_id' => $bon->id,
            'totalNumber' => 10,
            'usedNumber' => 0
        ]);
        $fatherProduct1 = factory(Product::class)->create([
            'producttype_id' => 1,
            'grand_id' => $grandfatherProduct->id
        ]);
        $fatherProduct2 = factory(Product::class)->create([
            'producttype_id' => 1,
            'grand_id' => $grandfatherProduct->id
        ]);
        $childProduct11 = factory(Product::class)->create([
            'producttype_id' => 1,
            'grand_id' => $grandfatherProduct->id
        ]);
        $childProduct12 = factory(Product::class)->create([
            'producttype_id' => 1,
            'grand_id' => $grandfatherProduct->id
        ]);
        $childProduct21 = factory(Product::class)->create([
            'producttype_id' => 1,
            'grand_id' => $grandfatherProduct->id
        ]);
        $childProduct22 = factory(Product::class)->create([
            'producttype_id' => 1,
            'grand_id' => $grandfatherProduct->id
        ]);
        $childProduct111 = factory(Product::class)->create([
            'producttype_id' => 1,
            'grand_id' => $grandfatherProduct->id
        ]);
        $childProduct112 = factory(Product::class)->create([
            'producttype_id' => 1,
            'grand_id' => $grandfatherProduct->id
        ]);
        $childProduct121 = factory(Product::class)->create([
            'producttype_id' => 1,
            'grand_id' => $grandfatherProduct->id
        ]);
        $childProduct122 = factory(Product::class)->create([
            'producttype_id' => 1,
            'grand_id' => $grandfatherProduct->id
        ]);
        $childProduct211 = factory(Product::class)->create([
            'producttype_id' => 1,
            'grand_id' => $grandfatherProduct->id
        ]);
        $childProduct212 = factory(Product::class)->create([
            'producttype_id' => 1,
            'grand_id' => $grandfatherProduct->id
        ]);
        $childProduct221 = factory(Product::class)->create([
            'producttype_id' => 1,
            'grand_id' => $grandfatherProduct->id
        ]);
        $childProduct222 = factory(Product::class)->create([
            'producttype_id' => 1,
            'grand_id' => $grandfatherProduct->id
        ]);

        $grandfatherProduct->children()
            ->attach($fatherProduct1->id);
        $grandfatherProduct->children()
            ->attach($fatherProduct2->id);
        $fatherProduct1->children()
            ->attach($childProduct11->id);
        $fatherProduct1->children()
            ->attach($childProduct12->id);
        $fatherProduct2->children()
            ->attach($childProduct21->id);
        $fatherProduct2->children()
            ->attach($childProduct22->id);
        $childProduct11->children()
            ->attach($childProduct111->id);
        $childProduct11->children()
            ->attach($childProduct112->id);
        $childProduct12->children()
            ->attach($childProduct121->id);
        $childProduct12->children()
            ->attach($childProduct122->id);
        $childProduct21->children()
            ->attach($childProduct211->id);
        $childProduct21->children()
            ->attach($childProduct212->id);
        $childProduct22->children()
            ->attach($childProduct221->id);
        $childProduct22->children()
            ->attach($childProduct222->id);

        $grandfatherProduct->gifts()
            ->attach($gift, ['relationtype_id' => config("constants.PRODUCT_INTERRELATION_GIFT")]);

        /**
         * p:
         *  1
         *      11
         *          111 $
         *          112 $
         *      12
         *          121 $
         *          122
         *  2
         *     21 $
         *          211
         *          212
         *     22 $
         *          221 $
         *          222
         */
        $data = [
            /*'order_id' => $orderId,*/
            'product_id' => $grandfatherProduct->id,
            'products' => [
                $childProduct111->id,
                $childProduct112->id,
                $childProduct121->id,
                $childProduct21->id,
                $childProduct22->id,
                $childProduct221->id
            ],
            'attribute' => [],
            'extraAttribute' => [],
            'withoutBon' => false
        ];

        $response = $this
            ->actingAs($user)
            ->call('POST', 'orderproduct', $data);
        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'product saved'
            ]);
        $this->assertDatabaseHas('orders', [
            'id' => $orderId
        ]);
        $this->assertDatabaseHas('orderproducts', [
            'order_id' => $orderId,
            'product_id' => $childProduct11->id
        ]);
        $this->assertDatabaseHas('orderproducts', [
            'order_id' => $orderId,
            'product_id' => $childProduct121->id
        ]);
        $this->assertDatabaseHas('orderproducts', [
            'order_id' => $orderId,
            'product_id' => $fatherProduct2->id
        ]);
        $this->assertDatabaseMissing('orderproducts', [
            'order_id' => $orderId,
            'product_id' => $childProduct111->id
        ]);
        $this->assertDatabaseMissing('orderproducts', [
            'order_id' => $orderId,
            'product_id' => $childProduct112->id
        ]);
        $this->assertDatabaseMissing('orderproducts', [
            'order_id' => $orderId,
            'product_id' => $childProduct21->id
        ]);
        $this->assertDatabaseMissing('orderproducts', [
            'order_id' => $orderId,
            'product_id' => $childProduct221->id
        ]);
        $this->assertDatabaseHas('orderproducts', [
            'order_id' => $orderId,
            'product_id' => $gift->id
        ]);
        $this->assertDatabaseHas('orderproduct_userbon', [
            'userbon_id' => $userbon->id,
            'discount' => $bonDiscount
        ]);
        $fatherProduct1->forceDelete();
        $fatherProduct2->forceDelete();
        $childProduct11->forceDelete();
        $childProduct12->forceDelete();
        $childProduct21->forceDelete();
        $childProduct22->forceDelete();
        $childProduct111->forceDelete();
        $childProduct112->forceDelete();
        $childProduct121->forceDelete();
        $childProduct122->forceDelete();
        $childProduct211->forceDelete();
        $childProduct212->forceDelete();
        $childProduct221->forceDelete();
        $childProduct222->forceDelete();
        $grandfatherProduct->forceDelete();
    }

    /**
     * configurable product with gift
     * @param User $user
     * @param Bon $bon
     * @param Userbon $userbon
     * @param int $orderId
     * @param Product $gift
     */
    public function assertion4(User $user, Bon $bon, int $orderId, Product $gift)
    {
        $fatherProduct = factory(Product::class)->create([
            'producttype_id' => 2
        ]);
        $bonDiscount = 10;
        $fatherProduct->bons()
            ->attach($bon->id, ['discount'=>$bonDiscount]);
        $userbon = factory(Userbon::class)->create([
            'user_id' => $user->id,
            'bon_id' => $bon->id,
            'totalNumber' => 10,
            'usedNumber' => 0
        ]);
        $product1 = factory(Product::class)->create([
            'producttype_id' => 1,
            'grand_id' => $fatherProduct->id
        ]);
        $product2 = factory(Product::class)->create([
            'producttype_id' => 1,
            'grand_id' => $fatherProduct->id
        ]);
        $product3 = factory(Product::class)->create([
            'producttype_id' => 1,
            'grand_id' => $fatherProduct->id
        ]);
        $product4 = factory(Product::class)->create([
            'producttype_id' => 1,
            'grand_id' => $fatherProduct->id
        ]);

        $attribute1 = factory(Attribute::class)->create();
        $attribute2 = factory(Attribute::class)->create();
        $attributevalue11 = factory(Attributevalue::class)->create([
            'attribute_id'=>$attribute1->id
        ]);
        $attributevalue12 = factory(Attributevalue::class)->create([
            'attribute_id'=>$attribute1->id
        ]);
        $attributevalue21 = factory(Attributevalue::class)->create([
            'attribute_id'=>$attribute2->id
        ]);
        $attributevalue22 = factory(Attributevalue::class)->create([
            'attribute_id'=>$attribute2->id
        ]);

        $fatherProduct->children()
            ->attach($product1->id);
        $fatherProduct->children()
            ->attach($product2->id);
        $fatherProduct->children()
            ->attach($product3->id);
        $fatherProduct->children()
            ->attach($product4->id);

        $fatherProduct->attributevalues()
            ->attach($attributevalue11->id);
        $fatherProduct->attributevalues()
            ->attach($attributevalue12->id);
        $fatherProduct->attributevalues()
            ->attach($attributevalue21->id);
        $fatherProduct->attributevalues()
            ->attach($attributevalue22->id);

        $product1->attributevalues()
            ->attach($attributevalue11->id);
        $product1->attributevalues()
            ->attach($attributevalue21->id);
        $product2->attributevalues()
            ->attach($attributevalue12->id);
        $product2->attributevalues()
            ->attach($attributevalue22->id);
        $product3->attributevalues()
            ->attach($attributevalue11->id);
        $product3->attributevalues()
            ->attach($attributevalue22->id);
        $product4->attributevalues()
            ->attach($attributevalue12->id);
        $product4->attributevalues()
            ->attach($attributevalue21->id);

        $fatherProduct->gifts()
            ->attach($gift, ['relationtype_id' => config("constants.PRODUCT_INTERRELATION_GIFT")]);

        $data = [
            /*'order_id' => $orderId,*/
            'product_id' => $fatherProduct->id,
            'products' => [],
            'attribute' => [
                $attributevalue11->id,
                $attributevalue22->id
            ],
            'extraAttribute' => [],
            'withoutBon' => false
        ];

        $response = $this
            ->actingAs($user)
            ->call('POST', 'orderproduct', $data);
        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'product saved'
            ]);
        $this->assertDatabaseHas('orders', [
            'id' => $orderId
        ]);
        $this->assertDatabaseHas('orderproducts', [
            'order_id' => $orderId,
            'product_id' => $product3->id
        ]);
        $this->assertDatabaseHas('orderproducts', [
            'order_id' => $orderId,
            'product_id' => $gift->id
        ]);
        $this->assertDatabaseMissing('orderproducts', [
            'order_id' => $orderId,
            'product_id' => $product1->id
        ]);
        $this->assertDatabaseMissing('orderproducts', [
            'order_id' => $orderId,
            'product_id' => $product2->id
        ]);
        $this->assertDatabaseMissing('orderproducts', [
            'order_id' => $orderId,
            'product_id' => $product4->id
        ]);
        $this->assertDatabaseHas('orderproduct_userbon', [
            'userbon_id' => $userbon->id,
            'discount' => $bonDiscount
        ]);

        $product1->forceDelete();
        $product2->forceDelete();
        $product3->forceDelete();
        $product4->forceDelete();
        $fatherProduct->forceDelete();
        $attribute1->forceDelete();
        $attribute2->forceDelete();
    }
}
