@extends('client.layouts.app')
@section('content')

     <style>

                    h5 {
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

                    h3 {
                        color: white;
                    }
                </style>
    <div class="faq">
        <div class="container">
            <br><br><br>
            <h4 class="text-center"> <i class="fa fa-rss"></i> {{ trans('home/app.whats-new') }}
                <hr>
            </h4>
            <br><br>
            <div class="container">
				 
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
                                        <img src="{{url('public/img/rss_img.png')}}" width="100%" height="300px">
                                    </div>

                                    <div class="col-md-8">
                                        <h5><a class="feed_title" href="<?php echo $link; ?>"><?php echo $title; ?></a>
                                        </h5>
                                        <small><i>{{$allfeeds->rss_title}}</i></small><br>
                                        <span><i><?php echo $pubDate; ?></i></span><br><br>

                                        <?php echo implode(' ', array_slice(explode(' ', $description), 0, 30)); ?> <br><a
                                            class="btn btn-info float-right" href="<?php echo $link; ?>"
                                            target="_blank">{{ trans('home/app.read-more') }}</a>
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
                                                                                                href="{{url('rsslist')}}/{{$count->id}}">{{$index+1}}</a>
                                </li>
                            @endforeach
                        </ul>
                        <br><br>
                    </div>
                </div>

                <br><br>
            </div>
        </div>
@endsection
