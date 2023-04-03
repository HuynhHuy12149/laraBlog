<div>
    {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
    <form method="post" wire:submit.prevent='updateGeneralSettings()'>
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="" class="form-lable">Blog Name</label>
                    <input type="text" class="form-control" placeholder="Enter blog name " wire:model='blog_name'>
                    <span class="text-danger">
                        @error('blog_name')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="mb-3">
                    <label for="" class="form-lable">Blog Email</label>
                    <input type="text" wire:model='blog_email' class="form-control" placeholder="Enter blog email ">
                    <span class="text-danger">
                        @error('blog_email')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="mb-3">
                    <label for="" class="form-lable">Blog Description</label>
                    <textarea  id="" cols="3" rows="3" wire:model='blog_description' class="form-control"></textarea>
                    <span class="text-danger">
                        @error('blog_description')
                            {{ $message }}
                        @enderror
                    </span>
                </div>

                <button class="btn btn-primary">Save Changes</button>
            </div>
        </div>
    </form>
</div>
