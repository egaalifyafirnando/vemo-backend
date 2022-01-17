@extends('layouts.app', ['title' => 'Detail Order'])

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid mb-5">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold"><i class="fas fa-shopping-cart"></i> DETAIL ORDER</h6>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <td style="width: 25%">NO. INVOICE</td>
                                <td style="width: 1%">:</td>
                                <td>{{ $invoice->invoice }}</td>
                            </tr>
                            <tr>
                                <td>NAMA LENGKAP</td>
                                <td>:</td>
                                <td>{{ $invoice->name }}</td>
                            </tr>
                            <tr>
                                <td>NO. TELP / WA</td>
                                <td>:</td>
                                <td>{{ $invoice->phone }}</td>
                            </tr>
                            <tr>
                                <td>KURIR / SERVICE / COST</td>
                                <td>:</td>
                                <td>{{ $invoice->courier }} / {{ $invoice->service }} /
                                    {{ moneyFormat($invoice->cost_courier) }}</td>
                            </tr>
                            <tr>
                                <td>ALAMAT LENGKAP</td>
                                <td>:</td>
                                <td>{{ $invoice->address }}</td>
                            </tr>
                            <tr>
                                <td>TOTAL PEMBELIAN</td>
                                <td>:</td>
                                <td>{{ moneyFormat($invoice->grand_total) }}</td>
                            </tr>
                            <tr>
                                <td>CATATAN PESANAN</td>
                                <td>:</td>
                                <td>{{ $invoice->product_message }}</td>
                            </tr>
                            <tr>
                                <td>STATUS</td>
                                <td>:</td>
                                <td>{{ $invoice->status }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="card border-0 rounded shadow mt-4">
                    <div class="card-body">
                        <h5><i class="fa fa-shopping-cart"></i> DETAIL ITEM</h5>
                        <hr>
                        <div class="row pb-3">
                            @foreach ($invoice->orders()->get() as $product)
                                <div class="col-4">
                                    <div class="wrapper-image-cart">
                                        <img src="{{ $product->image }}" style="width: 100%;border-radius: .5rem" />
                                    </div>
                                </div>
                                <div class="col-8">
                                    <h5>
                                        <b style="font-size: 1.1rem">{{ $product->product_name }}</b>
                                    </h5>
                                    <p class="m-0" style="font-size: 1rem">
                                        Rp. {{ moneyFormat($product->price) }}
                                    </p>
                                    <p class="m-0" style="font-size: 1rem">
                                        Jumlah : {{ $product->qty }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
@endsection
