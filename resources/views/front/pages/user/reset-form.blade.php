@extends('front.layouts.pages-layout')
@section('pageTitle', @isset($pageTitle) ? $pageTitle : 'Reset form')
@section('content')
   
    @if(session()->has('user'))
        
             @livewire('home')
       
    
       
    @else
        
            
            @livewire('forgot-user')
        
    @endif
    
    
        
    


@endsection
@push('scripts')
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
@endpush
