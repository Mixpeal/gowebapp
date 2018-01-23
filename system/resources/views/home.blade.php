<!DOCTYPE html>  
<html lang="{{ app()->getLocale() }}">

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" type="image/png" sizes="16x16" href="../plugins/images/favicon.png">
<title>Golden Owl</title>
<!-- Bootstrap Core CSS -->
<link href="{{ url('/assets/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
<!-- animation CSS -->
<link href="{{ url('/assets/css/animate.css') }}" rel="stylesheet">
<!-- Custom CSS -->
<link href="{{ url('/assets/css/style.css') }}" rel="stylesheet">
<link href="{{ url('/assets/css/custom.css') }}" rel="stylesheet">
<!-- color CSS -->
<link href="{{ url('/assets/css/colors/default.css') }}" id="theme"  rel="stylesheet">
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body>
    <?php
        if (Session::has('oauth_request_token')){

            $credentials = Twitter::getCredentials();

            if (is_object($credentials) && !isset($credentials->error))
            {
                $feeds = Twitter::getUserTimeline(['count' => 20, 'format' => 'json']);
                $tweets = json_decode($feeds, true);
            }
            else
            {
                return redirect("/feeds");
            }
        }
        else
        {
            return redirect("/feeds");
        }

    ?>
    <nav class="navbar navbar-default navbar-static-top m-b-0">
        <div class="navbar-header">
          <a class="logo" href="{{ url('/home')}}"><b><img height="50px" src="{{ url('/assets/plugins/images/eliteadmin-logo.png') }}" alt="home"></b></a>
          <ul class="nav navbar-top-links navbar-right pull-right">
            <!-- /.dropdown -->
            <li class="dropdown"> <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"> <img src="{{ $tweets[0]['user']['profile_image_url'] }}" alt="user-img" class="img-circle" width="36"><b class="hidden-xs">{{ $tweets[0]['user']['name'] }}</b> </a>
              <ul class="dropdown-menu dropdown-user scale-up">
                <li><a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                         document.getElementById('logout-form').submit();">
                         <i class="fa fa-power-off"></i> Logout
                     </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                 </li>
              </ul>
              <!-- /.dropdown-user -->
            </li>
          </ul>
        </div>
        <!-- /.navbar-header -->
    </nav>





<!-- Preloader -->
<div class="preloader">
  <svg class="circular" viewBox="25 25 50 50">
      <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
  </svg>
