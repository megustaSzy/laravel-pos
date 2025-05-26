@extends('layouts.admin')

@section('content-header', __('dashboard.title'))

@section('content')
<style>
   /* Gaya gambar produk */
   .product-img {
      width: 50px;
      height: 50px;
      object-fit: cover;
      border-radius: 5px;
   }

   /* Posisi icon pada box */
   .small-box .icon {
      top: 10px;
      font-size: 45px;
      opacity: 0.4;
   }

   /* Heading h3 di box */
   .small-box .inner h3 {
      font-size: 1.3rem;
      font-weight: bold;
      margin: 0 0 5px 0;
      display: flex;
      justify-content: flex-end;
      gap: 4px;
      align-items: baseline;
   }

   /* Untuk symbol mata uang agar tidak terlalu besar */
   .small-box .inner h3 span:first-child {
      font-size: 1rem;
   }

   /* Text di dalam box */
   .small-box .inner p {
      font-size: 1rem;
      margin: 0;
   }

   /* Footer link di box */
   .small-box-footer {
      display: block;
      color: #fff;
      padding: 6px 0;
      text-align: center;
      font-weight: 600;
      background: rgba(0,0,0,0.15);
      text-decoration: none;
      border-radius: 0 0 0.25rem 0.25rem;
   }
   .small-box-footer:hover {
      color: #ddd;
      background: rgba(0,0,0,0.25);
   }

   /* Warna background untuk small-box */
   .bg-info {
      background-color: #17a2b8 !important;
   }
   .bg-success {
      background-color: #28a745 !important;
   }
   .bg-danger {
      background-color: #dc3545 !important;
   }
   .bg-warning {
      background-color: #ffc107 !important;
      color: #212529 !important;
   }

   /* Style tabel produk */
   .card.product-list {
      border: 1px solid #e3e6f0;
      border-radius: 0.35rem;
      box-shadow: 0 0.15rem 1.75rem 0 rgba(58,59,69,.15);
   }

   .card.product-list .card-body {
      overflow-x: auto;
      padding: 1rem;
   }

   table.table {
      width: 100%;
      border-collapse: collapse;
      font-size: 0.9rem;
   }

   table.table thead th {
      background-color: #f8f9fa;
      font-weight: 600;
      padding: 8px;
      border: 1px solid #dee2e6;
      vertical-align: middle;
   }

   table.table tbody td {
      padding: 8px;
      border: 1px solid #dee2e6;
      vertical-align: middle;
   }

   /* Badge status */
   .badge-success {
      background-color: #28a745;
      color: white;
      padding: 4px 8px;
      border-radius: 10px;
      font-size: 0.85rem;
      font-weight: 600;
      display: inline-block;
   }

   .badge-danger {
      background-color: #dc3545;
      color: white;
      padding: 4px 8px;
      border-radius: 10px;
      font-size: 0.85rem;
      font-weight: 600;
      display: inline-block;
   }
</style>

<div class="container-fluid">
   <!-- Info boxes -->
   <div class="row">
      <div class="col-lg-3 col-6">
         <div class="small-box bg-info">
            <div class="inner">
               <h3>{{ $orders_count }}</h3>
               <p>{{ __('dashboard.Orders_Count') }}</p>
            </div>
            <div class="icon">
               <i class="ion ion-bag"></i>
            </div>
            <a href="{{ route('orders.index') }}" class="small-box-footer">
               {{ __('common.More_info') }} <i class="fas fa-arrow-circle-right"></i>
            </a>
         </div>
      </div>

      <div class="col-lg-3 col-6">
         <div class="small-box bg-success">
            <div class="inner">
               <h3>
                  <span>{{ config('settings.currency_symbol') }}</span> 
                  <span>{{ number_format($income, 2) }}</span>
               </h3>
               <p>{{ __('dashboard.Income') }}</p>
            </div>
            <div class="icon">
               <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{ route('orders.index') }}" class="small-box-footer">
               {{ __('common.More_info') }} <i class="fas fa-arrow-circle-right"></i>
            </a>
         </div>
      </div>

      <div class="col-lg-3 col-6">
         <div class="small-box bg-danger">
            <div class="inner">
               <h3>
                  <span>{{ config('settings.currency_symbol') }}</span> 
                  <span>{{ number_format($income_today, 2) }}</span>
               </h3>
               <p>{{ __('dashboard.Income_Today') }}</p>
            </div>
            <div class="icon">
               <i class="ion ion-pie-graph"></i>
            </div>
            <a href="{{ route('orders.index') }}" class="small-box-footer">
               {{ __('common.More_info') }} <i class="fas fa-arrow-circle-right"></i>
            </a>
         </div>
      </div>

      <div class="col-lg-3 col-6">
         <div class="small-box bg-warning">
            <div class="inner">
               <h3>{{ $customers_count }}</h3>
               <p>{{ __('dashboard.Customers_Count') }}</p>
            </div>
            <div class="icon">
               <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('customers.index') }}" class="small-box-footer">
               {{ __('common.More_info') }} <i class="fas fa-arrow-circle-right"></i>
            </a>
         </div>
      </div>
   </div>

   <!-- Product Tables -->
   <div class="row">
      @php
         $productSections = [
            ['title' => 'Low Stock Product', 'data' => $low_stock_products],
            ['title' => 'Hot Products', 'data' => $current_month_products],
            ['title' => 'Hot Products of the year', 'data' => $past_months_products],
            ['title' => 'Best Selling Products', 'data' => $best_selling_products],
         ];
      @endphp

      @foreach ($productSections as $section)
      <div class="col-6 my-4">
         <h3>{{ $section['title'] }}</h3>
         <section class="content">
            <div class="card product-list">
               <div class="card-body">
                  <table class="table table-bordered table-hover">
                     <thead class="thead-light">
                        <tr>
                           <th>ID</th>
                           <th>Name</th>
                           <th>Image</th>
                           <th>Barcode</th>
                           <th>Price</th>
                           <th>Quantity</th>
                           <th>Status</th>
                           <th>Updated At</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach ($section['data'] as $product)
                        <tr>
                           <td>{{ $product->id }}</td>
                           <td>{{ $product->name }}</td>
                           <td><img class="product-img" src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}"></td>
                           <td>{{ $product->barcode }}</td>
                           <td>{{ number_format($product->price, 2) }}</td>
                           <td>{{ $product->quantity }}</td>
                           <td>
                              <span class="badge badge-{{ $product->status ? 'success' : 'danger' }}">
                                 {{ $product->status ? __('common.Active') : __('common.Inactive') }}
                              </span>
                           </td>
                           <td>{{ $product->updated_at->format('d M Y') }}</td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
            </div>
         </section>
      </div>
      @endforeach
   </div>
</div>
@endsection
