<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    <form action="" method="post" wire:submit.prevent='UpdatePassword()'>
        <div class="row">
            <div class="col-md-4">
              <div class="mb-3">
                  <label class="form-label">Current Password</label>
                  <input type="password" class="form-control" name="example-text-input" placeholder="Input Current Password" wire:model='current_password'>
                  <span class="text-danger">
                      @error('current_password')
                      {{ $message }}      
                      @enderror
                        
                  </span> 
                </div>
            </div>

            <div class="col-md-4">
              <div class="mb-3">
                  <label class="form-label">New Password</label>
                  <input type="password" class="form-control" name="example-text-input" placeholder="Input New Password" wire:model='new_password'>
                  <span class="text-danger">
                      @error('new_password')
                      {{ $message }}      
                      @enderror
                        
                  </span> 
                </div>
            </div>

            <div class="col-md-4">
              <div class="mb-3">
                  <label class="form-label">Confirm Password</label>
                  <input type="password" class="form-control" name="example-text-input" placeholder="Input Confirm Password" wire:model='confirm_password'>
                  <span class="text-danger">
                      @error('confirm_password')
                      {{ $message }}      
                      @enderror
                        
                  </span> 
                </div>
            </div>
        </div>
        <button class="btn btn-primary" type="submit">Save Changes</button>
      </form>
</div>
