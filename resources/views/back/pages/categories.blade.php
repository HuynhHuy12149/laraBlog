@extends('back.layouts.pages-layout')
@section('pageTitle',isset($pageTitle)?$pageTitle:'Categories')
    
@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
      <div class="row align-items-center">
        <div class="col">
          <h2 class="page-title">
            Categories & Subcategories
          </h2>
        </div>
      </div>
    </div>
  </div>

  @livewire('categories')
@endsection
@push('scripts')
    <script>
        $('#categories_modal').on('hidden.bs.modal',function(){
            Livewire.emit('resetModalForm');
        });
        $('#subcategories_modal').on('hidden.bs.modal',function(){
            Livewire.emit('resetModalForm');
        });
        window.addEventListener('hideCategoriesModal',function(e){
            $('#categories_modal').modal('hide'); 
        });

        window.addEventListener('showcategoriesmodal',function(e){
            $('#categories_modal').modal('show'); 
        });

        window.addEventListener('hideSubCategoriesModal',function(e){
            $('#subcategories_modal').modal('hide'); 
        });

        window.addEventListener('showsubcategoriesmodal',function(e){
            $('#subcategories_modal').modal('show'); 
        });

        
        // $(window).on('hidden.bs.modal',function(){
        //     Livewire.emit('resetModalForm');
        // });
          // gọi bên xóa category
        window.addEventListener('deleteCategory',function(e){
            swal.fire({
                title:e.detail.title,
                imageWidth:48,
                imageHeight:48,
                html:e.detail.html,
                showCloseButton:true,
                showCancelButton:true,
                cancelButtonText:'Cancel',
                confirmButtonText:'Yes, delete',
                cancelButtonColor:'#d33',
                confirmButonColor:'#3085d6',
                width:300,
                allowOutsideClick:false
            }).then(function(result){
                if(result.value){
                    Livewire.emit('deleteCategoryAction',e.detail.id);
                }
            });
        });
        // gọi form thông báo xóa subcategory
        window.addEventListener('deleteSubCategory',function(e){
            swal.fire({
                title:e.detail.title,
                imageWidth:48,
                imageHeight:48,
                html:e.detail.html,
                showCloseButton:true,
                showCancelButton:true,
                cancelButtonText:'Cancel',
                confirmButtonText:'Yes, delete',
                cancelButtonColor:'#d33',
                confirmButonColor:'#3085d6',
                width:300,
                allowOutsideClick:false
            }).then(function(result){
                if(result.value){
                    Livewire.emit('deleteSubCategoryAction',e.detail.id);
                }
            });
        });
    </script>
@endpush
