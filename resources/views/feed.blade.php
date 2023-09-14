@extends('client.layouts.app')
@section('content')

    <style>
        h3 {
            color: black;
        }

        a {
            color: black;
            text-decoration: none;
        }

        a:hover {
            color: blue;
        }

        .head {
            background-color: #4b54f6;
            color: white;
            padding: 50px;
        }

        h4 {
            color: white;
        }
    </style>

    <div class="container-fluid head">
        <h4><i class="fa fa-rss"></i> RSS Blogs</h4>
    </div>
    <br><br>
    <div class="container">
        Pages
        <ul class="pagination">
            @foreach($allfeedslist as $index=>$count)
                <li class="page-item {{($count->id == $id )? 'active': ''}}"><a class="page-link"
                                                                                href="{{url('feed')}}/{{$count->id}}">{{$index+1}}</a>
                </li>
            @endforeach
        </ul>
        <br><br>
        <div class="content">
            <?php
            $url = $allfeeds->rss_link;

            $invalidurl = false;
            if (@simplexml_load_file($url)) {
                $feeds = simplexml_load_file($url);
            } else {
                $invalidurl = true;
                echo "<h2>Invalid RSS feed URL.</h2>";
            }


            $i = 0;
            if(!empty($feeds)){
            $sitelink = $feeds->channel->link;

            foreach ($feeds->channel->item as $item) {
            $title = $item->title;
            $link = $item->link;
            $description = $item->description;
            $postDate = $item->pubDate;
            $pubDate = date('D, d M Y', strtotime($postDate));
            ?>

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="{{url('public/img/copyrights_default2.jpg')}}" class="rounded-circle" width="100%"
                                 height="300px">
                        </div>

                        <div class="col-md-8">
                            <h3><a class="feed_title" href="<?php echo $link; ?>"><?php echo $title; ?></a></h3>
                            <small><i>{{$allfeeds->rss_title}}</i></small><br>
                            <span><i><?php echo $pubDate; ?></i></span><br><br>

                            <?php echo implode(' ', array_slice(explode(' ', $description), 0, 30)); ?> <br><a
                                class="btn btn-info" href="<?php echo $link; ?>" target="_blank">Read more</a>
                        </div>
                    </div>
                </div>
            </div>
            <br><br>
            <?php
            $i++;
            }
            }else {
                if (!$invalidurl) {
                    echo "<h2>No item found</h2>";
                }
            }
            ?>
            Pages
            <ul class="pagination">
                @foreach($allfeedslist as $index=>$count)
                    <li class="page-item {{($count->id == $id )? 'active': ''}}"><a class="page-link"
                        href="{{url('feed')}}/{{$count->id}}">{{$index+1}}</a>
                    </li>
                @endforeach
            </ul>
            <br><br>
        </div>
@endsection
