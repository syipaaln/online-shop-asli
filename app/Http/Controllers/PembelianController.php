<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\Checkout;
use App\Models\Product;
use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import Facade untuk Auth
use Illuminate\Support\Facades\Log;
// use Barryvdh\DomPDF\Facade\Pdf;
use PDF;

class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function checkoutUser () 
    {
        $userId = Auth::id();

        $cartCount = 0;
        if (Auth::check()) {
            $userId = Auth::id();
            $cartCount = Checkout::where('user_id', $userId)->sum('quantity');
        }

        // Ambil semua checkout berdasarkan user_id
        $checkouts = Checkout::where('user_id', $userId)->get();

        // Ambil semua product_id dari hasil query tersebut
        $productIds = $checkouts->pluck('product_id');

        // Ambil data produk berdasarkan product_id yang sudah didapatkan
        $products = Product::whereIn('id', $productIds)->get();

        // Gabungkan checkout dengan produk terkait
        $checkoutsWithProducts = $checkouts->map(function($checkout) use ($products) {
            $checkout->product = $products->firstWhere('id', $checkout->product_id);
            return $checkout;
        });
        // dd($cartCount);
        return view('user.checkout', compact('checkoutsWithProducts', 'cartCount'));
    }

    public function addToCheckout(Request $request, Product $product)
    {   
        // ambil data id user yang sedang login
        $userId = Auth::id();

        // Simpan data checkout ke dalam session atau database sesuai kebutuhan aplikasi Anda
        $checkout = Checkout::where('product_id', $request->product_id)
        ->where('user_id', $userId)
        ->first();

        if ($checkout) {
        // Jika sudah ada, update quantity
         $checkout->quantity += 1;
            $checkout->save();
        } else {
        // Jika belum ada, buat data baru checkout
            $checkout = new Checkout();
            $checkout->product_id = $request->product_id;
            $checkout->user_id = $userId;
            $checkout->quantity = 1;
            $checkout->save();
        }

        return redirect()->route('userProduct')->with('success', 'Product added to checkout successfully.');
    }

    public function checkoutUpdate (Request $request, $id) {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $checkout = Checkout::findOrFail($id);

        $product = Product::findOrFail($checkout->product_id);

        $newQuantity = $request->input('quantity');

        if ($newQuantity > $product->stock) {
            return redirect()->route('userCheckout')->with(['error' => 'Tidak Boleh Melebihi Stok!']); 
        }

        $checkout->quantity = $newQuantity;
        $checkout->save();

        return redirect()->route('userCheckout')->with(['success' => 'Data Berhasil Dihapus']); 
    }

    public function paymentUser () 
    {
        $userId = Auth::id();
        $users = Auth::user();

        $cartCount = 0;
        if (Auth::check()) {
            $userId = Auth::id();
            $cartCount = Checkout::where('user_id', $userId)->sum('quantity');
        }
    
        // Ambil semua checkout berdasarkan user_id
        $checkouts = Checkout::where('user_id', $userId)->get();
    
        // Ambil semua product_id dari hasil query tersebut
        $productIds = $checkouts->pluck('product_id');
    
        // Ambil data produk berdasarkan product_id yang sudah didapatkan
        $products = Product::whereIn('id', $productIds)->get();
    
        // Inisialisasi array kosong untuk menyimpan hasil checkout dengan informasi produk dan total
        $checkoutsWithProducts = [];
    
        // Deklarasi variabel total
        $total = 0;
    
        // Iterasi setiap checkout untuk menghitung total dan menambahkan informasi produk
        foreach ($checkouts as $checkout) {
            // Ambil produk berdasarkan product_id dari checkout
            $product = $products->where('id', $checkout->product_id)->first();
    
            if ($product) {
                // Hitung total untuk setiap item checkout
                $subtotal = $checkout->quantity * $product->price;
                $total += $subtotal + 20000; // Akumulasi total dengan biaya tambahan 20000
    
                // Tambahkan informasi produk dan subtotal ke dalam array
                $checkoutsWithProducts[] = (object) [
                    'checkout' => $checkout,
                    'product' => $product,
                    'subtotal' => $subtotal,
                ];
            }
        }

        // Inisialisasi array kosong $payments
        $payments = [
            ['type' => 'BCA', 'norek' => '431010101'],
            ['type' => 'BNI', 'norek' => '123456789'],
            ['type' => 'BRI', 'norek' => '987654321'],
        ];
        
        return view('user.payment', compact('checkoutsWithProducts', 'users', 'payments', 'total', 'cartCount'));
    }

    public function paymentBill() {
        $cartCount = 0;
        if (Auth::check()) {
            $userId = Auth::id();
            $cartCount = Checkout::where('user_id', $userId)->sum('quantity');
        }
        $pembelian = Pembelian::where('user_id', $userId)->get();
        $total_bayar = $pembelian->sum('total_harga');
        return view('user.paymentBill', compact('pembelian', 'total_bayar', 'cartCount'));
    }

    public function paymentProcess(Request $request) 
    {
        $userId = Auth::id();

        // Ambil semua data checkout berdasarkan user_id
        $checkouts = Checkout::where('user_id', $userId)->get();

        // Lakukan iterasi untuk setiap checkout dan simpan ke dalam tabel Pembelian
        foreach ($checkouts as $checkout) {
            // Ambil produk dari checkout
            $product = $checkout->product; // Pastikan relasi product sudah didefinisikan di model Checkout
            
            // Hitung total harga pembelian
            $total = $checkout->quantity * $product->price + 20000;

            // Validasi input payment
            $request->validate([
                'payment' => 'required',
            ], [
                'payment.required' => 'Silakan pilih metode pembayaran.',
            ]);
            
            // Simpan data pembelian ke dalam tabel Pembelian
            $pembelian = new Pembelian();
            $pembelian->user_id = $userId;
            $pembelian->product_id = $checkout->product_id; // Sesuaikan dengan relasi produk
            $pembelian->quantity = $checkout->quantity;
            $pembelian->checkout_id = $checkout->id;
            $pembelian->total_harga = $total; // Sesuaikan dengan perhitungan total harga yang Anda inginkan
            $pembelian->status = 'pending';
            $pembelian->payment_type = $request->input('payment'); // Ambil nilai payment dari request
            // Tambahan field lainnya sesuai kebutuhan

            // Simpan data pembelian ke dalam database
            $pembelian->save();

            //Simpan data ke tabel history
            $history = new History();
            $history->user_id = $userId;
            $history->product_id = $checkout->product_id;
            $history->checkout_id = $checkout->id;
            $history->pembelian_id = $pembelian->id;
            $history->price = $total;
            // dd($history);
            $history->save();
        }

        // Optional: Hapus semua checkout setelah berhasil disimpan ke dalam pembelian
        Checkout::where('user_id', $userId)->delete();

        // Redirect atau kembalikan response sesuai kebutuhan
        return redirect()->route('paymentBill')->with('success', 'Pembelian berhasil diproses!');
    }

    public function getUserHistory()
    {
        $userId = Auth::id();
        
        $histories = History::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('created_at'); // Kelompokkan berdasarkan tanggal transaksi
                
        $groupedHistories = $histories->map(function ($group) {
            $totalPrice = $group->sum('price');
            return [
                'products' => $group,
                'total_price' => $totalPrice,
                'date' => $group->first()->created_at
            ];
        });
        
        return view('user.history', ['groupedHistories' => $groupedHistories]);
    }

    public function generateInvoice($date)
    {
        $userId = Auth::id();
        
        // Ambil riwayat transaksi berdasarkan tanggal
        $histories = History::where('user_id', $userId)
            ->where('created_at', $date)
            ->get();

        if ($histories->isEmpty()) {
            return redirect()->route('user.history', ['id' => $userId])->with('error', 'No transaction found for this date.');
        }

        $totalPrice = $histories->sum('price');
        $pdf = PDF::loadView('user.invoice', compact('histories', 'totalPrice', 'date'));
        
        return $pdf->download('invoice_' . str_replace([' ', ':'], '_', $date) . '.pdf');
    }

    public function salesReport()
    {
        // Ambil semua data penjualan dari tabel history dan urutkan berdasarkan tanggal
        $sales = History::orderBy('created_at', 'desc')->get();

        // Kirim data penjualan ke view
        return view('superadmin.salesReport', ['sales' => $sales]);
    }
    public function salesReportAdmin()
    {
        // Ambil semua data penjualan dari tabel history dan urutkan berdasarkan tanggal
        $sales = History::orderBy('created_at', 'desc')->get();

        // Kirim data penjualan ke view
        return view('admin.salesReport', ['sales' => $sales]);
    }

    public function checkout(Request $request)
    {
        $validatedData = $request->validate([
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'customer_name' => 'required|string',
            'customer_address' => 'required|string',
        ]);

        $checkouts = [];
        foreach ($validatedData['items'] as $item) {
            $checkout = new Checkout();
            $checkout->product_id = $item['product_id'];
            $checkout->quantity = $item['quantity'];
            $checkout->save();
            $checkouts[] = $checkout;
        }

        return response()->json(['message' => 'Checkout completed successfully', 'checkouts' => $checkouts], 201);
    }

    public function pembelian(Request $request)
    {
        $validatedData = $request->validate([
            'checkouts' => 'required|array',
            'checkouts.*.id' => 'required|exists:checkouts,id',
            'customer_name' => 'required|string',
            'customer_address' => 'required|string',
        ]);

        foreach ($validatedData['checkouts'] as $checkoutData) {
            $checkout = Checkout::findOrFail($checkoutData['id']);

            $pembelian = new Pembelian();
            $pembelian->product_id = $checkout->product_id;
            $pembelian->quantity = $checkout->quantity;
            $pembelian->customer_name = $validatedData['customer_name'];
            $pembelian->customer_address = $validatedData['customer_address'];
            $pembelian->save();
        }
    }

    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pembelian $pembelian)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pembelian $pembelian)
    {
        //
    }
}