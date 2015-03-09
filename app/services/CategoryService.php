<?php

class CategoryService extends BaseService
{
    public static function getDataList()
    {
        $dataList = [];
        $categories = CategoryService::getall();
        foreach ($categories as $category) {
            $dataList[$category->id] = $category->name;
        }

        return $dataList;
    }

    public static function getAll()
    {
        return Category::all();
    }
    public static function getName($categoryId)
    {
        $category = Category::find($categoryId);
        if (!empty($category->name)) {
            return $category->name;
        }

        return;
    }
}
