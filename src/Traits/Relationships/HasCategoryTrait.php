<?php

namespace Stevebauman\Maintenance\Traits\Relationships;

use Stevebauman\Maintenance\Models\Category;

trait HasCategoryTrait
{
    /**
     * The has one category relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    /**
     * Filters results by specified category.
     *
     * @param mixed      $query
     * @param int|string $categoryId
     *
     * @return mixed
     */
    public function scopeCategory($query, $categoryId = null)
    {
        if ($categoryId) {
            // Get descendants and self inventory category nodes
            $categories = Category::find($categoryId)->getDescendantsAndSelf();

            // Perform a sub-query on main query
            $query->where(function ($query) use ($categories) {
                // For each category, apply a orWhere query to the sub-query
                foreach ($categories as $category) {
                    $query->orWhere('category_id', $category->id);
                }
            });
        }

        return $query;
    }
}