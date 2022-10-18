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
                @if ($manage == true)
                    <a href="manage" class="btn btn-primary">Manage permissions</a>
                @endif
                <table class="table">
                    <thead>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Rol</th>
                        @if ($edit == true || $delete == true)
                            <th>Action</th>
                        @endif
                        @if ($add == true)
                            <th><a href="add" class="btn btn-success">Add</a></th>
                        @endif
                    </thead>
                    <tbody>
                    @foreach ($info as $data)
                        <tr>
                            <td>{{$data->name}}</td>
                            <td>{{$data->email}}</td>
                            <td>{{implode(json_decode($rollen->where('id', '=', $data->rol_id)->pluck('name')));}}</td>
                            <td>
                                @if ($edit == true)
                                    <a href="edit/{{$data->id}}" class="btn btn-warning" style="width:72px;">Edit</a>
                                @endif
                                @if ($delete == true)
                                    <a href="delete/{{$data->id}}" class="btn btn-danger" style="width:72px;">Delete</a>
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