</div>
<section id="wrapper" class="myfeeds">
    <div class="row">
        <div class="col-md-3 col-xs-12">
          <div class="white-box">
            <div class="user-bg"> <img alt="user" src="{{ $tweets[0]['user']['profile_background_image_url'] }}" width="100%">
              <div class="overlay-box">
                <div class="user-content"> <a href="javascript:void(0)"><img src="{{ $tweets[0]['user']['profile_image_url'] }}" class="thumb-lg img-circle" alt="img"></a>
                  <h4 class="text-white">{{ $tweets[0]['user']['name'] }}</h4>
                  <h5 class="text-white">@ {{ $tweets[0]['user']['screen_name'] }}</h5>
                </div>
              </div>
            </div>
            <div class="user-btm-box">
              <div class="col-md-12 col-sm-12 text-center">
                <p class="text-blue"><i class="ti-twitter"></i></p>
                <h1>{{ count($tweets) }} Tweets</h1>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-9 col-xs-12">
              <form method="post" action="{{ url('tweet') }}" class="form">
                <div class="input-group m-t-10"> <span class="input-group-btn">
                      <button type="button" class="btn waves-effect waves-light btn-info"><i class="fa fa-twitter"></i></button>
                      </span> 
                      {{ csrf_field() }}
                      <input id="example-input3-group2" name="tweet" class="form-control" placeholder="Tweet" type="text" required="required">
                      <span class="input-group-btn">
                      <button type="submit" class="btn waves-effect waves-light btn-primary">Tweet</button>
                      </span>
                </div>
              </form>
          <div class="white-box">
            <ul class="nav nav-tabs tabs customtab">
              <li class="active tab"><a href="#home" data-toggle="tab"> <span class="visible-xs"><i class="fa fa-home"></i></span> <span class="hidden-xs">Twitter Feeds</span> </a> </li>
              <li class="tab"><a href="#profile" data-toggle="tab"> <span class="visible-xs"><i class="fa fa-user"></i></span> <span class="hidden-xs">My Profile</span> </a> </li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="home">
                <div class="steamline">
                <?php 
                if ($tweets) {
                    foreach ($tweets as $tw) { ?>
                      <div class="sl-item">
                        <div class="sl-left"> <img src="{{ $tw['user']['profile_image_url'] }}" alt="user" class="img-circle"> </div>
                        <div class="sl-right">
                          <div class="m-l-40"><a href="https://twitter.com/{{ $tw['user']['screen_name'] }}" class="text-info">{{ Twitter::linkify($tw['user']['name']) }}</a> @ {{ $tw['user']['screen_name'] }}<span class="sl-date">{{ Twitter::ago($tw['created_at']) }}</span>
                            <p class="m-t-10"> {{ $tw['text'] }} </p>
                            <p><span data-toggle="modal" data-target="#myModal_{{ substr($tw['id_str'], 0, -6) }}" class="model_img img-responsive"><img src="{{ url('/assets/plugins/images/index.png') }}" height="20px"> Retweet</span></p>
                            <div id="myModal_{{ substr($tw['id_str'], 0, -6) }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h4 class="modal-title" id="myModalLabel">Retweet Twitter Posts</h4>
                                  </div>
                                  <div class="modal-body">
                                    <h4>Retweet</h4>
                                    <p>{{ $tw['text'] }}</p>
                                    <form method="post" action="{{ url('retweet') }}" class="form">
                                        <div class="input-group m-t-10"> <span class="input-group-btn">
                                              <button type="button" class="btn waves-effect waves-light btn-info"><i class="fa fa-twitter"></i></button>
                                              </span> 
                                              {{ csrf_field() }}
                                                <input type="hidden" name="id" value="{{ $tw['id'] }}">
                                              <input id="example-input3-group2" name="tweet" class="form-control" placeholder="Write tweet" type="text" required="required">
                                              <span class="input-group-btn">
                                              <button type="submit" class="btn waves-effect waves-light btn-primary">Tweet</button>
                                              </span>
                                        </div>
                                      </form>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Close</button>
                                  </div>
                                </div>
                                <!-- /.modal-content -->
                              </div>
                              <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->
                          </div>

                        </div>
                      </div>
                      <hr>
                    <?php 
                    }
                } 
                else{
                    echo "can't retrieve tweets";
                }?>
                </div>
              </div>
              <div class="tab-pane" id="profile">
                <div class="row">
                  <div class="col-md-3 col-xs-6 b-r"> <strong>Full Name</strong> <br>
                    <p class="text-muted">{{ $tweets[0]['user']['name'] }}</p>
                  </div>
                  <div class="col-md-3 col-xs-6 b-r"> <strong>Username</strong> <br>
                    <p class="text-muted">{{ $tweets[0]['user']['screen_name'] }}</p>
                  </div>
                  <div class="col-md-3 col-xs-6 b-r"> <strong>Url</strong> <br>
                    <p class="text-muted">{{ $tweets[0]['user']['url'] }}</p>
                  </div>
                  <div class="col-md-3 col-xs-6"> <strong>Location</strong> <br>
                    <p class="text-muted">{{ $tweets[0]['user']['location'] }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
</section>
<!-- jQuery -->
<script src="{{ url('/assets/plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap Core JavaScript -->
<script src="{{ url('/assets/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- Menu Plugin JavaScript -->
<script src="{{ url('/assets/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js') }}"></script>

<!--slimscroll JavaScript -->
<script src="{{ url('/assets/js/jquery.slimscroll.js') }}"></script>
<!--Wave Effects -->
<script src="{{ url('/assets/js/waves.js') }}"></script>
<!-- Custom Theme JavaScript -->
<script src="{{ url('/assets/js/custom.min.js') }}"></script>
<!--Style Switcher -->
<script src="{{ url('/assets/plugins/bower_components/styleswitcher/jQuery.style.switcher.js') }}"></script>
</body>
</html>
