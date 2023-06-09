<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use App\Models\Post;

class Categories extends Component
{
    public $category_name;
    public $selected_category_id;
    public $updateCategoryMode = false;

    public $subcategory_name,$selected_subcategory_id, $updateSubCategoryMode = false ,$parent_category =0;

    protected $listeners =[
        'resetModalForm',
        'deleteCategoryAction',
        'deleteSubCategoryAction',
        'updateCategoryOrdering',
        'updateSubCategoryOrdering'
    ];
    

    public function resetModalForm(){
        // console.log('Resetting form...');
        $this->resetErrorBag();
        $this->category_name = $this->subcategory_name=$this->parent_category = null;
    }

    public function addCategory(){
        $this->validate([
            'category_name'=>'required|unique:categories,category_name',

        ]);
        $category = new Category();
        $category->category_name=$this->category_name;
        $saved = $category->save();
        $this->resetErrorBag();

        if($saved){
            $this->dispatchBrowserEvent('hideCategoriesModal');
            $this->category_name=null;
            $this->showToastr('New category has been successfully added','success');
        }else{
            $this->showToastr('Something Went wrong','error');
        }

    }
    public function editCategory($id){
        $category = Category::findOrFail($id);
        $this->selected_category_id = $this->id;
        $this->category_name = $category->category_name;
        $this->updateCategoryMode= true;
        $this->resetErrorBag();
        $this->dispatchBrowserEvent('showcategoriesmodal');
    }

    public function updateCategory(){
        if($this->selected_category_id){
            $this->validate([
                'category_name'=>'required|unique:categories,category_name,'.$this->selected_category_id,

            ]);
            $category = Category::findOrFail($this->selected_category_id);
            $category->category_name = $this->category_name;
            $updated = $category->save();
            
            if($updated){   
                $this->dispatchBrowserEvent('hideCategoriesModal');
                $this->updateCategoryMode = false;
                $this->showToastr('Category has been succesfully updated','success');
            }else{
                $this->showToastr('Something Went wrong','error');
            };
        };
    }


    // add and edit subcategory
    public function addSubCategory(){
        $this->validate([
            'subcategory_name'=>'required|unique:sub_categories,subcategory_name',
            'parent_category'=>'required',

        ]);
        
        $subcategory = new SubCategory();
        $subcategory->subcategory_name=$this->subcategory_name;
        $subcategory->slug=Str::slug($this->subcategory_name);
        $subcategory->parent_category=$this->parent_category;
        $saved = $subcategory->save();

        if($saved){
            $this->dispatchBrowserEvent('hideSubCategoriesModal');
            $this->subcategory_name=$this->parent_category=null;
            $this->showToastr('New SubCategory has been successfully added','success');
        }else{
            $this->showToastr('Something Went wrong','error');
        }

    }

    public function editSubCategory($id){
        $subcategory = SubCategory::findOrFail($id);
        $this->selected_subcategory_id = $subcategory->id;
        $this->subcategory_name = $subcategory->subcategory_name;
        $this->parent_category = $subcategory->parent_category;

        $this->updateSubCategoryMode= true;
        $this->resetErrorBag();
        $this->dispatchBrowserEvent('showsubcategoriesmodal');
    }

    public function updateSubCategory(){
        if($this->selected_subcategory_id){
            $this->validate([
                'subcategory_name'=>'required|unique:sub_categories,subcategory_name,'.$this->selected_subcategory_id,
                'parent_category'=>'required'

            ]);
            $subcategory = SubCategory::findOrFail($this->selected_subcategory_id);
            $subcategory->subcategory_name = $this->subcategory_name;
            $subcategory->slug = Str::slug($this->subcategory_name);
            $subcategory->parent_category = $this->parent_category;
            $updated = $subcategory->save();
            
            if($updated){   
                $this->dispatchBrowserEvent('hideSubCategoriesModal');
                $this->updateSubCategoryMode = false;
                $this->showToastr('SubCategory has been succesfully updated','success');
            }else{
                $this->showToastr('Something Went wrong','error');
            };
        };
    }

    // gọi form xoa và xóa bên category
    public function deleteCategory($id){
        $category = Category::find($id);
       $this->dispatchBrowserEvent('deleteCategory',[
            'title'=>'Are you Sure ?',
            'html'=>'You want to delete Category : <br><b>'.$category->category_name.'</b> category',
            'id'=>$id,
       ]);

    }
    
    public function deleteCategoryAction($id){
        
        $category = Category::where('id',$id)->first();
        $subcategories = SubCategory::where('parent_category',$category->id)->whereHas('posts')->with('posts')->get();
        if(!empty($subcategories ) && count($subcategories)>0){
            $totalPosts =  0;
            foreach($subcategories as $subcategory){
                $totalPosts += Post::where('category_id',$subcategory->id)->get()->count();
            }
            $this->showToastr('This category has ('.$totalPosts.') posts related to it, cannot be deleted','error');
        }else {
            SubCategory::where('parent_category',$category->id)->delete();
            $category->delete();
            $this->showToastr('Category has been successfully deleted','info');
        }
    }


    

    // // gọi form xoa và xóa bên subcategory
    public function deleteSubCategory($id){
        $subcategory = SubCategory::find($id);
       $this->dispatchBrowserEvent('deleteSubCategory',[
            'title'=>'Are you Sure ?',
            'html'=>'You want to delete subCategory : <br><b>'.$subcategory->subcategory_name.'</b> category',
            'id'=>$id,
       ]);

    }

    public function deleteSubCategoryAction($id){
    
        
        
        $subcategory = SubCategory::where('id',$id)->first();
        $posts = Post::where('category_id',$subcategory->id)->get()->toArray();

      
        if(!empty($posts) && count($posts)>0){
            
            $this->showToastr('This subcategory has ('.count($posts).') posts related to it, cannot be deleted','error');
        }else {
            $subcategory->delete();
            $this->showToastr('SubCategory has been successfully deleted','info');
        }
    }
    

    public function updateCategoryOrdering($positions){
        foreach($positions as $position){
            $index = $position[0];
            $newPosition = $position[1];
            Category::where('id',$index)->update([
                'ordering'=>$newPosition,
            ]);
            $this->showToastr('Catgories ordering have been successfully updated','success');
        }
    }

    public function updateSubCategoryOrdering($positions){
       
        foreach($positions as $position){
            $index = $position[0];
            $newPosition = $position[1];
            SubCategory::where('id',$index)->update([
                'ordering'=>$newPosition,
            ]);
            $this->showToastr('Catgories ordering have been successfully updated','success');
        }
    }
    public function showToastr($message,$type){
        return $this->dispatchBrowserEvent('showToastr',[
            'type'=>$type,
            'message'=>$message
        ]);
    }
    public function render()
    {
        return view('livewire.categories',[
            'categories'=>Category::orderBy('ordering','asc')->get(),
            'subcategories'=>SubCategory::orderBy('ordering','asc')->get(),
        ]);
    }
}
