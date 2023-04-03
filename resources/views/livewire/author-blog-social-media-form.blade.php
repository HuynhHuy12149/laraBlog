<div>
    {{-- The whole world belongs to you. --}}

    <form action="" wire:submit.prevent='updateBlogSocialMedia()' method="post">
        <div class="row">
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">
                Facebook
              </label>
              <input type="text" placeholder="Facebook page url" class="form-control" wire:model='facebook_url'>
              <span class="text-danger">
                @error('facebook_url')
                    {{ $message }}
                @enderror
              </span>
            </div>
            
          </div>

          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">
                Instagram
              </label>
              <input type="text" placeholder="Instagram page url" class="form-control" wire:model='instagram_url'>
              <span class="text-danger">
                @error('instagram_url')
                    {{ $message }}
                @enderror
              </span>
            </div>
            
          </div>

          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">
                Youtube
              </label>
              <input type="text" placeholder="Youtube page url" class="form-control" wire:model='youtube_url'>
              <span class="text-danger">
                @error('youtube_url')
                    {{ $message }}
                @enderror
              </span>
            </div>
            
          </div>

          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">
                LinnkIn
              </label>
              <input type="text" placeholder="Linkurl url" class="form-control" wire:model='linkedin_url'>
              <span class="text-danger">
                @error('linkedin_url')
                    {{ $message }}
                @enderror
              </span>
            </div>
            
          </div>

        </div>

        <button class="btn btn-primary" type="submit">Update</button>
      </form>
</div>
