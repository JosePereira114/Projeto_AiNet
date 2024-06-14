<!DOCTYPE html>
<html>
<head>
    <title>{{ count($screenings) }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            padding: 0;
            background-color: #f9f9f9;
        }
        .container {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #333333;
        }
        .details {
            margin-bottom: 20px;
        }
        .details p {
            font-size: 16px;
            color: #555555;
            margin: 5px 0;
        }
        .highlight {
            font-weight: bold;
            color: #000000;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #aaaaaa;
        }
    </style>
</head>    
    <div class="container">
    @foreach($screenings as $screening)
    @php
    $movie = \App\Models\Movie::where('id', $screening->movie_id)->first();
    @endphp
        <h1>Recibo de Compra do :{{$movie->title}}</h1>
        <div class="details">
            <p><span class="highlight">Data da Compra:</span> {{$date}}</p>
            <p><span class="highlight">Total:</span> {{$total}}€</p>
            <p><span class="highlight">Sessão:</span> {{$screening->id}}</p>  
            <p><span class="highlight">         Em </span> {{$screening->theater->name}}</p>  
            <p><span class="highlight">         Às </span> {{$screening->start_time}}</p>  
            <p><span class="highlight">         Do dia </span> {{$screening->date}}</p>  
            
            <p><span class="highlight">lugar(es):</span> 
            @foreach ($seats as $seat)
            @if($seat->theater_id == $screening->theater_id)
                {{$seat->row}}.{{$seat->seat_number}}
            @endif
            @endforeach 
            </p> 
            <p><span class="highlight">Nome do Cliente:</span> {{$user}}</p>
            <p><span class="highlight">Email do Cliente:</span> {{$email}}</p>
            <p><span class="highlight">Criado em:</span> {{$created_at}}</p>
            <p><span class="highlight">ID da Compra:</span> {{$id}}</p>
        </div>
        
    @endforeach
        <div class="footer">
            <p>Obrigado pela sua compra!</p>
        </div>
    </div>
    @foreach ($tickets as $ticket)
    @php
    $screening = \App\Models\Screening::where('id', $ticket->screening_id)->first();
    $movie = \App\Models\Movie::where('id', $screening->movie_id)->first();
    $seat = \App\Models\Seat::where('id', $ticket->seat_id)->first();
    @endphp
    <div class="container page-break">
    <h1>Ticket to Movie:{{$movie->title}}</h1>
        <div class="details">
            <p><span class="highlight">Sessão:</span> {{$screening->id}}</p>  
            <p><span class="highlight">         Em </span> {{$screening->theater->name}}</p>  
            <p><span class="highlight">         Às </span> {{$screening->start_time}}</p>  
            <p><span class="highlight">         Do dia </span> {{$screening->date}}</p>  
            <p><span class="highlight">lugar:</span> 
                {{$seat->row}}.{{$seat->seat_number}}
            </p> 
            
             <p><span class="highlight">QR Code:</span><img src="{{ route('tickets.qrcode', $ticket->id) }}" alt="QR Code do Ticket"></p>
        </div>
    </div>
    @endforeach

</body>
</html>
