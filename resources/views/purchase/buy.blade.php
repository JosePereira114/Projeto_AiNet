    @extends('layouts.main')

    @section('header-title', 'Buy a Ticket')

    @section('main')
    <style>
        .row {
            display: flex;
            margin-bottom: 10px;
        }

        .seat, .seat_ocupado, .seat_selecionado {
            position: relative;
            width: 50px;
            height: 50px;
            border: 1px solid black;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 5px;
        }

        .seat {
            background-color: white;
            cursor: pointer;
        }

        .seat_ocupado {
            background-color: red;
            cursor: not-allowed;
        }

        .seat_checkbox {
            display: none;
        }

        .seat_checkbox:checked + .seat {
            background-color: green;
            color: white;
        }

        
    </style>
    <div class="flex flex-col space-y-6">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg">
            <div class="max-full">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            Ticket
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-300  mb-6">
                            Click on "Add to Cart" button to add your tickes in cart.
                        </p>
                    </header>

                    <form action="{{ route('cart.add',['screening'=>$screening,'seats'=>'seats[]'])}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mt-6 space-y-4">
                            @foreach($screening->theater->seats->groupBy('row') as $row => $seatsInRow)
                            <div class="row">
                                <div>
                                    <h1>{{ $row }}</h1>
                                </div>
                                @foreach($seatsInRow as $seat)
                                    @if($tickets->contains('seat_id', $seat->id))
                                        <div class="seat_ocupado">
                                            {{ $seat->seat_number }}
                                        </div>
                                    @else
                                        <label>
                                            <input type="checkbox" name="seats[]" value="{{ $seat->id }}" class="seat_checkbox">
                                            <div class="seat">
                                                {{ $seat->seat_number }}
                                            </div>
                                        </label>
                                    @endif
                                @endforeach
                            </div>
                            @endforeach
                        </div>
                        <div class="flex mt-6">
                            <x-button element="submit" type="dark" text="Add To Cart" class="uppercase" />
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
    @endsection
