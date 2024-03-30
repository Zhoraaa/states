<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    //
    public function productSave(Request $request)
    {
        // dd($request);
        // $productData = $request->validate([
        //     "name" => "required|unique:products",
        //     "description" => "required",
        //     "cost" => "required|min:1|",
        // ]);
        // dd($request->all());

        if ($request->hasFile('image')) {
            $fileName = time() . '.' . $request->file('image')->extension();
            $imagePath = $request->file('image')->storeAs('public/imgs/products', $fileName);
        }

        if (!$request->product_id) {
            if (!$request->hasFile('image')) {
                $fileName = 'default.png';
            }
            $product_id = Product::insertGetId([
                'name' => $request->name,
                'description' => $request->description,
                'cost' => $request->cost,
                'image' => $fileName,
                'type' => $request->product_type
            ]);
        } else {
            $update['updated_at'] = null;
            if ($request->hasFile('image')) {
                $update['image'] = $fileName;
            }

            $toUPD = $request->toArray();
            $product = Product::find($request->product_id);
            // dd($toUPD);
            $testing = $product->toArray();

            foreach ($testing as $key => $item) {
                switch ($key) {
                    case 'id':
                    case 'image':
                    case 'created_at':
                    case 'updated_at':
                        break;
                    default:
                        if ($toUPD[$key] != $item) {
                            $update[$key] = $toUPD[$key];
                        }
                        break;
                }
            }

            // dd($update);

            $product->update($update);
            $product_id = $request->product_id;
        }

        return redirect()->route('seeProduct', ['id' => $product_id]);
    }
    public function allProducts(Request $request)
    {

        if (!$request->filled('_token')) {
            $products = Product::paginate(4);
        } else {
            $types = array_keys($request->except('_token', 'order_by', 'sequence'));

            $products = DB::table('products')
                ->select()
                ->whereIn('type', $types)
                ->orderBy($request->order_by, $request->sequence)
                ->paginate(4);
        }


        $types = ProductType::all();

        $data = [
            'products' => $products,
            'types' => $types,
        ];

        return view("product.list", compact("data"));
    }
    public function seeProduct($id)
    {
        $product = Product::where("id", $id)->first();

        // dd($product);

        return view("product.only", compact("product"));
    }
    public function productEditor(Request $request)
    {
        $product = Product::find($request->id);
        $pTypes = ProductType::get()->all();
        // dd($pTypes);

        $data = [
            'product' => $product,
            'pTypes' => $pTypes
        ];

        return view("product.editor", compact('data'));
    }
    public function productDelete(Request $request)
    {
        $product = DB::table("products")->where('id', $request->id)->delete();

        return redirect()->route("shop");
    }
}
