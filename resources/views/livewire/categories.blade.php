<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
    <div class="row mt-3">
        
      
      <div class="col-md-6 mb-2">
            <div class="card">
                <div class="card-header">
                  <ul class="nav nav-tabs card-header-tabs">
                    <h4>Categories</h4>
                    <li class="nav-item ms-auto">
                        <a href="" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#categories_modal">Add Category</a>
                    </li>
                  </ul>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table table-striped">
                          <thead>
                            <tr>
                              <th>Categories Name</th>
                            
                              <th>N. of Categories</th>
                              
                              <th class="w-1"></th>
                            </tr>
                          </thead>
                          <tbody>
                            @forelse ($categories as $category)
                                
                           
                            <tr>
                              <td  style="font-size: 13px ">{{ $category->category_name }}</td>
                              
                              <td class="text-muted" style="font-size: 13px ">
                                {{ $category->subcategories->count() }}
                              </td>
                              <td >
                                <div class="btn-group">
                                    <div class="btn btn-primary btn-sm" wire:click.prevent='editCategory({{ $category->id }})'>Edit</div> &nbsp;
                                    <div class="btn btn-danger btn-sm" wire:click.prevent='deleteCategory({{ $category->id }})'>Delete</div>
                                </div>
                              </td>
                              
                            </tr>
                            @empty
                                <tr>
                                  <td colspan="3"><span class="text-danger">No Category found.</span></td>
                                </tr>
                            @endforelse
                           
                          </tbody>
                        </table>
                      </div>
                </div>
              </div>
        </div>

       
    
        <div class="col-md-6 mb-2">
            <div class="card">
                <div class="card-header">
                  <ul class="nav nav-tabs card-header-tabs">
                    <h4>SubCategories</h4>
                    <li class="nav-item ms-auto">
                        <a href=""  data-bs-toggle="modal" data-bs-target="#subcategories_modal" class="btn btn-primary btn-sm">Add Category</a>
                    </li>
                  </ul>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table table-striped">
                          <thead>
                            <tr>
                                <th>SubCategories Name</th>
                                <th>Parent Category</th>
                                <th>N. of posts</th>
                              <th class="w-1"></th>
                            </tr>
                          </thead>
                          <tbody>
                           @forelse ($subcategories as $subcategory)
                            <tr>
                              <td style="font-size: 13px ">{{ $subcategory->subcategory_name }}</td>
                              <td style="font-size: 13px " class="text-muted">
                                {{-- {{ $subcategory->parentcategory->category_name}} --}}
                                {{$subcategory->parent_category !=0 ? $subcategory->parentcategory->category_name:'-' }}
                              </td>
                              <td style="font-size: 13px " class="text-muted">
                                
                                {{ $subcategory->posts->count() }}
                                
                                
                              </td>
                              <td >
                                <div class="btn-group">
                                    <div class="btn btn-primary btn-sm" wire:click.prevent='editSubCategory({{ $subcategory->id }})'>Edit</div> &nbsp;
                                    <div class="btn btn-danger btn-sm" wire:click.prevent='deleteSubCategory({{ $subcategory->id }})'>Delete</div>
                                </div>
                              </td>
                              
                            </tr>

                            @empty
                            <tr>
                              <td colspan="3"><span class="text-danger">No Category found.</span></td>
                            </tr>
                               
                           @endforelse
                           
                          </tbody>
                        </table>
                      </div>
                </div>
              </div>
        </div>
      </div>
    
      {{-- modal categories--}}
      <div class="modal modal-blur fade"  id="categories_modal" data-bs-backdrop="static" wire:ignore.self data-bs-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <form class="modal-content" method="post"@if ($updateCategoryMode)
              wire:submit.prevent='updateCategory()';
            @else
                wire:submit.prevent='addCategory()';
            @endif>
            
            <div class="modal-header">
              <h5 class="modal-title">{{ $updateCategoryMode ? 'Update Category':'Add Category'}}</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              @if ($updateCategoryMode)
                  <input type="hidden" wire:model='selected_category_id'>
              @endif
                <div class="mb-3">
                    <label class="form-label">Category name</label>
                    <input type="text" class="form-control" wire:model='category_name' name="example-text-input" placeholder="Input Category name" >
                    <span class="text-danger">
                        @error('category_name')
                            {{ $message }}
                        @enderror
                    </span>
                  </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" >{{ $updateCategoryMode ? 'Update':'Save' }}</button>
            </div>
        </form>
        </div>
      </div>
    
      {{-- subcategories --}}
      <div class="modal modal-blur fade" id="subcategories_modal" data-bs-backdrop="static"  wire:ignore.self data-bs-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <form class="modal-content" method="post" @if ($updateSubCategoryMode)
            wire:submit.prevent='updateSubCategory()';
          @else
              wire:submit.prevent='addSubCategory()';
          @endif>
            <div class="modal-header">
              <h5 class="modal-title">{{ $updateSubCategoryMode ? 'Update SubCategory':'Add SubCategory'}}</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              @if ($updateSubCategoryMode)
                  <input type="hidden" wire:model='selected_subcategory_id'>
              @endif
                <div class="mb-3">
                    <div class="form-label">Parent Category</div>
                    <select class="form-select" wire:model='parent_category'>
                      {{-- @if (!$updateSubCategoryMode) --}}
                          <option value="0">None</option>
                      {{-- @endif --}}
                      @foreach (\App\Models\Category::all() as $category)
                          <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                      @endforeach
                      
                    </select>
                    <span class="text-danger">
                      @error('parent_category')
                          {{ $message }}
                      @enderror
                    </span>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Subcategory Name</label>
                    <input type="text" class="form-control" name="example-text-input" placeholder="Input Subcategory name" wire:model='subcategory_name'>
                    <span class="text-danger">
                        @error('subcategory_name')
                            {{ $message }}
                        @enderror
                    </span>
                  </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" >{{ $updateSubCategoryMode ? 'Update':'Save' }}</button>
            </div>
        </form>
        </div>
      </div>
</div>
