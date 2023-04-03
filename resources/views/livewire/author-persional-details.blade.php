<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
    <form action="post" wire:submit.prevent='UpdateDetail()'>
        <div class="row">
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control" name="example-text-input" placeholder="Input name" wire:model='name'>
                    <span class="text-danger">
                        @error('name')
                        {{ $message }}      
                        @enderror
                           
                    </span> 
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" class="form-control" name="example-text-input" placeholder="Input username " wire:model='username'>
                    <span class="text-danger">
                        @error('username')
                        {{ $message }}      
                        @enderror
                           
                    </span> 
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="text" class="form-control" wire:model='email' name="example-text-input" placeholder="Input email" disabled>
                    <span class="text-danger">
                        @error('email')
                        {{ $message }}      
                        @enderror
                           
                    </span> 
                </div>
            </div>

        </div>
        <div class="mb-3">
            <label class="form-label">Biography<span class="form-label-description">56/100</span></label>
            <textarea wire:model='biography' class="form-control" name="example-textarea-input" rows="6" placeholder="Content..">Biography.....</textarea>
        </div>
        <button class="btn btn-primary" type="submit">Save Changes</button>
    </form>
</div>
