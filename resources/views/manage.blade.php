<html>
<head>
    <title>Admin dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
  </head>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4" style="margin-top:20px;">
                <h4>Welcome - <a href="logout">Logout</a></h4>
                <hr>
                @if(Session::has('success'))
                <div class="alert alert-success">{{Session::get('success')}}</div>
                @endif
                @if(Session::has('failed'))
                <div class="alert alert-danger">{{Session::get('failed')}}</div>
                @endif
                <a href="dashboard" class="btn btn-primary">Dashboard </a>
                <table class="table">
                    <thead>
                        <th>Id</th>
                        <th>Rol name</th>
                        @if ($editrol == true || $deleterol == true)
                            <th>Action</th>
                        @endif
                        @if ($addrol == true)
                            <th><a href="addrol" class="btn btn-success">Add</a></th>
                        @endif
                    </thead>
                    <tbody>
                        @foreach ($rollen as $rol)
                            <tr>
                                <td>{{$rol->id}}</td>
                                <td>{{$rol->name}}</td>
                                <td>
                                @if ($editrol == true)
                                    <a href="editrol/{{$rol->id}}" class="btn btn-warning" style="width:72px;">Edit</a>
                                @endif
                                @if($rol->name == 'admin' || $rol->name == 'user')
                                @else
                                    @if ($deleterol == true)
                                        <a href="deleterol/{{$rol->id}}" class="btn btn-danger" style="width:72px;">Delete</a>
                                    @endif
                                @endif
                            </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</html>
