<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}

</div>
<div>

  @if (Session::get('fail'))
        <div class="alert alert-danger">{{ Session::get('fail') }}</div>
        
    @endif

    @if (Session::get('success'))
        <div class="alert ">{{ Session::get('success') }}</div>
    @endif

   
    <div style="margin: 0 auto" class="card col-md-8 md-8 card-md">
      <div class="card-body">
        <h2 class="h2 text-center mb-4">User Register To Blog</h2>
        <form action="{{ route('register') }}"   method="POST"  autocomplete="off" novalidate="">
          @csrf
          <div class="mb-3">
            <label class="form-label">Fullname</label>
            <input type="text" class="form-control" placeholder="Enter fullname " value="{{ old('fullname') }}" id="email"  name="fullname" autocomplete="off">
            @error('fullname')
                <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
          <div class="mb-3">
            <label class="form-label">Email </label>
            <input type="text" class="form-control" placeholder="Enter email " value="{{ old('email') }}" id="email"  name="email" autocomplete="off">
            @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
          <div class="mb-3">
            <label class="form-label">Username </label>
            <input type="text" class="form-control" placeholder="Enter username "  name="username"  value="{{ old('username') }}"  autocomplete="off">
            @error('username')
                <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
          <div class="mb-2">
            <label class="form-label">
              Password
            </label>
            <div class="input-group input-group-flat">
              <input type="password" class="form-control" placeholder="Your password" autocomplete="off" name="password" value="{{ old('password') }}" >
              <span class="input-group-text">
                <a href="#" class="link-secondary" data-bs-toggle="tooltip" aria-label="Show password" data-bs-original-title="Show password"><!-- Download SVG icon from http://tabler-icons.io/i/eye -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 12m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path><path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7"></path></svg>
                </a>
              </span>
             
            </div>
            @error('password')
            <span class="text-danger">{{ $message }}</span>
          @enderror
          </div>
          <div class="mb-2">
            <label class="form-label">
              Confirm Password
            </label>
            <div class="input-group input-group-flat">
              <input type="password" class="form-control" placeholder="Your password" autocomplete="off" value="{{ old('confirm_password') }}"  name="confirm_password">
              <span class="input-group-text">
                <a href="#" class="link-secondary" data-bs-toggle="tooltip" aria-label="Show password" data-bs-original-title="Show password"><!-- Download SVG icon from http://tabler-icons.io/i/eye -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 12m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path><path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7"></path></svg>
                </a>
              </span>
             
            </div>
            @error('confirm_password')
            <span class="text-danger">{{ $message }}</span>
          @enderror
          </div>
         
          <div class="form-footer">
            <button type="submit" class="btn btn-primary w-100">Sign in</button>
          </div>
      </form>
        
      </div>
      
    </div>
    
</div>

