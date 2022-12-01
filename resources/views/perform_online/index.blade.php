@extends('layouts.main')
@section('main')
    @php
    if ($day == 0) $day++;
    $forecast = ($order->revenue / $day) * $days;
    $target_revenue = $target->revenue ?? 0;
    $forecast_transaction = $target_revenue == 0 ? 0 : $forecast / $target_revenue;
    $forecast_transaction = round($forecast_transaction, 2) * 100;
    @endphp
    <div class="card">
        <div class="card-body">
            <form method="GET">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-self-center">
                            <input class="form-control" type="month" name="month" value="{{ request()->month }}">
                            <button class="btn btn-primary ml-2 w-25" type="submit">Ganti Bulan</button>
                        </div>
                    </div>
                </div>
            </form>

            <div class="mt-2 mb-4">
                <form action="{{ route('set.target') }}" method="POST">
                    @csrf
                    <input type="hidden" name="month" value="{{ request()->month }}">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>
                                    @if (in_array(Auth()->user()->id, [5, 6, 7]))
                                        <button class="btn btn-primary">Update Target</button>
                                    @else
                                        Target
                                    @endif
                                </th>
                                <th>Total</th>
                                <th>Average</th>
                                <th>Forecast</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Revenue</th>
                                <td width="300px">
                                    <x-input name="revenue" value="{{ rupiah($target->revenue) }}" />
                                </td>
                                <td>{{ rupiah($order->revenue) }}</td>
                                <td>{{ rupiah($order->avg_revenue) }}</td>
                                <td>{{ rupiah($forecast) }}</td>
                            </tr>
                            <tr>
                                <th>Transaction</th>
                                <td>
                                    <x-input name="transaction" value="{{ $target->transaction ?? 0 }}" />
                                </td>
                                <td>{{ $order->transaction }}</td>
                                <td>{{ round($order->avg_transaction) }}</td>
                                <td>{{ $forecast_transaction . '%' }}</td>
                            </tr>
                            <tr>
                                <th>Visitor</th>
                                <td>
                                    <x-input name="visitor" value="{{ $target->visitor ?? 0 }}" />
                                </td>
                                <td>{{ $visit->visitor }}</td>
                                <td>{{ round($visit->avg_visitor) }}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <th>Total Produk</th>
                                <td>
                                    <x-input name="product" value="{{ $target->product ?? 0 }}" />
                                </td>
                                <td>{{ $product }}</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <th>Total Template</th>
                                <td>
                                    <x-input name="template" value="{{ $target->template ?? 0 }}" />
                                </td>
                                <td>{{ $template }}</td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" style="width: auto;">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            @foreach ($orders as $day)
                                <th>{{ $day['day'] }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>Revenue</th>
                            @foreach ($orders as $order)
                                <td>{{ rupiah2($order->revenue) }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <th>Transaction</th>
                            @foreach ($orders as $order)
                                <td>{{ $order->transaction }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <th>Visitor</th>
                            @foreach ($orders as $i => $day)
                                <td>{{ $visits[$i]->visitor }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <th>Produk/hari</th>
                            @foreach ($orders as $i => $day)
                                @php
                                    $zero = true;
                                @endphp
                                @foreach ($products as $product)
                                    @if ($product->day == $day['day'])
                                        <td>{{ $product->product }}</td>
                                        @php
                                            $zero = false;
                                        @endphp
                                    @endif
                                @endforeach
                                @if ($zero)
                                    <td>0</td>
                                @endif
                            @endforeach
                        </tr>
                        <tr>
                            <th>Template/hari</th>
                            @foreach ($orders as $i => $day)
                                @php
                                    $zero = true;
                                @endphp
                                @foreach ($templates as $product)
                                    @if ($product->day == $day['day'])
                                        <td>{{ $product->product }}</td>
                                        @php
                                            $zero = false;
                                        @endphp
                                    @endif
                                @endforeach
                                @if ($zero)
                                    <td>0</td>
                                @endif
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
