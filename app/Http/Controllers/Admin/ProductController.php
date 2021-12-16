<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Unit;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\AuditTrail;
use Cache;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public $module = "Product Maintenance";

    public function index()
    {
        $product = new Product;
        $product = $product->readAllProduct();

        if(request()->ajax())
        { 
            return datatables()->of($product)
                ->addColumn('action', function($product)
                {
                    $button = ' <a class="btn btn-sm" data-id="'. $product->id .'" href="'. route('product.edit',$product->id) .'"><i class="fa fa-edit"></i></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a class="btn btn-sm btn-archive-product" data-id="'. $product->id .'"><i  style="color:#DC3545;" class="fa fa-archive"></i></a>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.maintenance.product.index');
    }

    public function cacheProducts() 
    {
        Cache::rememberForever('all_products',  function () {
            $product = new Product;
            return $product->readAllProduct();
        });
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $unit = Unit::where('status', 1)->get();
        $category = Category::where('status', 1)->get();
        $supplier = Supplier::where('status', 1)->get();

        return view('admin.maintenance.product.create',[
            'unit' => $unit, 
            'category' => $category, 
            'supplier' => $supplier
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $at = new AuditTrail;
        $at->audit($this->module, 'Add');

        $this->validateInputs($request);

        $data = $request->all();
        if ($request->hasFile('image')) {
            $data['image'] = $this->imageUpload($request);
        }
        Product::create($data);

        $this->cacheProducts();

        return redirect()->back()
            ->with('success', 'product was created.');
    }

    public function imageUpload($request) 
    {
        $folder_to_save = 'product';
        $image_name = uniqid() . "." . $request->image->extension();
        $request->image->move(public_path('images/' . $folder_to_save), $image_name);
        return $folder_to_save . "/" . $image_name;
    }

    public function validateInputs($request) {
        $request->validate([
            'description' => 'required|:product',
            'qty' => 'required:product',
            'reorder' => 'required:product',
            'orig_price' => 'required:product',
            'category_id' => 'required:product',
            'unit_id' => 'required:product',
            'supplier_id' => 'required:product',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $unit = Unit::where('status', 1)->get();
        $category = Category::where('status', 1)->get();
        $supplier = Supplier::where('status', 1)->get();

        return view('admin.maintenance.product.edit', [
            'product' => $product,
            'unit' => $unit, 
            'category' => $category, 
            'supplier' => $supplier
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $at = new AuditTrail;
        $at->audit($this->module, 'Update');

        $this->validateInputs($request);

        $data = $request->except(['_token', '_method', 'markup']);
        if ($request->hasFile('image')) {
            $data['image'] = $this->imageUpload($request);
        }

        Product::where('id', $id)->update($data);

        $this->cacheProducts();

        return redirect()->back()
            ->with('success', 'Product was updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
