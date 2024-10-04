<!DOCTYPE html>
<html lang="en">
<head>
  <title>Odinbi PWA Install</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
  
<div class="container">
   <div class="page-body">
    <!-- Container-fluid starts-->
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
              <div class="row">
                  @if(!isset($pwa->data))
                  <form method="POST" action="{{ route('pwa.store') }}">
                      @csrf
                      <button class="btn btn-success mb-3 mt-3" type="submit">Make PWA</button>
                  </form>
                  @elseif(isset($pwa->data) && $pwa->status == 0)
                  <form method="POST" action="{{ route('pwa.activate') }}" class="d-inline-block">
                      @csrf
                      <button class="btn btn-success mb-3 mt-3" type="submit">Activate PWA</button>
                  </form>
                  <!-- <form method="POST" action="{{ route('pwa.delete') }}" class="d-inline-block float-right">
                      @csrf
                      @method('delete')
                      <button class="btn btn-danger mb-3 mt-3" type="submit">Delete PWA</button>
                  </form> -->
                  @elseif(isset($pwa->data) && $pwa->status == 1)
                  <form method="POST" action="{{ route('pwa.deactivate') }}" class="d-inline-block">
                      @csrf
                      <button class="btn btn-warning" type="submit">Deactivate PWA</button>
                  </form>
                  @endif
                </div>
            </div>
          </div>
        <form class="form theme-form" method="POST" action="{{ route('pwa.update') }}" enctype="multipart/form-data">
          @csrf
          @method('put')
          <div class="card">
            <div class="card-header pb-0">
              <h5>PWA Install</h5>
            </div>
            @if(session()->get('success'))
                  <div class="alert alert-success">
                      {{ session()->get('success') }}
                  </div><br/>
              @endif
              @if(!empty($errors->all()))
                  @foreach($errors->all() as $error)
                  <div class="alert alert-danger">
                      {{$error }}
                  </div>
                  @endforeach
              @endif
            {{-- PWA actions --}}
              <div class="card-body">
                <div class="row">
                  <div class="col">
                    <div class="mb-3 row">
                      <label class="col-sm-3 col-form-label">App Name</label>
                      <div class="col-sm-9">
                        <input type="text" name="name" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ $pwa->data['manifest']['name'] ?? '' }}" required>
                          @if ($errors->has('name'))
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $errors->first('name') }}</strong>
                              </span>
                          @endif
                      </div>
                    </div>
                    <div class="mb-3 row">
                      <label class="col-sm-3 col-form-label">App Short Name</label>
                      <div class="col-sm-9">
                         <input type="text" name="short_name" class="form-control {{ $errors->has('short_name') ? ' is-invalid' : '' }}" value="{{ $pwa->data['manifest']['short_name'] ?? '' }}" required>
                          @if ($errors->has('short_name'))
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $errors->first('short_name') }}</strong>
                              </span>
                          @endif
                      </div>
                    </div>
                    <div class="mb-3 row">
                      <label class="col-sm-3 col-form-label">Start URL</label>
                      <div class="col-sm-9">
                         <input type="text" name="start_url" class="form-control {{ $errors->has('start_url') ? ' is-invalid' : '' }}" value="{{ $pwa->data['manifest']['start_url'] ?? '' }}" required>
                          @if ($errors->has('start_url'))
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $errors->first('start_url') }}</strong>
                              </span>
                          @endif
                      </div>
                    </div>
                    <div class="mb-3 row">
                      <label class="col-sm-3 col-form-label">Background Color</label>
                      <div class="col-sm-9">
                        <input type="color" name="background_color" class="form-control form-control-color" value="{{ $pwa->data['manifest']['background_color'] ?? '' }}" required>
                      </div>
                    </div>
                    <div class="mb-3 row">
                      <label class="col-sm-3 col-form-label">Theme Color</label>
                      <div class="col-sm-9">
                        <input type="color" name="theme_color" class="form-control form-control-color" value="{{ $pwa->data['manifest']['theme_color'] ?? '' }}" required>
                      </div>
                    </div>
                     <div class="mb-3 row">
                      <label class="col-sm-3 col-form-label">Display Type</label>
                      <div class="col-sm-9">
                         <select name="display" class="form-control" required>
                            <option value="standalone" {{ ($pwa->data['manifest']['display'] == 'standalone') ? 'selected=selected': false }}>Standalone</option>
                            <option value="fullscreen" {{ ($pwa->data['manifest']['display'] == 'fullscreen') ? 'selected=selected': false }} >Fullscreen</option>
                            <option value="minimal-ui" {{ ($pwa->data['manifest']['display'] == 'minimal-ui') ? 'selected=selected': false }} >Minimal UI</option>
                            <option value="browser" {{ ($pwa->data['manifest']['display'] == 'browser') ? 'selected=selected': false }} >Browser</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          </div>
           {{-- PWA icons --}}
          <div class="card">
            <div class="card-header pb-0">
              <h5>Icons <span style="color: red;font-size: 12px;text-transform: none;">(All icons must be png format)</span></h5>
            </div>
              <div class="card-body">
                @foreach($pwa->data['manifest']['icons'] as $key => $icon)
                <div class="row">
                  <div class="col">
                    <div class="mb-3 row">
                      <label class="col-sm-3 col-form-label">{{ $key }}</label>
                      <div class="col-sm-9">
                        <input class="form-control" type="file" id="{{ $key }}" name="icons[{{ $key }}]" data-default_placeholder="{{ __('pwa.change-icon') }}" accept="image/x-png">
                         <img src="{{ $icon['path'] }}" alt="{{ $key }}" style="max-width:100px;">
                      </div>
                    </div>
                  </div>
                </div>
                 @endforeach
              </div>
          </div>
          {{-- PWA splashes --}}
          <div class="card">
            <div class="card-header pb-0">
              <h5>Splashes <span style="color: red;font-size: 12px;text-transform: none;">(All icons must be png format)</span></h5>
            </div>
              <div class="card-body">
                @foreach($pwa->data['manifest']['splash'] as $splash => $path)
                <div class="row">
                  <div class="col">
                    <div class="mb-3 row">
                      <label class="col-sm-3 col-form-label">{{ $splash }}</label>
                      <div class="col-sm-9">
                        <input class="form-control" type="file" id="{{ $splash }}" name="splashes[{{$splash }}]" data-default_placeholder="{{ __('pwa.change-splash') }}" accept="image/x-png">
                        <img src="{{ $path }}" alt="{{ $splash }}" style="max-width:100px;">
                      </div>
                    </div>
                  </div>
                </div>
                 @endforeach
              </div>
          </div>
           <div class="card-footer text-end">
            <button class="btn btn-primary" type="submit">Cập nhật</button>
          </div>
        </form>
      
        </div>
      </div>
    </div>
    <!-- Container-fluid Ends-->
  </div>
</div>

</body>
</html>
