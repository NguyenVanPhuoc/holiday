<?php
use App\TableContentDetails;
use App\TableContents;


if(!function_exists('getTableContent')){
	function getTableContent($post_id, $post_type){
		$tableContent = TableContents::where('post_type', $post_type)->where('post_id', $post_id)->first();
		return $tableContent;
	}
}

if(!function_exists('getTableContentDetails')){
	function getTableContentDetails($table_id){
		$tableDetails = TableContentDetails::orderBy('sequence', 'asc')
									->where('table_id', $table_id)->get();
		return $tableDetails;
	}
}
if(!function_exists('getTableDetailByParent')){
	function getTableDetailByParent($parent_id){
		$tableDetails = TableContentDetails::orderBy('sequence', 'asc')
									->where('parent_id', $parent_id)->get();
		return $tableDetails;
	}
}
if(!function_exists('getTableDetailLevel1')){
	function getTableDetailLevel1($table_id){
		$tableDetails = TableContentDetails::orderBy('sequence', 'asc')->where('level', 1)
									->where('table_id', $table_id)->get();
		return $tableDetails;
	}
}


if(!function_exists('tableContent')){
	function tableContent($number_item, $id, $position, $level = 1){
		$html = '';
		$array = [];
		$rowContent = TableContentDetails::find($id);
		$listChild = getTableDetailByParent($id);

		$html .= '<tr class="edit" data-position="'. $position .'" data-id="'. $id .'">';
			$html .= '<td>'. $number_item .'</td>'; //column 1
			$html .= '<td>'; //column 2
				$html .= '<div class="tb-title field-row">';
					$html .= '<div class="row-left">';
						$html .= '<label>Title</label>';
					$html .= '</div>';
					$html .= '<div class="row-right">';
						$html .= '<input name="tb-title-'. $number_item .'" class="form-control" value="'. $rowContent->title .'" />';
					$html .= '</div>';
				$html .= '</div>';

				$html .= '<div class="tb-content field-row">';
					$html .= '<div class="row-left">';
						$html .= '<label>Content</label>';
					$html .= '</div>';
					$html .= '<div class="row-right">';
						$html .= '<textarea name="tb-content-'. $number_item .'" id="tb_content_'. $id .'" class="tb-content" >'. $rowContent->content .'</textarea>';
					$html .= '</div>';
				$html .= '</div>';

				//add child btn
				if($level < 3){
					$html .= '<div class="tb-child field-row">';
						$html .= '<div class="row-left">';
							$html .= '<label>Children (level '. intval($level + 1) .')</label>';
						$html .= '</div>';
						
							$html .= '<div class="wrap-child">';
								$html .= '<table class="field block-style">';
									$html .= '<tbody class="sortable-lv-'. intval($level + 1) .'">';
										//if have child
										if($listChild){
											foreach ($listChild as $key => $value) {
												$number_child = $number_item;
												$number_child .= '.' . intval($key+1);
												$html .= tableContent($number_child, $value->id, $value->sequence, $value->level);
											}
										}
									$html .= '</tbody>';
								$html .= '</table>';
							$html .= '</div>';
						
						$html .= '<div class="row-right text-right">';
							$html .= '<a href="javascript:void(0)" class="btn add-child">Add child</a>';
						$html .= '</div>';
					$html .= '</div>';
				}
			$html .= '</td>';

			$html .= '<td class="delete text-center">';  //column 3
				$html .= '<div class="del-tooltip">';
					$html .= '<a href="#" class="remove-row"><span>─</span></a>';
					$html .= '<div class="tooltip">';
						$html .= '<div class="wrap">Bạn đồng ý xóa?';
							$html .= '<div id="d-yes"><a href="'. route('deleteRowContent') .'" class="yes">Đồng ý</a></div>';
							$html .='<div id="d-no"><a href="#" class="no">Hủy</a></div>';
						$html .= '</div>';
					$html .= '</div>';
				$html .= '</div>';
			$html .= '</td>';
		$html .= '</tr>';
		return $html;
	}
}

//delete list child if delete a item
function deleteListChildContent($id){
    $child = TableContentDetails::where('parent_id', $id)->get();
    if($child):
        foreach ($child as $value) {
            deleteListChildContent($value->id);
            $value->delete();
        }
    endif;
}

//get content of table content
if(!function_exists('getContentTbContent')){
	function getContentTbContent($id, $level = 1){
		$rowContent = TableContentDetails::find($id);
		$listChild = getTableDetailByParent($id);
		$html = '';
		$html .= '<div id="tb-content-'. $id .'" class="item-tb-content">';
			if($level == 1)
				$html .= '<h2 class="pink">'. $rowContent->title .'</h2>';
			elseif($level == 2)
				$html .= '<h3 class="pink">'. $rowContent->title .'</h3>';
			else
				$html .= '<h4 class="pink">'. $rowContent->title .'</h4>';
			$html .= '<div class="text">'. $rowContent->content .'</div>';
		$html .= '</div>';
		if($listChild){
			$level++;
			foreach ($listChild as $key => $value) {
				$html .= getContentTbContent($value->id, $level);
			}
		}
		return $html;
	}
}
//get content of table content
if(!function_exists('getContentTbContentMarket')){
	function getContentTbContentMarket($id, $level = 1){
		$rowContent = TableContentDetails::find($id);
		$listChild = getTableDetailByParent($id);
		$html = '';
		$html .= '<div id="tb-content-'. $id .'" class="item-tb-content">';
			if($level == 1)
				$html .= '<h3 class="pink">'. $rowContent->title .'</h3>';
			elseif($level == 2)
				$html .= '<h4 class="pink">'. $rowContent->title .'</h4>';
			else
				$html .= '<h4 class="pink">'. $rowContent->title .'</h4>';
			$html .= '<div class="text">'. $rowContent->content .'</div>';
		$html .= '</div>';
		if($listChild){
			$level++;
			foreach ($listChild as $key => $value) {
				$html .= getContentTbContentMarket($value->id, $level);
			}
		}
		return $html;
	}
}
//get list heading of table content
if(!function_exists('getHeadingTbContent')){
	function getHeadingTbContent($id, $level = 1){
		$rowContent = TableContentDetails::find($id);
		$listChild = getTableDetailByParent($id);
		$html = '';
		
		$html .= '<li>';
			$html .= '<a href="#tb-content-'. $id .'">'. $rowContent->title .'</a>';
			if($listChild){
				$level++;
				$html .= '<ol>';
				foreach ($listChild as $key => $value) {
					$html .= getHeadingTbContent($value->id, $level);
				}
				$html .= '</ol>';
			}
		$html .= '</li>';
		
		return $html;
	}
}


/*
* create table content
* @param string $str_content, string $post_type, int $post_id
*/
if(! function_exists('createTableContent')){
	function createTableContent($str_content, $post_type, $post_id){
		$tableContent = json_decode($str_content);

		$tablePost = new TableContents;
        $tablePost->post_type = $post_type;
        $tablePost->post_id = $post_id;
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
}

/*
* update table content
* @param string $str_content, string $post_type, int $post_id
*/
if(! function_exists('updateTableContent')){
	function updateTableContent($str_content, $post_type, $post_id){
		//create a new table
        $tablePost = getTableContent($post_id, $post_type);
        $tableContent = json_decode($str_content);

        if(!$tablePost) {
            $tablePost = new TableContents;
            $tablePost->post_type = $post_type;
            $tablePost->post_id = $post_id;
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
}