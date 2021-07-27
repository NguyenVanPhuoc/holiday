<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\SubCulturals;
use App\Media;
use App\Seo;
use App\TableContentDetails;
use App\TableContents;

class SubCulturalAdminController extends Controller
{
	public function index(){    	
    	$subCulturals = SubCulturals::orderBy('created_at', 'desc')->paginate(14);
    	return view('backend.subCulturals.list',['subCulturals'=>$subCulturals]);
    }

    public function store(){
        return view('backend.subCulturals.create');
    }

    public function create(Request $request){
        $msg = 'error';
        if($request->ajax()){
            $tableContent = json_decode($request->tableContent);
            $subCultural = new SubCulturals;
            $subCultural->title = $request->title;
            $subCultural->title_tag = $request->title_tag;
            $subCultural->slug = $request->title;
            $subCultural->desc = $request->desc;
            $subCultural->parent_id = $request->parent;
            $subCultural->image = $request->image;
            if($subCultural->save()){
                //seo
                $seo = new Seo;
                $seo->key = $request->metaKey;
                $seo->value = $request->metaValue;
                $seo->type = "sub_cultural";
                $seo->post_id = $subCultural->id;
                $seo->save();  

                //table content
                if($tableContent){
                    //create a new table
                    $tablePost = new TableContents;
                    $tablePost->post_type = "sub_cultural";
                    $tablePost->post_id = $subCultural->id;
                    if($tablePost->save()){ //create list new detail
                        foreach($tableContent as $level1){ //level 1
                            $contentLevel1 = new TableContentDetails;
                            $contentLevel1->title = $level1->title;
                            $contentLevel1->content = $level1->content;
                            $contentLevel1->parent_id = 0;
                            $contentLevel1->level = 1;
                            $contentLevel1->table_id = $tablePost->id;
                            $contentLevel1->sequence = $level1->position;
                            if($contentLevel1->save() && isset($level1->child)){ //level 2
                                $childLevel2 = $level1->child;
                                foreach($childLevel2 as $level2){
                                    $contentLevel2 = new TableContentDetails;
                                    $contentLevel2->title = $level2->title;
                                    $contentLevel2->content = $level2->content;
                                    $contentLevel2->parent_id = $contentLevel1->id;
                                    $contentLevel2->level = 2;
                                    $contentLevel2->table_id = $tablePost->id;
                                    $contentLevel2->sequence = $level2->position;
                                    if($contentLevel2->save() && isset($level2->child)){ //level 3
                                        $childLevel3 = $level2->child;
                                        foreach($childLevel3 as $level3){
                                            $contentLevel3 = new TableContentDetails;
                                            $contentLevel3->title = $level3->title;
                                            $contentLevel3->content = $level3->content;
                                            $contentLevel3->parent_id = $contentLevel2->id;
                                            $contentLevel3->level = 3;
                                            $contentLevel3->table_id = $tablePost->id;
                                            $contentLevel3->sequence = $level3->position;
                                            $contentLevel3->save();
                                        }
                                    }
                                }
                            }
                        } 
                    } 
                }
                $msg = 'success';
            }
        }
        return $msg;
    }

    public function edit($slug){
        $subCultural = SubCulturals::findBySlug($slug);
        return view('backend.subCulturals.edit', ['subCultural'=>$subCultural]);
    }

