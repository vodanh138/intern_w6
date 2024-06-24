<?php
namespace App\Http\Controllers;

use App\Models\product_table;
use App\Services\ProductService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
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
        return response()->json();
    }
    public function RegisterProcessing(Request $request)
    {
        $response = $this->userService->RegisterUser($request);
        return response()->json($response);
    }

    public function RegisterProcessingAdmin(Request $request)
    {
        $response = $this->userService->RegisterAdmin($request);
        return response()->json($response);
    }

    public function PagingProduct(Request $request)
    {
        $id = $request->input('id','*');
        $data = $this->productService->PagingItem($request, $id);
        return response()->json($data);
    }

    public function AddProcessing(Request $request)
    {
        $response = $this->productService->AddItem($request);
        return response()->json($response);
    }

    public function delete(product_table $product)
    {
        $product->delete();
        return response()->json(['message' => 'Product deleted successfully']);
    }

    public function item_info(product_table $product, Request $request)
    {
        if (!$product->exists) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $uidFromUrl = $request->query('uid');
        $owner = false;
        if ($uidFromUrl && $uidFromUrl == $product->uid) {
            $owner = true;
        }

        $product->view++;
        $product->save();

        return response()->json($product);
    }

    public function update(Request $request, product_table $product)
    {
        $response = $this->productService->UpdateItem($request, $product);
        return response()->json($response);
    }

    public function LoginProcessing(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string|min:8|regex:/[A-Z]/|regex:/[0-9]/',
        ]);

        $username = md5($request->input('username'));

        if (Auth::attempt(['username' => $username, 'password' => $request->password])) {
            return response()->json(['message' => 'Login successful']);
        } else {
            return response()->json(['error' => 'Username or Password incorrect'], 401);
        }
    }

    public function MyProduct(Request $request)
    {
        if (Auth::check()) {
            $id = Auth::user()->uid;
            $data = $this->productService->PagingItem($request, $id);
            return response()->json($data);
        } else {
            return response()->json(['error' => 'You need to login to view your products'], 401);
        }
    }

    public function logout()
    {
        Auth::logout();
        return response()->json(['message' => 'Logged out successfully']);
    }
}
