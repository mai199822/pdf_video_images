<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <title>Document</title>
</head>

<body>
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th>#</th>
                <th>ID</th>
                <th>Name</th>
                <th>file</th>
                <th>file_thumb</th>
                <th>video</th>
                <th>video_thumb</th>
            </tr>
        </thead>
        <tbody>
            @forelse($forms as $form)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $form->id }}</td>
                <td>{{ $form->name }}</td>
                <td>
                    <a href="{{ asset('storage/' . $form->file) }}" download rel="noopener noreferrer" target="_blank">Download File</a>

                </td>
                <td>
                    <img src="{{ asset('storage/' . $form->file_thumb) }}" alt="">
                </td>
                <td>
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="{{ asset('storage/' . $form->video) }}" allowfullscreen></iframe>
                    </div>
                </td>
                <td>
                    <img src="{{ asset('storage/' . $form->video_thumb) }}" alt="">
                </td>

            </tr>
            @empty
            <tr>
                <td colspan="5">No forms found!</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>