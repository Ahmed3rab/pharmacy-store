<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">

    <style>
        .w-full {
            width: 100%
        }

        .w-75 {
            width: 75%;
        }

        .mx-auto {
            margin-left: auto;
            margin-right: auto;
        }

        .text-center {
            text-align: center;
        }

    </style>
</head>

<body class="w-full">

    <div class="w-75 mx-auto">
        <h3>New Order has been created.</h3>

        <p>User: {{ $order->user->name }}</p>
        <p>Order Number: {{ $order->reference_number }}</p>

        <hr>

        <table class="w-full">
            <thead>
                <th>Product</th>
                <th>Quantity</th>
                <th>Item Price</th>
                <th>Total Price</th>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                <tr class="text-center">
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->price }}</td>
                    <td>{{ $item->price * $item->quantity }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <hr>

        <div class="text-center">
            Total: <b>{{  $order->items->sum('total') }}</b>
        </div>

        <div>
            <a href="{{ route('orders.show', $order) }}">Check Order In Dashboard</a>
        </div>
    </div>

    <footer>

    </footer>

</body>

</html>
