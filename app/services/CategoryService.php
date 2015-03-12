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

    public static function find($id)
    {
        return Category::find($id);
    }

    public static function get($order, $direction, $offset, $limit)
    {
        return Category::orderBy($order, $direction)->skip($offset)->take($limit)->get();
    }

    public static function create($input)
    {
        $category = new Category;
        $category->name  = array_get($input, 'name',  $category->name);
        $category->description  = array_get($input, 'description',  $category->description);

        $category->save();

        return $category;
    }

    public static function update($category, $input)
    {
        $category->name  = array_get($input, 'name',  $category->name);
        $category->description  = array_get($input, 'description',  $category->description);

        $category->save();
        
        return $category;
    }

    public static function save($category)
    {
        return $category->save();
    }

    public static function delete($category)
    {
        return $category->delete();
    }

    public static function next($category)
    {
        return Category::where('id', '>', $category->id)->orderBy('id', 'asc')->first();
    }

    public static function prev($category)
    {
        return Category::where('id', '<', $category->id)->orderBy('id', 'desc')->first();
    }

    public static function validate($id, $inputs)
    {
        $validationRules = [
            'name'          => ['required', 'unique:categories,name,NULL,id,deleted_at,NULL'],
            'description'   => ['required'],
        ];
        if (isset($id)) {
            $validationRules = [
                'name'      => ['required'],
            ];
        }

        $validationMessages = [
            'name.required'         => Lang::get('validation.categories.name.required'),
            'name.unique'           => Lang::get('validation.categories.name.unique'),
            'description.required'  => Lang::get('validation.categories.description.required'),
        ];

        return Validator::make($inputs, $validationRules, $validationMessages);
    }
}
