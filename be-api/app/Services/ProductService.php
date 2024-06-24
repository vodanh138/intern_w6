<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\product_table;

class ProductService
{
    public function AddItem(Request $request)
    {
        $request->validate([
            'add_name' => 'required|string',
            'add_price' => 'required|integer',
            // 'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = new product_table();
        $product->pname = $request->add_name;
        $product->Price = $request->add_price;
        $product->des = $request->add_des;

        //$product->image = $request->image;
        $product->uid = 1;
        $product->image = "asset/user.png";
        $product->save();
        return $product;
    }
    public function PagingItem(Request $request, $id)
    {
        $num = $request->input('item_num', 8);
        $search = $request->input('search_bar', '');
        $pagee = $request->input('pagee', 1);
        $offset = ($pagee - 1) * $num;
        $sort = $request->input('sort', 'oldest');

        $query = product_table::query()
            ->where('pname', 'like', "%{$search}%");

        if ($id !== '*') {
            $query->where('uid', $id);
        }

        switch ($sort) {
            case 'top':
                $query->orderBy('view', 'desc');
                break;
            case 'least':
                $query->orderBy('view', 'asc');
                break;
            case 'latest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            default:
                $query->orderBy('view', 'desc');
                break;
        }

        $total = $query->count();

        $products = $query
            ->skip($offset)
            ->take($num)
            ->get();

        $pagination = [
            'current_page' => $pagee,
            'per_page' => $num,
            'total' => $total,
            'last_page' => ceil($total / $num)
        ];

        return [
            'products' => $products,
            'pagination' => $pagination
        ];
    }
    public function UpdateItem(Request $request, product_table $product)
    {
        $product->pname = $request->name;
        $product->Price = $request->price;
        $product->save();
        return $product;
    }
}