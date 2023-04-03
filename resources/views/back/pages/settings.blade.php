@extends('back.layouts.pages-layout')
@section('pageTitle',isset($pageTitle)?$pageTitle:'Settings')
    
@section('content')
    <div class="row align-items-center">
        <div class="col">
            <h2 class="page-title">
                Settings
            </h2>
        </div>
    </div>
    
        <div class="card">
          <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs" data-bs-toggle="tabs" role="tablist">
              <li class="nav-item" role="presentation">
                <a href="#tabs-home-14" class="nav-link active" data-bs-toggle="tab" aria-selected="true" role="tab">Genaral Settings</a>
              </li>
              <li class="nav-item" role="presentation">
                <a href="#tabs-profile-14" class="nav-link" data-bs-toggle="tab" aria-selected="false" tabindex="-1" role="tab">Logo & Favicon</a>
              </li>
              <li class="nav-item" role="presentation">
                <a href="#tabs-activity-14" class="nav-link" data-bs-toggle="tab" aria-selected="false" tabindex="-1" role="tab">Social Media</a>
              </li>
            </ul>
          </div>
          <div class="card-body">
            <div class="tab-content">
              <div class="tab-pane fade active show" id="tabs-home-14" role="tabpanel">
                
                <div>
                    @livewire('author-general-settings')
                </div>
              </div>
              <div class="tab-pane fade" id="tabs-profile-14" role="tabpanel">
             
                <div>
                  <div class="row">
                    <div class="col-md-8">
                      <h3>Set Logo</h3>
                      <div class="mb-2" style="max-width:200px;">
                        <img src="" alt="" id="logo-image-preview" class="img-thumbnail" data-ijabo-default-img="{{ \App\Models\Setting::find(1)->blog_logo }}">
                      </div>
                      <form action="{{ route('author.change-blog-logo') }}" method="post" id="changeBlogLogoForm">
                        @csrf
                        <div class="mb-2">
                          <input type="file" class="form-control"  name="blog_logo" >
                        </div>
                        <button class="btn btn-primary">Change Logo</button>

                      </form>
                    </div>
                    
                    <div class="col-md-8">
                      <hr>
                      <h3>Set Favicon</h3>
                      <div class="mb-2" style="max-width:200px;">
                        <img src="" alt="" id="favicon-image-preview" class="img-thumbnail" data-ijabo-default-img="{{ \App\Models\Setting::find(1)->blog_favicon }}">
                      </div>
                      <form action="{{ route('author.change-blog-favicon') }}" method="post" id="changeBlogFaviconForm">
                        @csrf
                        <div class="mb-2">
                          <input type="file" class="form-control"  name="blog_favicon" >
                        </div>
                        <button class="btn btn-primary">Change Favicon</button>

                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="tabs-activity-14" role="tabpanel">
                
                <div>

                  @livewire('author-blog-social-media-form')
                </div>
              </div>
            </div>
          </div>
        </div>
      
@endsection

@push('scripts')
<script>
  $('input[name="blog_logo"]').ijaboViewer({
          preview : '#logo-image-preview',
          imageShape:'rectangular',
          allowedExtensions: ['jpg', 'jpeg','png'],
          
          // onSuccess:function(message, element, status){
          //   //  alert(message);
          //   livewire.emit('updateAuthorProfileHeader');
          //   livewire.emit('updateTopHeader') ;
          //   toastr.success(message);
          // },
          onSuccess:function(message, element){
           
            // livewire.emit('updateAuthorProfileHeader');
            // livewire.emit('updateTopHeader') ;
            // toastr.success(message);
          },
          onErrorShape:function(message, element){
            // toastr.error(message);
            alert(message);
          },
          onInvalidType:function(message, element){
            // toastr.error(message);
            alert(message);
          }

  });

  $('#changeBlogLogoForm').submit(function(e){
    e.preventDefault();
    var form = this;
    $.ajax({
      url:$(form).attr('action'),
      method:$(form).attr('method'),
      data:new FormData(form),
      processData:false,
      dataType:'json',
      contentType:false,
      beforeSend: function(){},
      success:function(data){
        toastr.remove();
        if(data.status==1){
          toastr.success(data.msg);
          $(form)[0].reset();
          Livewire.emit('updateTopHeader');
        }else{  
          toastr.error(data.msg);
        }
      }
    });
  });

  $('input[name="blog_favicon"]').ijaboViewer({
          preview : '#favicon-image-preview',
          imageShape:'square',
          allowedExtensions: ['ico'],
          
          // onSuccess:function(message, element, status){
          //   //  alert(message);
          //   livewire.emit('updateAuthorProfileHeader');
          //   livewire.emit('updateTopHeader') ;
          //   toastr.success(message);
          // },
          onSuccess:function(message, element){
           
            // livewire.emit('updateAuthorProfileHeader');
            // livewire.emit('updateTopHeader') ;
            // toastr.success(message);
          },
          onErrorShape:function(message, element){
            // toastr.error(message);
            alert(message);
          },
          onInvalidType:function(message, element){
            // toastr.error(message);
            alert(message);
          }

  });

  $('#changeBlogFaviconForm').submit(function(e){
    e.preventDefault();
    var form = this;
    $.ajax({
      url:$(form).attr('action'),
      method:$(form).attr('method'),
      data:new FormData(form),
      processData:false,
      dataType:'json',
      contentType:false,
      beforeSend: function(){},
      success:function(data){
        toastr.remove();
        if(data.status==1){
          toastr.success(data.msg);
          $(form)[0].reset();
          Livewire.emit('updateTopHeader');
        }else{  
          toastr.error(data.msg);
        }
      }
    });
  });
</script>

    
@endpush