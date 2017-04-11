<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>


        <link href="http://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css">

        <link href="http://getbootstrap.com/examples/jumbotron/jumbotron.css" rel="stylesheet" type="text/css">

    </head>
    <body>



      <div class="container">
     <div class="header clearfix">

       <h3 class="text-muted"> <?= $name ?> Demo</h3>
     </div>

     <div class="row marketing">
       <div class="col-lg-6">
         <h4>Instructions</h4>
         <ol>
           <li> Run <code>php artisan migrate</code> to create the db schema or run the <code>chat.sql</code> file to have data prepopulated.</li>

           <li>Run the Laravel app using Valet or run <code>php artisan serve</code> to your localhost.</li>

           <li>Insert a user in your user table or login using the default user (email: alex@orainteractive.com, psw: secret ). All passwords are hashed so if you need to manually add a new user to the db, use  <code>Hash::make()</code>, before adding it. </li>

           <li>Besides the <code>/api/auth/login</code>, all the other resorces use JWT for validation, so make sure to send in the header the token received when you first login. It should be something like: <strong>Authorization</strong> <i>Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJp [...]</i></li>

           <li>Start making requests just as specified in <a href="http://docs.oracodechallenge.apiary.io">http://docs.oracodechallenge.apiary.io</a>, version 5.0. </li>
         </ol>
       </div>

       <div class="col-lg-6">
         <h4>Resources</h4>
         <ul>
         @foreach ($resources as $resource)
           <li> {{$resource}} </li>
         @endforeach
       </ul>
       </div>
     </div>

     <footer class="footer">
       <p></p>
     </footer>

   </div> <!-- /container -->
    </body>
</html>
