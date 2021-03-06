<?php

namespace App\Http\Controllers;

use App\Product;
use App\Sensor;
use App\Location;
use Illuminate\Support\Facades\Session;
use Request;
use Auth;
use App\Http\Requests\ProductCreationRequest;
use Illuminate\Support\Collection;

class ProductsController extends Controller
{

    public function apiIndex () {
        return Auth::user()->products()->with('sensors.genericSensor')->get(['products.id', 'version']);
    }

    /**
     * Get the products registered for the current user
     */
    public function index()
    {
        $user_id = Auth::User()->id;
        // @Jan why be working with locations and not products?? We are in the products controller, no?
        $OwnLocations = Location::where('user_id', $user_id)->get();

        return view('products.index', compact('OwnLocations'));
    }

    public function store(ProductCreationRequest $request) {
        $newProduct = Product::create([
            'id' => $request->id,
            'version' => $request->version
        ]);

        foreach ($request->sensors as $generic_sensor_id)
        {
            $newProduct->sensors()->save(
                new Sensor([
                    'generic_sensor_id' => $generic_sensor_id
                ])
            );
        }

        return $newProduct;
    }

    /**
     * Get a specific product
     */
    public function show($id)
    {
        //Get Product to Product ID
        $product=Product::with('location')->findorfail($id);

        return view('products.show',compact('product'));

    }

    /**
     * Check if user input (product ID) is correct and available
     */
    public function check()
    {
        $productId = Request::get('id');
        $userid = Auth::User()->id;

        //Check if another added this device (some location) or you added this(location with your userid)?
        $location = Location::where('product_id', $productId)->first();
        if ($location)
        {
            if ($location->user_id == $userid) {
                \Session::flash('flash_message','This Product is already added to your account');
                return redirect('products');
            }
        }

        //Check if Product already selfregistered/exist
        $product=Product::where('id', $productId)->first();
        if(!$product) {
            \Session::flash('flash_message','There was never a Product that connected to this Webserver with this ID: ' . $productId);
            return redirect('product');
        }
        return view('products.add',compact('product'));
    }

    /**
     * Create a new loaction to connect a product to the current user
     */
    public function add()
    {
        $input = Request::all();
        $userid = Auth::User()->id;

        $location =new Location();
        $location->user_id =$userid;
        $location->product_id = $input['product_id'];
        $location->address = $input['address'];
        $location->zip = $input['zip'];
        $location->city = $input['city'];
        $location->country_code = $input['country_code'];

        $location->save();
        return redirect('/products');
    }

    /**
     * Delete a location to destroy the relationship from a user and product
     */
    public function delete($id)
    {
        $location = Location::find($id);
        $location->delete();
        return redirect('/products');
    }

    /**
     * Change some location attributes
     */
    public function update($locationId)
    {
        $input = Request::all();
        $location = Location::find($locationId);

        $location->address = $input['address'];
        $location->zip = $input['zip'];
        $location->city = $input['city'];
        $location->country_code = $input['country_code'];

        $location->save();

        return redirect('/products/');//.$input['product_id']);
    }
}
