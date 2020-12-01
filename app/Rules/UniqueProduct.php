<?php

namespace App\Rules;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductDiscountItem;
use Illuminate\Contracts\Validation\Rule;

class UniqueProduct implements Rule
{
    public $product;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if ($attribute == 'category') {
            $category = Category::whereUuid($value)->first();

            if ($item = ProductDiscountItem::whereIn('product_id', $category->products->pluck('id'))->first()) {
                $this->product = $item->product;
                return false;
            }
        } else {
            $this->product = Product::whereUuid($value)->first();

            if (ProductDiscountItem::where('product_id', $this->product->id)->first()) {
                return false;
            }
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "The product {$this->product->name} already has a discount.";
    }
}
