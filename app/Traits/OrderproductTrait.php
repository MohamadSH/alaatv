<?php


namespace App\Traits;


use App\Attribute;
use App\Classes\OrderProduct\RefinementProduct\RefinementFactory;
use App\Collection\OrderproductCollection;
use App\Order;
use App\Orderproduct;
use App\Product;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

trait OrderproductTrait
{
    /**
     * @param array        $data
     * @param User         $user
     * @param Orderproduct $orderProduct
     * @param Product      $product
     */
    private function applyOrderProductBon(array $data, User $user, Orderproduct $orderProduct, Product $product): void
    {
        $bonName = config('constants.BON1');

        $bon = $product->getTotalBons($bonName);

        $canApplyBon = $this->canApplyBonForRequest($data, $product, $bon);
        if (!$canApplyBon) {
            return;
        }

        $userValidBons = $user->userValidBons($bon->first());

        if ($userValidBons->isNotEmpty()) {
            $orderProduct->applyBons($userValidBons, $bon->first());
        }
    }

    /**
     * @param array      $data
     * @param Product    $product
     * @param Collection $bon
     *
     * @return bool
     */
    private function canApplyBonForRequest(array $data, Product $product, Collection $bon): bool
    {
        if (!isset($data['withoutBon']) || !$data['withoutBon']) {
            if ($bon->isEmpty()) {
                return false;
            }

            return $product->canApplyBon($bon->first());
        } else {
            return false;
        }
    }

    /**
     * @param Request $request
     * @param Product $product
     *
     * @return Collection|null
     */
    private function getAttributesValuesFromProduct(Request $request, Product $product): ?Collection
    {
        $extraAttributes   = $request->get('extraAttribute');
        $extraAttributesId = array_column($extraAttributes, 'id');
        $attributesValues  = $product->getAttributesValueByIds($extraAttributesId);

        return $attributesValues;
    }

    /**
     * @param Request    $request
     * @param Collection $attributesValues
     */
    private function syncExtraAttributesCost(Request $request, Collection $attributesValues): void
    {
        $extraAttributes = $request->get('extraAttribute');
        foreach ($attributesValues as $key => $attributesValue) {
            foreach ($extraAttributes as $key1 => $extraAttribute) {
                if ($extraAttribute['id'] == $attributesValue['id']) {
                    $extraAttributes[$key1]['cost']   = $attributesValue->pivot->extraCost;
                    $extraAttributes[$key1]['object'] = $attributesValue;
                }
            }
        }
        $request->offsetSet('extraAttribute', $extraAttributes);
    }

    /**
     * Stores an array of json objects , each containing of an orderproduct info
     *
     * @param         $orderproductJsonObject
     * @param array   $data
     *
     * @return mixed
     */
    private function storeOrderproductJsonObject($orderproductJsonObject, array $data): array
    {
        $grandParentProductId = optional($orderproductJsonObject)->product_id;
        $productIds           = optional($orderproductJsonObject)->products;
        $attributes           = optional($orderproductJsonObject)->attribute;
        $extraAttributes      = optional($orderproductJsonObject)->extraAttribute;

        $orderproductData['product_id']     = $grandParentProductId;
        $orderproductData['products']       = $productIds;
        $orderproductData['attribute']      = $attributes;
        $orderproductData['extraAttribute'] = $extraAttributes;
        $orderproductData['order_id']       = isset($data['order_id']) ? $data['order_id'] : null;

        return $this->new($orderproductData);
    }

    /**
     * Saves a new Orderproduct
     *
     * @param array $data
     *
     * @return array
     */
    private function new(array $data): array
    {
        $report = [
            'status'  => true,
            'message' => [],
            'data'    => [],
        ];

        $data = array_merge([
            'product_id'     => null,
            'order_id'       => null,
            'products'       => null,
            'attribute'      => null,
            'extraAttribute' => null,
            'withoutBon'     => null,
        ], $data);

        $productId = $data['product_id'];
        $orderId   = $data['order_id'];

        try {
            $order   = Order::FindorFail($orderId);
            $product = Product::FindorFail($productId);
        } catch (ModelNotFoundException $e) {
            report($e);
            $report['status']    = false;
            $report['message'][] = 'Unknown order or product';

            return $report;
        }
        $user = $order->user;

        $simpleProducts = (new RefinementFactory($product, $data))->getRefinementClass()->getProducts();

        $notDuplicateProduct = $order->checkProductsExistInOrderProducts($simpleProducts);

        if (count($simpleProducts) != 0 && count($notDuplicateProduct) == 0) {
            $report['status']           = false;
            $report['message'][]        = 'This product has been added to order before';
            $report['data']['products'] = $simpleProducts;
        } else if (count($simpleProducts) == 0) {
            $report['status']           = false;
            $report['message'][]        = 'No products has been selected';
            $report['data']['products'] = $simpleProducts;
        }

        $storedOrderproducts = new OrderproductCollection();
        /**
         * save orderproduct and attach extraAttribute
         */
        foreach ($notDuplicateProduct as $key => $productItem) {
            $orderProduct                      = new Orderproduct();
            $orderProduct->product_id          = $productItem->id;
            $orderProduct->order_id            = $order->id;
            $orderProduct->orderproducttype_id = config('constants.ORDER_PRODUCT_TYPE_DEFAULT');
            if (isset($data['cost'])) {
                $orderProduct->cost = $data['cost'];
            }
            if (!$orderProduct->save()) {
                continue;
            }
            $productItem->decreaseProductAmountWithValue(1);

            if (isset($data['extraAttribute']) && is_array($data['extraAttribute'])) {
                $this->attachExtraAttributes($data['extraAttribute'], $orderProduct);
            }

//            $this->applyOrderProductBon($data, $user, $orderProduct, $productItem);

            $this->applyOrderGifts($order, $orderProduct, $productItem);

            $storedOrderproducts->push($orderProduct);
        }

        $report['data']['storedOrderproducts'] = $storedOrderproducts;

        return $report;
    }

