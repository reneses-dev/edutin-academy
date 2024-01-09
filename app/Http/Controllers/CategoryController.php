<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

use function PHPUnit\Framework\isNull;

class CategoryController extends Controller
{

    public function __construct(){
        $this->middleware('can:categories.index')->only('index');
        $this->middleware('can:categories.create')->only('create', 'store');
        $this->middleware('can:categories.edit')->only('edit', 'update');
        $this->middleware('can:categories.destroy')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::orderBy('id', 'desc')->simplePaginate(8);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $category = $request->all();

        if ($request->hasFile('image')) {
           $category['image'] = $request->file('image')->store('categories');
        }

        Category::create($category);

        return redirect()->route('categories.index')->with('success', 'Category created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        if ($request->hasFile('image')) {
            File::delete(public_path('storage/'.$category->image));
        }

        //$category['image'] = $request->file('image')->store('categories');
        //var_dump($request->file('image'));
        if (!isNull($request->file('image'))) {
            $category['image'] = $request->file('image')->store('categories');
        }

        $category->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'status' => $request->status,
            'is_featured' => $request->is_featured,
        ]);

        return redirect()->route('categories.index')->with('success-update', 'Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if ($category->image) {
            File::delete(public_path('storage/'.$category->image));
        }

        $category->delete();

        return redirect()->route('categories.index')->with('success-delete', 'Category deleted successfully');
    }

    public function detail(Category $category){
        $this->authorize('published', $category);
        $articles = Article::where([
            'category_id' => $category->id,
            'status' => 1
        ])->orderBy('id', 'desc')->simplePaginate(4);

        $navbar = Category::where([
            'status' => 1,
            'is_featured' => 1
        ])->paginate(4);

        return view('subscriber.categories.detail', compact('category', 'articles', 'navbar'));
    }
}
