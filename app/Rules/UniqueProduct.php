<?php

namespace App\Rules;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductDiscountItem;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;

class UniqueProduct implements Rule
{
    public $product;

    public $category;

    public $discount;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($params = null)
    {
        $this->discount = $params;
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
        if (Str::contains($attribute, 'categories')) {
            $category = Category::whereUuid($value)->first();

            if ($item = ProductDiscountItem::whereIn('product_id', $category->products->pluck('id'))->first()) {
                if ($item->productDiscount->hasExpired()) {
                    return true;
                }

                if ($this->discount && $this->discount->items->contains($item)) {
                    return true;
                }

                $this->category = $category;
                $this->product = $item->product;
                return false;
            }
        } else {
            $this->product = Product::whereUuid($value)->first();

            if ($item = ProductDiscountItem::where('product_id', $this->product->id)->first()) {
                if ($item->productDiscount->hasExpired()) {
                    return true;
                }

                if ($this->discount && $this->discount->items->contains($item)) {
                    return true;
                }

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
        if ($this->category) {
            return "The product {$this->product->name} in {$this->category->name} category already has an active discount.";
        }

        return "The product {$this->product->name} already has an active discount.";
    }
}