    /**
     * @param array        $extraAttributes
     * @param Orderproduct $orderProduct
     */
    private function attachExtraAttributes(array $extraAttributes, Orderproduct $orderProduct): void
    {
        foreach ($extraAttributes as $value) {
            $orderProduct->attributevalues()
                ->attach($value['id'], [
                    'extraCost' => $value['cost'],
                ]);
        }
    }


    /**
     * @param Collection $attributevalues
     * @param Collection $orderproductAttributevalues
     * @param Collection $extraSelectCollection
     * @param            $attribute
     */
    private function processSelect(Collection $attributevalues, Collection $orderproductAttributevalues, Collection $extraSelectCollection, $attribute): void
    {
        $select         = [];
        $extraCostArray = [];
        foreach ($attributevalues as $attributevalue) {
            if ($orderproductAttributevalues->contains($attributevalue->id)) {
                $extraCost = $orderproductAttributevalues->where('id', $attributevalue->id)
                    ->first()->pivot->extraCost;
            } else {
                $extraCost = null;
            }
            $attributevalueIndex = $attributevalue->name;
            $select              = Arr::add($select, $attributevalue->id, $attributevalueIndex);
            $extraCostArray      = Arr::add($extraCostArray, $attributevalue->id, $extraCost);
        }
        $select[0] = 'هیچکدام';
        $select    = Arr::sortRecursive($select);
        if (!empty($select)) {
            $extraSelectCollection->put($attribute->id, [
                'attributeDescription' => $attribute->displayName,
                'attributevalues'      => $select,
                'extraCost'            => $extraCostArray,
            ]);
        }
    }


    /**
     * @param Collection $attributevalues
     * @param Collection $orderproductAttributevalues
     * @param            $attribute
     * @param Collection $extraCheckboxCollection
     */
    private function processGroupedCheckbox(Collection $attributevalues, Collection $orderproductAttributevalues, $attribute, Collection $extraCheckboxCollection): void
    {
        $groupedCheckbox = collect();
        foreach ($attributevalues as $attributevalue) {
            $attributevalueIndex = $attributevalue->name;
            if ($orderproductAttributevalues->contains($attributevalue->id)) {
                $extraCost = $orderproductAttributevalues->where('id', $attributevalue->id)
                    ->first()->pivot->extraCost;
            } else {
                $extraCost = null;
            }

            $groupedCheckbox->put($attributevalue->id, [
                'index'     => $attributevalueIndex,
                'extraCost' => $extraCost,
            ]);
        }
        if (!empty($groupedCheckbox)) {
            $extraCheckboxCollection->put($attribute->displayName, $groupedCheckbox);
        }
    }


    /**
     * @param Collection $attributevalues
     * @param string     $controlName
     * @param Collection $orderproductAttributevalues
     * @param Collection $extraSelectCollection
     * @param Attribute  $attribute
     * @param Collection $extraCheckboxCollection
     */
    private function processAttrValues(
        Collection $attributevalues,
        string $controlName,
        Collection $orderproductAttributevalues,
        Collection $extraSelectCollection,
        Attribute $attribute,
        Collection $extraCheckboxCollection
    ): void
    {
        if ($attributevalues->isNotEmpty()) {
            switch ($controlName) {
                case 'select':
                    $this->processSelect($attributevalues, $orderproductAttributevalues, $extraSelectCollection, $attribute);
                    break;
                case 'groupedCheckbox':
                    $this->processGroupedCheckbox($attributevalues, $orderproductAttributevalues, $attribute, $extraCheckboxCollection);
                    break;
                default:
                    break;
            }
        }
    }
}
