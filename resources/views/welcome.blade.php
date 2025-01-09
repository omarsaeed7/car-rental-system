<html>

<head>

</head>
<body>

    @foreach ($cars as $car )
            <h1>{{$car->name}}</h1>
    @endforeach
</body>
</html>