    public function update($slug, Request $request){
        $msg = 'error';
        if($request->ajax()){
            $tableContent = json_decode($request->tableContent);
            $subCultural = SubCulturals::findBySlug($slug);
            $subCultural->title = $request->title;
            $subCultural->title_tag = $request->title_tag;
            $subCultural->slug = $request->title;
            $subCultural->desc = $request->desc;
            $subCultural->parent_id = $request->parent;
            $subCultural->image = $request->image;
            if($subCultural->save()){
                //seo
                $seo = Seo::where('post_id',$subCultural->id)->where('type','sub_cultural')->first();
                if(!$seo){
                    $seo = new Seo;
                }
                $seo->key = $request->metaKey;
                $seo->value = $request->metaValue;                
                $seo->type = 'sub_cultural';
                $seo->post_id = $subCultural->id;
                $seo->save();

                //table content
                if($tableContent){
                    //create a new table
                    $tablePost = getTableContent($subCultural->id, 'sub_cultural');
                    if(!$tablePost) {
                        $tablePost = new TableContents;
                        $tablePost->post_type = "sub_cultural";
                        $tablePost->post_id = $subCultural->id;
                    }
                    if($tablePost->save()){ //create list new detail
                        foreach($tableContent as $level1){ //level 1
                            $contentLevel1 = new TableContentDetails;
                            if($level1->action == 'edit')
                                $contentLevel1 = TableContentDetails::find($level1->id);
                            $contentLevel1->title = $level1->title;
                            $contentLevel1->content = $level1->content;
                            $contentLevel1->parent_id = 0;
                            $contentLevel1->level = 1;
                            $contentLevel1->table_id = $tablePost->id;
                            $contentLevel1->sequence = $level1->position;
                            if($contentLevel1->save() && isset($level1->child)){ //level 2
                                $childLevel2 = $level1->child;
                                foreach($childLevel2 as $level2){
                                    $contentLevel2 = new TableContentDetails;
                                    if($level2->action == 'edit')
                                        $contentLevel2 = TableContentDetails::find($level2->id);
                                    $contentLevel2->title = $level2->title;
                                    $contentLevel2->content = $level2->content;
                                    $contentLevel2->parent_id = $contentLevel1->id;
                                    $contentLevel2->level = 2;
                                    $contentLevel2->table_id = $tablePost->id;
                                    $contentLevel2->sequence = $level2->position;
                                    if($contentLevel2->save() && isset($level2->child)){ //level 3
                                        $childLevel3 = $level2->child;
                                        foreach($childLevel3 as $level3){
                                            $contentLevel3 = new TableContentDetails;
                                            if($level3->action == 'edit')
                                                $contentLevel3 = TableContentDetails::find($level3->id);
                                            $contentLevel3->title = $level3->title;
                                            $contentLevel3->content = $level3->content;
                                            $contentLevel3->parent_id = $contentLevel2->id;
                                            $contentLevel3->level = 3;
                                            $contentLevel3->table_id = $tablePost->id;
                                            $contentLevel3->sequence = $level3->position;
                                            $contentLevel3->save();
                                        }
                                    }
                                }
                            }
                        } 
                    } 
                }

                $msg = 'success';
            }
        }
        return $msg;
    }


    public function delete($id){
        $seo = Seo::where('post_id',$id)->where('type','sub_cultural');
        $tableContent = TableContents::where('post_id',$id)->where('post_type','sub_cultural');
        if($seo) $seo->delete();
        if($tableContent) $tableContent->delete();
        $subCultural = SubCulturals::find($id);
        $subCultural->delete();
        return redirect()->route('subCulturalsAdmin')->with('success', 'Delete successfull.');
    }

    //deleteAll
    public function deleteAll(Request $resquest){
        $msg = "error";
        if($resquest->ajax()){
            $items = json_decode($resquest->items);
            if(count($items)>0){
                foreach($items as $id){
                    $seo = Seo::where('post_id',$id)->where('type','sub_cultural');
                    $tableContent = TableContents::where('post_id',$id)->where('post_type','sub_cultural');
                    if($seo) $seo->delete();
                    if($tableContent) $tableContent->delete();
                }
                SubCulturals::destroy($items);
            }
            $msg = "success";
        }
        return $msg;
    }

    //search
    public function search(Request $request){
        $s = $request->s;
        $parent_id = $request->parent_id;
        $subCulturals = SubCulturals::query();
        if($s != ''){
            $subCulturals = $subCulturals->where('title','like','%'.$s.'%');
        }
        if($parent_id){
            $subCulturals = $subCulturals->where('parent_id', $parent_id);
        }
        $subCulturals = $subCulturals->orderBy('created_at', 'desc')->paginate(14);
        return view('backend.subCulturals.list',['subCulturals'=>$subCulturals, 's'=>$s, 'parent_id'=>$parent_id]);
    }

}
