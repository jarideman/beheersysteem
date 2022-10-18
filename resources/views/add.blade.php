<html>
<head>
    <title>Add user</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
  </head>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4" style="margin-top:20px;">
                <h4>Add user - <a href="admin_dashboard">Go back</a></h4>
                <hr>
                <form action="{{route('add')}}" method="post">
                @if(Session::has('success'))
                <div class="alert alert-success">{{Session::get('success')}}</div>
                @endif
                @if(Session::has('failed'))
                <div class="alert alert-danger">{{Session::get('failed')}}</div>
                @endif
                @csrf
                    <div class="form-group">
                        <label for="name">Full name</label>
                        <input type="text" class="form-control" placeholder="Enter full name" name="name" value="{{old('name')}}">
                        <span class="text-danger">@error('name') {{$message}} @enderror</span>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" placeholder="Email" name="email" value="{{old('email')}}">
                        <span class="text-danger">@error('email') {{$message}} @enderror</span>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" placeholder="Password" name="password" value="">
                        <span class="text-danger">@error('password') {{$message}} @enderror</span>
                    </div>
                    @if ($test == true)
                    <div class="form-group">
                        <label for="rol">Rol</label>
                        <select class="form-select" name="rol_id">
                            <option disabled selected value>--Select an option--</option><br>
                            @foreach ($rollen as $rol)

                                <option value="{{ $rol["id"] }}">{{ $rol['name'] }}</option><br>
                            @endforeach

                        </select>
                        <span class="text-danger">@error('rol') {{$message}} @enderror</span>
                        
                    </div>
                    @endif
                    <div class="form-group">
                        <button class="btn btn-block btn-primary" type="submit">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</html>
