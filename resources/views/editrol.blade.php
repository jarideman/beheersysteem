<html>
<head>
    <title>Edit user</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
  </head>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4" style="margin-top:20px;">
                <h4>Edit rol - <a href="../manage">Go back</a></h4>
                <hr>
                <form action="{{ route('editrol.store', $rollen->id) }}" method="POST" > 
                    @csrf

                    <div class="row"> 
                        <div class="col-xs-12 col-sm-12 col-md-12"> 
                            <div class="form-group"> 
                                <strong>Name:</strong>                               
                                <input type="text" name="name" class="form-control" value="{{$rollen->name}}">
                            </div> 
                        </div> 

                        <div class="col-xs-12 col-sm-12 col-md-12"> 
                            <div class="form-group">
                                <strong>Permissions:</strong>                               
                                <p><?=$test?></p>                               
                            </div> 
                        </div> 

                        <div class="col-xs-12 col-sm-12 col-md-12 text-center"> 
                            <button type="submit" class="btn btn-primary">Submit</button>  
                        </div> 
                    </div> 
                </form> 
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</html>
