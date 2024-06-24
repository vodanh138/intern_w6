<?php
namespace App\Http\Controllers;

use App\Models\product_table;
use App\Models\User;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Services\UserService;


class ShopController1 extends Controller
{
    protected $userService;
    protected $productService;
    public function __construct(UserService $userService, ProductService $productService)
    {
        $this->userService = $userService;
        $this->productService = $productService;
    }
    public function index()
    {
        return view('shop.index');
    }
    public function register()
    {
        return view('shop.register');
    }
    public function RegisterProcessing(Request $request)
    {
        $this->userService->RegisterUser($request);
        return redirect('/');
    }
    public function RegisterProcessingAdmin(Request $request)
    {
        $this->userService->RegisterAdmin($request);
        return redirect('/');
    }
    public function PagingProduct(Request $request)
    {
        $id = '*';
        $data = $this->productService->PagingItem($request, $id);
        return view('product.paging_product', $data);
    }
    public function AddProduct()
    {
        return view('product.add_product');
    }
    public function AddProcessing(Request $request)
    {
        $this->productService->AddItem($request);
        return redirect('/');
    }
    public function delete(product_table $product)
    {
        if ($product->uid == Auth::user()->uid)
            $product->delete();
        else
            return redirect()->back()->with('error', 'You are not allowed to delete this item');
        return redirect('/');
    }
    public function item_info(product_table $product, Request $request)
    {
        if (!$product->exists) {
            return redirect('/')->with('error', 'Product not found.');
        }

        $uidFromUrl = $request->query('uid');
        $owner = false;
        if ($uidFromUrl && $uidFromUrl == $product->uid) {
            $owner = true;
            return view('product.item_info', compact('product', 'owner'));
        }
        $product->view++;
        $product->save();
        return view('product.item_info', compact('product', 'owner'));
    }
    public function edit_item(product_table $product)
    {
        return view('product.edit_item', compact('product'));
    }
    public function update(Request $request, product_table $product)
    {
        $this->productService->UpdateItem($request, $product);
        return view('product.item_info', compact('product'));
    }
    public function login()
    {
        return view('shop.login');
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
    public function LoginProcessing(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string|min:8|regex:/[A-Z]/|regex:/[0-9]/',
        ]);

        $username = md5($request->input('username'));

        if (Auth::attempt(['username' => $username, 'password' => $request->password])) {
            return redirect('/');
        } else {
            return redirect('/login')->with('error', 'Username or Password incorrect');
        }
    }
    public function MyProduct(Request $request)
    {
        if (Auth::check()) {
            $id = Auth::user()->uid;
            $data = $this->productService->PagingItem($request, $id);
            return view('product.my_product', $data);
        } else {
            return redirect('/login')->with('error', 'You need to login to view your products.');
        }
    }
}