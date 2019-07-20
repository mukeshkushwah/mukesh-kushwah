<?php

namespace App\Http\Controllers;

use App\Product;
use App\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailable;

class ProductController extends Controller
{
      
    public function index()
    {
        $products = Product::latest()->paginate(5);
        return view('index',compact('products'))

            ->with('i', (request()->input('page', 1) - 1) * 5);
    }


    public function create()
    {
        $data  = Country::get();
        return view('create',compact('data'));
    }


    public function store(Request $request)

    {
        $request->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);

        Product::create($request->all());

        return redirect()->route('product.index')

                    ->with('success','Product created successfully.');
    }

    public function show(Product $product)

    {
        return view('show',compact('product'));
    }

   
    public function edit(Product $product)

    {

        return view('edit',compact('product'));
    }


    public function update(Request $request, Product $product)
    {
        $request->validate([

            'name' => 'required',
            'detail' => 'required',
        ]);

        $product->update($request->all());

        return redirect()->route('product.index')

                        ->with('success','Product updated successfully');
    }


    public function destroy(Product $product)
    {   
        $product->delete();
        return redirect()->route('product.index')

                       ->with('success','Product deleted successfully');
    }

    public function mail()
    {
       $name = 'Krunal';
       Mail::to('krunal@appdividend.com')->send(new SendMailable($name));
       
       return 'Email was sent';
    }

    public function getCountries()
    {
        $data  = Country::get();
        return view('edit',compact('data'));
    }

    public function getStates(Request $request)
    {
       $data = State::where('country_id', $request->country_id)->get();
        return response()->json($data);
    }

}
