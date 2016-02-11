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
        $Locations = collect(Location::all());
        $OwnLocations = $Locations->filter(function($item) use($user_id) {
            return $item->user_id == $user_id;
        });

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
        $product=Product::findorfail($id);

        //Get Location to Product ID
        $location = $this->getLocation($id);
        return view('products.show',compact('product'),compact('location'));

    }

    private function getLocation($productId)
    {
        $AllLocations = collect(Location::all());
        $location = $AllLocations->where('product_id',$productId)->first();
        if(count($location))
            return $location;
        else
            return null;
    }

    /**
     * Check if user input (product ID) is correct and available
     */
    public function check()
    {
        $productId = Request::get('id');
        $userid = Auth::User()->id;

        //Check if another added this device (some location) or you added this(location with your userid)?
        $location = $this->getLocation($productId);
        if ($location)
        {
            if ($location->user_id == $userid) {
                \Session::flash('flash_message','This Product is already added to your account');
                return redirect('products');
            }
        }

        //Check if Product already selfregistered/exist
        $products=Product::find($productId);
        if(!$products) {
            \Session::flash('flash_message','There was never a Product that connected to this Webserver with this ID: ' . $productId);
            return redirect('products');
        }
        return view('products.add',compact('products'));
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
