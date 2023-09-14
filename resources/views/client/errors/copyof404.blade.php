<!DOCTYPE html>
<html>
<head>
    <title>Page Not Found</title>
    <link rel="stylesheet" href="{{ asset('public/assets/css/bootstrap.min.css') }}">
    <style>
        .page_404 {
            margin-left: 140px;
            padding: 150px 0;
            background: #fff;
            font-family: 'Arvo', serif;
        }

        .page_404 img {
            width: 100%;
        }

        .four_zero_four_bg {
            background-image: url(https://cdn.dribbble.com/users/285475/screenshots/2083086/dribbble_1.gif);
            height: 400px;
            background-position: center;
        }

        .four_zero_four_bg h1 {
            font-size: 80px;
        }

        .four_zero_four_bg h3 {
            font-size: 80px;
        }

        .link_404 {
            color: #fff !important;
            padding: 10px 20px;
            background: #4B57FF;
            margin: 20px 0;
            display: inline-block;
        }

        .content_box_404 {
            margin-top: -50px;
        }
    </style>
</head>
<body>
<section class="page_404">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 ">
                <div class="col-sm-10 col-sm-offset-1  text-center">
                    <div class="four_zero_four_bg">
                        <h1 class="text-center">404</h1>
                    </div>
                    <div class="content_box_404">
                        <h3 class="h2">
                            Look like you're lost
                        </h3>
                        <p>the page you are looking for not available!</p>
                        <a href="{{url('/')}}" class="link_404">Go to Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>
