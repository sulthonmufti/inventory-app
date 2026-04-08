<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator; 
use OpenApi\Attributes as OA;

#[OA\Info(
    title: "Inventory System API",
    version: "1.0.0",
    description: "Dokumentasi API untuk Manajemen Katalog Produk"
)]
#[OA\Server(
    url: "http://localhost:8000",
    description: "Server Lokal"
)]
class ProductController extends Controller
{
    #[OA\Get(
        path: "/api/products",
        summary: "Mengambil daftar produk dengan filter wajib",
        tags: ["Products"],
        parameters: [
            // Inilah cara membuat parameter REQUIRED di Swagger
            new OA\Parameter(
                name: "category",
                in: "query",
                required: true, // Menandakan wajib diisi
                description: "Kategori produk (contoh: Elektronik, Pakaian)",
                schema: new OA\Schema(type: "string")
            ),
            new OA\Parameter(
                name: "min_price",
                in: "query",
                required: false, // Ini contoh jika opsional
                description: "Harga minimal",
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(response: 200, description: "Berhasil"),
            new OA\Response(response: 422, description: "Parameter wajib tidak diisi")
        ]
    )]
    public function index(Request $request)
    {
        // 1. Validasi tetap wajib ada kategori
        $validator = Validator::make($request->all(), [
            'category' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Silakan masukkan parameter category',
                'errors' => $validator->errors()
            ], 422);
        }

        // 2. LOGIKA BARU: Cek apakah inputnya adalah 'all'
        if ($request->category === 'all') {
            // Jika 'all', ambil semua tanpa filter
            $products = Product::all();
        } else {
            // Jika bukan 'all' (misal: 'Elektronik'), baru filter berdasarkan kategori itu
            $products = Product::where('category', $request->category)->get();
        }

        return response()->json([
            'status' => 'success',
            'message' => "Data produk kategori " . $request->category . " berhasil ditarik",
            'data' => $products
        ], 200);
    }

    #[OA\Post(
        path: "/api/products",
        summary: "Menambah produk baru ke database",
        tags: ["Products"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["name", "sku", "price"],
                properties: [
                    new OA\Property(property: "name", type: "string", example: "Kaos Oversize"),
                    new OA\Property(property: "sku", type: "string", example: "TS-001"),
                    new OA\Property(property: "price", type: "integer", example: 75000),
                    new OA\Property(property: "stock", type: "integer", example: 10)
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: "Produk Berhasil Dibuat"),
            new OA\Response(response: 422, description: "Data Tidak Valid / SKU Sudah Ada")
        ]
    )]
    public function store(Request $request)
    {
        // 2. Gunakan Validator::make secara manual
        $validator = Validator::make($request->all(), [
            'name'  => 'required|string|max:255',
            'sku'   => 'required|string|unique:products,sku',
            'price' => 'required|numeric', // Akan menolak jika diisi teks
            'category' => 'required|string',
            'stock' => 'nullable|integer'
        ]);

        // 3. Cek jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi Gagal',
                'errors' => $validator->errors() // Ini akan mengirim detail field yang salah
            ], 422); // Status 422 khusus untuk error data input
        }

        // 4. Jika lolos validasi, simpan data
        $product = Product::create($validator->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Produk berhasil ditambahkan',
            'data' => $product
        ], 201);
    }

    #[OA\Delete(
        path: "/api/products/{id}",
        summary: "Menghapus produk berdasarkan ID",
        tags: ["Products"],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "ID Produk yang ingin dihapus",
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(response: 200, description: "Produk berhasil dihapus"),
            new OA\Response(response: 404, description: "Produk tidak ditemukan")
        ]
    )]
    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Produk tidak ditemukan'
            ], 404);
        }

        $product->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Produk berhasil dihapus'
        ], 200);
    }

    #[OA\Put(
        path: "/api/products/{id}",
        summary: "Mengupdate data produk",
        tags: ["Products"],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "ID Produk yang ingin diupdate",
                schema: new OA\Schema(type: "integer")
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "name", type: "string", example: "Hoodie Edit"),
                    new OA\Property(property: "category", type: "string", example: "Clothing"),
                    new OA\Property(property: "price", type: "integer", example: 150000),
                    new OA\Property(property: "stock", type: "integer", example: 20)
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Update Berhasil"),
            new OA\Response(response: 404, description: "Produk Tidak Ditemukan"),
            new OA\Response(response: 422, description: "Validasi Gagal")
        ]
    )]
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['status' => 'error', 'message' => 'Produk tidak ditemukan'], 404);
        }

        $validated = $request->validate([
            'name'     => 'sometimes|string|max:255',
            'category' => 'sometimes|string',
            'price'    => 'sometimes|numeric',
            'stock'    => 'sometimes|integer'
        ]);

        $product->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil diupdate',
            'data' => $product
        ], 200);
    }
}