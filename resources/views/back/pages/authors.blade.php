@extends('back.layouts.pages-layout')
@section('pageTitle',isset($pageTitle)?$pageTitle:'Authors')
    
@section('content')
    
    @livewire('authors')
@endsection

@push('scripts')

    <script>
        $(window).on('hidden.bs.modal',function(){
            Livewire.emit('resetForm');
        });

        window.addEventListener('hide_add_author_modal',function(e){
        $('#add_author_modal').modal('hide');
        });

        window.addEventListener('showEditAuthorModal',function(e){
        $('#update_author_modal').modal('show');
        });

        window.addEventListener('hideEditAuthorModal',function(e){
        $('#update_author_modal').modal('hide');
        });


        window.addEventListener('deleteAuthor',function(e){
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
                    Livewire.emit('deleteAuthorAction',e.detail.id);
                }
            });
        });
    </script>
    
    
@endpush