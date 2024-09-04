@extends('layouts.main1')

@section('title', 'Guidelines')

@section('header', 'Guidelines Header')

@section('content')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Laravel App')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('storage/css/app1.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>

<body>
<div class="cont-g">
    <div class="box-g">
        <ul>
            <li class="guide-title-1">BICOL UNIVERSITY</li>
            <li class="guide-title-2">PARKING AND TRAFFIC GUIDELINES</li>
            <li class="guide-title-3">ADMINISTRATIVE ORDER #384 S.2021</li>
        </ul>
    </div>
</div>

<div class="cont-g-2">
    <div class="box-g-2">
        <ul>
            <li>Section 3</li>
            <li>Section 4</li>
            <li>Section 5</li>
            <li>Section 6</li>
            <li>Section 7</li>
            <li>Section 8</li>
            <li>Section 9</li>
            <li>Section 10</li>
            <li>Section 11</li>
            <li>Section 12</li>
            <li>Section 13</li>
            <li>Section 14</li>
            <li>Section 15</li>
            <li>Section 16</li>
            <li>Section 17</li>
            <li>Section 18</li>
            <li>Section 19</li>
            <li>Section 20</li>
            <li>Section 21</li>
            <li>Section 22</li>
        </ul>
    </div>
    <div class="box-g-2">
        <h3>PARKING GUIDELINES</h3>
        <h4>Section 3. Designation of Appropriate Parking Space</h4>
        <p>Parking of vehicles is only allowed in designated areas to maintain order and safety within the university premises...</p>
    </div>
</div>

</div>
</body>
@endsection
