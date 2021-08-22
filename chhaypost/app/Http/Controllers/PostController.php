<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\Post;

class PostController extends AbstractController
{
    /**
     * CompanyController constructor.
     */

    public function __construct()
    {
        $this->module = 'post';
        $this->modelClass = Post::class;
        $this->resourceClass = PostResource::class;
        $this->collectionClass = PostCollection::class;

        // $this->buildPermission($this->module);
        $this->dbRelations = [];

        $this->validation = [[
            'title' => 'required'
        ],[],[
            'title' => trans('post.post')
        ]];
    }
    /**
     * Used to get Pre Requisite for Company Publish Policy Module
     * @get ("/api/company-publish-policy/pre-requisite")
     * @return Response
     */

    public function preRequisite()
    {
        $post = Post::pluck('title', 'id');
        $data = generateSelectOption($post);

        return $this->success(compact('data'));
    }

    //Implement method
    
    public function fillCreate($model, $request=null)
    {

    }
    public function fillUpdate($model, $request=null)
    {

    }
    public function beforeSave($model, $request=null, $id=null)
    {

    }
    public function afterSave($model, $request=null, $id=null)
    {
        
    }
}
