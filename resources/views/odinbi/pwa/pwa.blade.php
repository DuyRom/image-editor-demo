<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="author" content="DuyRNT">
    <title>Odinbi PWA Install</title>
    <link rel="apple-touch-icon" href="https://odinbi.com/wp-content/uploads/2022/04/cropped-icon_2-32x32.png">
    <link rel="shortcut icon" type="image/x-icon" href="https://odinbi.com/wp-content/uploads/2022/04/cropped-icon_2-32x32.png">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="/pwa/assets/css/vendors.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="/pwa/assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="/pwa/assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="/pwa/assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="/pwa/assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="/pwa/assets/css/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="/pwa/assets/css/semi-dark-layout.css">

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="horizontal-layout horizontal-menu 2-columns  navbar-floating footer-static  " data-open="hover" data-menu="horizontal-menu" data-col="2-columns">

    <!-- BEGIN: Header-->
    <nav class="header-navbar navbar-expand-lg navbar navbar-with-menu navbar-fixed navbar-shadow navbar-brand-center">
        <div class="navbar-header d-xl-block d-none">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item"><a class="navbar-brand" href="https://odinbi.com/wp-content/uploads/2022/04/cropped-icon_2-32x32.png">
                        <div class="brand-logo"></div>
                    </a></li>
            </ul>
        </div>
        <div class="navbar-wrapper">
            <div class="navbar-container content">
                <div class="navbar-collapse" id="navbar-mobile">
                    <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                       
                    </div>
                    <ul class="nav navbar-nav float-right">
                        <li class="dropdown dropdown-user nav-item"><a class="nav-link dropdown-user-link" href="{{request()->getSchemeAndHttpHost()}}">
                                <div class="user-nav d-sm-flex d-none"><span class="user-name text-bold-600">Odinbi</span><span class="user-status">PWA INSTALL</span></div><span><img class="round" src="https://odinbi.com/wp-content/uploads/2022/04/cropped-icon_2-32x32.png" alt="avatar" height="40" width="40"></span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- END: Header-->


    <!-- BEGIN: Main Menu-->

    <!-- END: Main Menu-->

    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-body" >
                <!-- Basic Horizontal form layout section start -->
                <section id="basic-horizontal-layouts">
                    <div class="row match-height">
                        <div class="col-md-12 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">PWA INSTALL</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form class="form form-horizontal" method="POST" action="{{ route('pwa.update') }}" enctype="multipart/form-data">
                                        @csrf
                                        @method('put')
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>App name</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" name="name" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ $pwa->data['manifest']['name'] ?? '' }}" required>
                                                                  @if ($errors->has('name'))
                                                                      <span class="invalid-feedback" role="alert">
                                                                          <strong>{{ $errors->first('name') }}</strong>
                                                                      </span>
                                                                  @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>App Short name</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                               <input type="text" name="short_name" class="form-control {{ $errors->has('short_name') ? ' is-invalid' : '' }}" value="{{ $pwa->data['manifest']['short_name'] ?? '' }}" required>
                                                              @if ($errors->has('short_name'))
                                                                  <span class="invalid-feedback" role="alert">
                                                                      <strong>{{ $errors->first('short_name') }}</strong>
                                                                  </span>
                                                              @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Start URL</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                               <input type="text" name="start_url" class="form-control {{ $errors->has('start_url') ? ' is-invalid' : '' }}" value="{{ $pwa->data['manifest']['start_url'] ?? '' }}" required>
                                                              @if ($errors->has('start_url'))
                                                                  <span class="invalid-feedback" role="alert">
                                                                      <strong>{{ $errors->first('start_url') }}</strong>
                                                                  </span>
                                                              @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Backgroud Color</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="color" name="background_color" class="form-control form-control-color" value="{{ $pwa->data['manifest']['background_color'] ?? '' }}" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Theme Color</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="color" name="theme_color" class="form-control form-control-color" value="{{ $pwa->data['manifest']['theme_color'] ?? '' }}" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Display Type</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <select name="display" class="form-control" required>
                                                                    <option value="standalone" {{ ($pwa->data['manifest']['display'] == 'standalone') ? 'selected=selected': false }}>Standalone</option>
                                                                    <option value="fullscreen" {{ ($pwa->data['manifest']['display'] == 'fullscreen') ? 'selected=selected': false }} >Fullscreen</option>
                                                                    <option value="minimal-ui" {{ ($pwa->data['manifest']['display'] == 'minimal-ui') ? 'selected=selected': false }} >Minimal UI</option>
                                                                    <option value="browser" {{ ($pwa->data['manifest']['display'] == 'browser') ? 'selected=selected': false }} >Browser</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="dropdown-divider"></div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            @foreach($pwa->data['manifest']['icons'] as $key => $icon)
                                                            <div class="col-md-4">
                                                                <span>Icon {{ $key }}</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <fieldset class="form-group">
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" id="{{ $key }}" name="icons[{{ $key }}]" accept="image/x-png">
                                                                        <label class="custom-file-label" for="{{ $key }}">{{ $key }} - All icons must be png format</label>
                                                                    </div>
                                                                </fieldset>
                                                                 <img src="{{ $icon['path'] }}" alt="{{ $key }}" style="max-width:100px;">
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <div class="dropdown-divider"></div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                             @foreach($pwa->data['manifest']['splash'] as $splash => $path)
                                                            <div class="col-md-4">
                                                                <span>Splash {{ $splash }}</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <fieldset class="form-group">
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" id="{{ $splash }}" name="splashes[{{$splash }}]" accept="image/x-png">
                                                                        <label class="custom-file-label" for="{{ $splash }}">{{ $splash }} - All icons must be png format</label>
                                                                    </div>
                                                                </fieldset>
                                                                 <img src="{{ $path }}" alt="{{ $splash }}" style="max-width:100px;">
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8 offset-md-4">
                                                        <button type="submit" class="btn btn-primary mr-1 mb-1">Update</button>
                                                        <button type="reset" class="btn btn-outline-warning mr-1 mb-1">Reset</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- // Basic Horizontal form layout section end -->
            </div>
        </div>
    </div>
    <!-- END: Content-->


    <!-- BEGIN: Vendor JS-->
    <script src="/pwa/assets/js/vendors.min.js"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="/pwa/assets/js/jquery.sticky.js"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="/pwa/assets/js/app-menu.js"></script>
    <script src="/pwa/assets/js/app.js"></script>
    <script src="/pwa/assets/js/components.js"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="/pwa/assets/js/form-tooltip-valid.js"></script>
    <!-- END: Page JS-->
</body>
<!-- END: Body-->

</html>