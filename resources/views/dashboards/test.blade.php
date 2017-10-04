<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Laravel Filemanager</title>
  <link rel="shortcut icon" type="image/png" href="{{ asset('vendor/laravel-filemanager/img/folder.png') }}">
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
</head>
<body>
    <div class="input-group">
   <span class="input-group-btn">
     <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
       <i class="fa fa-picture-o"></i> Choose
     </a>
   </span>
   <input id="thumbnail" class="form-control" type="text" name="filepath">
 </div>
 <img id="holder" style="margin-top:15px;max-height:100px;">
 <iframe src="/laravel-filemanager" style="width: 100%; height: 500px; overflow: hidden; border: none;"></iframe>
 <script src="/vendor/laravel-filemanager/js/lfm.js"></script>
 <script> $('#lfm').filemanager('file');</script>
</body>
</html>
